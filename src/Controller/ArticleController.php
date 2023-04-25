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
        $pictures = $articleManager->getPictures($id);
        $pictures = $this->organisePictures($pictures);

        return $this->twig->render('Article/show.html.twig', ['article' => $article, 'bodyArticleSplit' => $bodyArticleSplit, 'picture' => $pictures]);
    }

    public function splitArticleText(string $bodyArticle): array
    {
        return str_split($bodyArticle, strlen($bodyArticle) / 3);
    }

    public function organisePictures(array $pictures): array
    {
        $i = 1;
        foreach ($pictures as $key => $picture) {
            if ($key === 0) {
                $pictures['pictureMain'] = $pictures[$key];
                unset($pictures[$key]);
            } else {
                $pictures['picture' . $i] = $pictures[$key];
                unset($pictures[$key]);
            }
            $i++;
        }
        return $pictures;
    }
}
