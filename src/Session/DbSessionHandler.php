<?php

namespace App\Session;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;
use App\Entity\Session;

class DbSessionHandler extends AbstractSessionHandler
{
    private $manager;
    private $repo;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository(Session::class);
    }

    protected function doRead($sessionId): string
    {
        // Récupère la session de la base de données
        $session = $this->repo->find($sessionId);

        return $session ? stream_get_contents($session->getSessData()) : '';
    }

    protected function doWrite($sessionId, $data): bool
    {
        // Recherche une session existante avec l'identifiant donné
        $session = $this->repo->find($sessionId);

        if (!$session) {
            // Si la session n'existe pas, crée une nouvelle session
            $session = new Session();
            $session->setSessId($sessionId);
        }

        // Met à jour les données de la session
        $session->setSessData($data); // $data est une chaîne sérialisée
        $session->setSessTime(time());
        $session->setSessLifetime(ini_get('session.gc_maxlifetime'));

        // Enregistre la session dans la base de données
        $this->manager->persist($session);
        $this->manager->flush();

        return true;
    }

    protected function doDestroy($sessionId): bool
    {
        // Supprime la session de la base de données
        $session = $this->repo->find($sessionId);
        if ($session) {
            $this->manager->remove($session);
            $this->manager->flush();
            return true;
        }

        return false;
    }

    public function updateTimestamp($sessionId, $data): bool
    {
        // Met à jour le timestamp de la session (pour le keep-alive)
        $session = $this->repo->find($sessionId);
        if ($session) {
            $session->setSessTime(time());
            $this->manager->flush();
            return true;
        }

        return false;
    }

    public function gc($maxlifetime): int | false
    {
        // Nettoie les sessions expirées
        $limit = new \DateTime();
        $limit->modify("-$maxlifetime seconds");

        $qb = $this->manager->createQueryBuilder();
        $qb->delete(Session::class, 's')
            ->where('s.sessTime < :limit')
            ->setParameter('limit', $limit->getTimestamp());

        return $qb->getQuery()->execute();
    }

    public function close(): bool
    {
        return true; // Tu peux définir le comportement de fermeture de la session ici si nécessaire
    }
}
