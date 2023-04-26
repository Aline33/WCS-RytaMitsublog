<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'bt_article';

    public function getPictures(int $id): array|false
    {
        //"SELECT link FROM bt_picture WHERE " .
        // $this->getForeignKeyName(static::TABLE) . " = :id"
        $query = "SELECT link FROM bt_picture WHERE " .
            $this->getForeignKeyName(static::TABLE) .
            " = :id ORDER BY is_main DESC";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $article): int
    {
        $query = "INSERT INTO " . self::TABLE .
            "(user_id, title, description_article, body_article)
            VALUES (:user_id, :title, :description, :body)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', 1, PDO::PARAM_INT); // TODO: change user_id value
        $statement->bindValue(':title', $article['title'], PDO::PARAM_STR);
        $statement->bindValue(':description', $article['description'], PDO::PARAM_STR);
        $statement->bindValue(':body', $article['content'], PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }
}
