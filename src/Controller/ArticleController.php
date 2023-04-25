<?php

namespace App\Controller;

class ArticleController extends AbstractController
{
    public function show(): string
    {
        return $this->twig->render('Article/show.html.twig');
    }

    public function add(): string
    {
        return $this->twig->render('Article/add.html.twig');
    }
}
