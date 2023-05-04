<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\ArticleSectionManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $articleSectionMgr = new ArticleSectionManager();
        $articles = $articleSectionMgr->selectFirstNineArticleByDate();

        $articleManager = new ArticleManager();
        $pictureController = new PictureController();

        $pictures = [];
        $author = [];
        foreach ($articles as $article) {
            $pictures['id_article: ' . $article['id_article']] = $articleManager->getPictures($article['id_article']);
            $pictures[
                'id_article: ' . $article['id_article']] = $pictureController->organisePictures($pictures[
                    'id_article: ' . $article['id_article']]);
            $author['id_article: ' . $article['id_article']] = $articleManager->getAuthor($article['id_article']);
        }

        $userController = new UserController();
        $loginRegister = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['loginSubmit'])) {
                $errors = $userController->login();
                $loginRegister = 1;
            }
            if (isset($_POST['registerSubmit'])) {
                $errors = $userController->register();
                $loginRegister = 2;
            }
            if (isset($_POST['disconnectSubmit'])) {
                $userController->disconnect();
            }
        } else {
            return $this->twig->render('Home/index.html.twig', [
                'articles' => $articles,
                'pictures' => $pictures,
                'author' => $author]);
        }


        if (!empty($errors)) {
            return $this->twig->render('Home/index.html.twig', [
                'articles' => $articles,
                'pictures' => $pictures,
                'author' => $author,
                'errors' => $errors,
                'loginRegister' => $loginRegister]);
        } else {
            header('Location: /');
        }
        return $this->twig->render('Home/index.html.twig', [
            'articles' => $articles,
            'pictures' => $pictures,
            'author' => $author]);
    }
}
