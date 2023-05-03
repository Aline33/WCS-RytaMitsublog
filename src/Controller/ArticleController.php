<?php

namespace App\Controller;

use App\Model\ArticleManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ArticleController extends AbstractController
{
    public function show(int $id): string
    {
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        $bodyArticleSplit = $this->splitArticleText($article['body_article']);

        $pictures = $articleManager->getPictures($id);
        $pictures = $this->organisePictures($pictures);

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
        return str_split($bodyArticle, strlen($bodyArticle) / 3);
    }

    public function organisePictures(array $pictures): array
    {
        $iterator = 1;
        foreach ($pictures as $key => $picture) {
            if ($key === 0) {
                $pictures['pictureMain'] = $pictures[$key];
                unset($pictures[$key]);
            } else {
                $pictures['picture' . $iterator] = $pictures[$key];
                unset($pictures[$key]);
            }
            $iterator++;
        }
        return $pictures;
    }

    public function add(): string
    {
        return $this->twig->render('Article/add.html.twig');
    }

    /**
     * @param $id
     * @return int
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */


    public function edit(int $id): ?string
    {

        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $article = array_map('trim', $_POST);

            // TODO validations (length, format...)

            $articleManager->update($article);

            header('Location: /article/show?id=' . $id);
        }
        return $this->twig->render('Article/edit.html.twig', ['article' => $article]);
    }
}
