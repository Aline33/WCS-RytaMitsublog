<?php

namespace App\Controller;

use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function show(int $id): string
    {
        $navbarController = new NavbarController();
        $navbarController->modalLogin();
        if (!empty($_SESSION)) {
            $userId = $_SESSION['user_id'];
        } else {
            $userId = "";
        }

        $articleManager = new ArticleManager();
        $pictureController = new PictureController();
        $article = $articleManager->selectOneById($id);

        $bodyArticleSplit = $this->splitArticleText($article['body_article']);

        $pictures = $articleManager->getPictures($id);
        $pictures = $pictureController->organisePictures($pictures);

        $author = $articleManager->getAuthor($id);

        $commentController = new CommentController();
        $commentController->addNewComment();

        $commentController = new CommentController();
        $showComments = $commentController->selectCommentsWithUsernames();

        $articleManager = new ArticleManager();
        $previousId = $articleManager->getPreviousArticle($id);

        $articleManager = new ArticleManager();
        $nextId = $articleManager->getNextArticle($id);

        $articleManager = new ArticleManager();
        $linkPreviousPhoto = $articleManager->getPreviousPhoto($id);

        $articleManager = new ArticleManager();
        $linkNextPhoto = $articleManager->getNextPhoto($id);


        return $this->twig->render('Article/show.html.twig', [
            'article' => $article,
            'bodyArticleSplit' => $bodyArticleSplit,
            'pictures' => $pictures,
            'author' => $author,
            'showComments' => $showComments,
            'previousId' => $previousId,
            'nextId' => $nextId,
            'linkPreviousPhoto' => $linkPreviousPhoto,
            'linkNextPhoto' => $linkNextPhoto,
            'userId' => $userId,

            ]);
    }

    public function splitArticleText(string $bodyArticle): array
    {
        return str_split($bodyArticle, (strlen($bodyArticle) - strlen($bodyArticle) % 3) / 3);
    }

    public function add(): string
    {
        $navbarController = new NavbarController();
        $navbarController->modalLogin();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['articleAddSubmit'])) {
                // clean $_POST data
                $article = array_map('trim', $_POST);

                $articleManager = new ArticleManager();
                $id = $articleManager->insert($article);

                $pictureController = new PictureController();
                $pictureController->add($id);
                header('Location:/user/show');
            }
        }
        return $this->twig->render('Article/add.html.twig');
    }

/*<<<<<<< HEAD*/

    public function edit(int $id): string
    {
        $navbarController = new NavbarController();
        $navbarController->modalLogin();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
        } else {
            $articleManager = new ArticleManager();
            $article = $articleManager->selectOneById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $article = array_map('trim', $_POST);
                $articleManager->update($article);
                header('Location:/user/show');
            }
            return $this->twig->render('Article/edit.html.twig', ['article' => $article]);
        }
        return $this->twig->render('Article/edit.html.twig');
    }

    public function delete($id)
    {
        $articleManager = new ArticleManager();
        $articleManager->deletePhotos($id);

        $articleManager = new ArticleManager();
        $articleManager->deleteComments($id);

        $articleManager = new ArticleManager();
        $articleManager->deleteArticle($id);

        header('Location: /user/show');
    }
/*=======
    public function edit(int $id): ?string
    {
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $article = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $articleManager->update($article);

            header('Location: /article/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }
        return $this->twig->render('Article/edit.html.twig', [
            'article' => $article,
        ]);
    }*/
    public function search(string $querySearch): string
    {
        $titles = [];
        //$query = [];
        //if (isset($_GET['q']) and !empty($_GET['q'])) {
            $query = htmlspecialchars($querySearch);
            $articleManager = new ArticleManager();
            $titles = $articleManager->searchTitle($query);

        //}
        return $this->twig->render('Article/search.html.twig', [
            'titles' => $titles,
            'query' => $query,
        ]);
    }
}
