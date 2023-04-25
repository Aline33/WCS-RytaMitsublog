<?php

namespace App\Controller;

use App\Model\ArticleSectionManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $articleSectionManager = new ArticleSectionManager();
        $articles = $articleSectionManager->selectFirstNineArticleByDate();

        return $this->twig->render('Home/index.html.twig', ['articles' => $articles]);
    }
}
