<?php

namespace App\Controller;

use App\Model\ArticleManager;

class NavbarController extends AbstractController
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
            $userController = new UserController();
            $_SESSION['errorsLogin'] = $userController->login();
            header('Location: http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController = new UserController();
            $_SESSION['errorsRegister'] = $userController->register();
            header('Location: http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        }
    }

    public function disconnect(): void
    {
        $userController = new UserController();
        $userController->disconnect();
        header('Location: http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    }

    public function modalLogin(): void
    {
        if (isset($_POST['loginSubmit']) || isset($_POST['registerSubmit']) || isset($_POST['disconnectSubmit'])) {
            if (isset($_POST['loginSubmit'])) {
                $this->login();
            }
            if (isset($_POST['registerSubmit'])) {
                $this->register();
            }
            if (isset($_POST['disconnectSubmit'])) {
                $this->disconnect();
            }
        } else {
            unset($_SESSION['errorsLogin']);
            unset($_SESSION['errorsRegister']);
        }
    }

    public function search(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['searchSubmit']) && !empty($_GET['querySearch'])) {
            array_pop($_GET);
            $querySearch = trim($_GET['querySearch']);
            $querySearch = htmlspecialchars($querySearch);
            $querySearch = htmlentities($querySearch);

            //$articleController = new ArticleController();
            //$articleController->search($querySearch);
            $articleManager = new ArticleManager();
            $pictureController = new PictureController();
            $results = $articleManager->searchTitle($querySearch);
            $finalResults = [];
            foreach ($results as $result) {
                $id = $articleManager->selectOneByTitle($result['title'])['id_article'];
                $result['pictures'] = $articleManager->getPictures($id);
                $result['pictures'] = $pictureController->organisePictures($result['pictures']);
                $result['author'] = $articleManager->getAuthor($id);
                $finalResults[] = $result;
            }
            return $finalResults;
        }
        return null;
    }
}
