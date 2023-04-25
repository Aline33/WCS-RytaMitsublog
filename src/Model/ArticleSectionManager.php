<?php

namespace App\Model;

use PDO;

class FirstArticleSectManager extends AbstractManager
{
    public const TABLE = 'bt_article';

    public function selectFirstFiveArticleByDate(): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM `bt_article` ORDER BY article_created_at DESC LIMIT 9");
        $statement->execute();

        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $articles !== false ? $articles : false;
    }
}
