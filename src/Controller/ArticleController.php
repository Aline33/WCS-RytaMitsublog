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
}
