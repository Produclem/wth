<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sessId = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $sessData = null;

    #[ORM\Column(nullable: true)]
    private ?int $sessTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $sessLifetime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessId(): ?string
    {
        return $this->sessId;
    }

    public function setSessId(string $sessId): static
    {
        $this->sessId = $sessId;

        return $this;
    }

    public function getSessData()
    {
        return $this->sessData;
    }

    public function setSessData($sessData): static
    {
        $this->sessData = $sessData;

        return $this;
    }

    public function getSessTime(): ?int
    {
        return $this->sessTime;
    }

    public function setSessTime(?int $sessTime): static
    {
        $this->sessTime = $sessTime;

        return $this;
    }

    public function getSessLifetime(): ?int
    {
        return $this->sessLifetime;
    }

    public function setSessLifetime(?int $sessLifetime): static
    {
        $this->sessLifetime = $sessLifetime;

        return $this;
    }
}
