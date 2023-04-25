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
        $firstArtSectManager = new ArticleSectionManager();
        $articles = $firstArtSectManager->selectFirstFiveArticleByDate();

        return $this->twig->render('Home/index.html.twig', ['articles' => $articles]);
    }
}
