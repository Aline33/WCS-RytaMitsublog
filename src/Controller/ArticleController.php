<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ArticleController extends AbstractController
{
    public function show(): string
    {
        return $this->twig->render('Article/show.html.twig');
    }

    public function edit()
    {
        return $this->twig->render('Article/edit.html.twig');
    }
}

