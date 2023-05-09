<?php

namespace App\Controller;

use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function show(int $id): string
    {
        $articleManager = new ArticleManager();
        $pictureController = new PictureController();
        $article = $articleManager->selectOneById($id);

        $bodyArticleSplit = $this->splitArticleText($article['body_article']);

        $pictures = $articleManager->getPictures($id);
        $pictures = $pictureController->organisePictures($pictures);

        $author = $articleManager->getAuthor($id);

        return $this->twig->render('Article/show.html.twig', [
            'article' => $article,
            'bodyArticleSplit' => $bodyArticleSplit,
            'pictures' => $pictures,
            'author' => $author
        ]);
    }

    public function splitArticleText(string $bodyArticle): array
    {
        return str_split($bodyArticle, (strlen($bodyArticle) - strlen($bodyArticle) % 3) / 3);
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $article = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $articleManager = new ArticleManager();
            $id = $articleManager->insert($article);

            $pictureController = new PictureController();
            $pictureController->add($id);
            $this->show($id);
            //header('Location:/article/show?id=' . $id);
        }
        return $this->twig->render('Article/add.html.twig');
    }

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
    }
    public function search(): string
    {
        $titles = [];
        $query = [];
        if (isset($_GET['q']) and !empty($_GET['q'])) {
            $query = htmlspecialchars($_GET['q']);
            $articleManager = new ArticleManager();
            $titles = $articleManager->searchTitle($query);
        }
        return $this->twig->render('Article/search.html.twig', [
            'titles' => $titles,
            'query' => $query,
        ]);
    }
}
