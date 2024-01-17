<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'index')]
    public function listArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('index/articles.html.twig', [
            'articles' => $articles,
        ]);
    }
}
