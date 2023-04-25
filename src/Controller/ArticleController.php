<?php

namespace App\Controller;

use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function show(int $id): string
    {
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);
        $bodyArticleSplit = $this->splitArticleText($article['body_article']);
        $picture = $articleManager->getPictures($id);

        return $this->twig->render('Article/show.html.twig', ['article' => $article, 'bodyArticleSplit' => $bodyArticleSplit, 'picture' => $picture]);
    }

    public function splitArticleText(string $bodyArticle): array
    {
        return str_split($bodyArticle, strlen($bodyArticle) / 3);
    }
}
