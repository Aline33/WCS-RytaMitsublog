<?php

namespace App\Controller;

class ErrorController extends AbstractController
{
    public function page404(): string
    {
        return $this->twig->render('Error/page404.html.twig');
    }

    public function page502(): string
    {
        return $this->twig->render('Error/page502.html.twig');
    }
}
