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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController = new UserController();
            if (isset($_POST['loginSubmit'])) {
                $errors = $userController->login();
            }
            if (isset($_POST['loginRegister'])) {
                $errors = $userController->register();
            }
            if (empty($errors)) {
                return $this->twig->render('contact/index.html.twig', ['articles' => $articles]);
            } else {
                return $this->twig->render('Home/index.html.twig', ['articles' => $articles, 'errors' => $errors]);
            }
        }
        return $this->twig->render('Home/index.html.twig', ['articles' => $articles]);
    }
}
