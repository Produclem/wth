<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/more', name: 'app_more')]
    public function more(): Response
    {
        return $this->render('index/more.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/analytics', name: 'app_analytics')]
    public function analytics(): Response
    {
        return $this->render('index/analytics.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('index/contact.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('index/dashboard.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/articles', name: 'app_articles')]
    public function articles(): Response
    {
        return $this->render('index/articles.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
