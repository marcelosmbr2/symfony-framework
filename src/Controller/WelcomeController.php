<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;
use Symfony\Component\Uid\Ulid;

final class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAllWithAuthor();
        
        return $this->render('welcome/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/show/{id}', name: 'app_welcome_show')]
    public function show(string $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findByIdWithAuthor($id);

        if (!$article) {
            throw $this->createNotFoundException('Artigo não encontrado');
        }

        return $this->render('welcome/show.html.twig', [
            'article' => $article,
        ]);
    }
}