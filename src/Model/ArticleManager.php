<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'bt_article';

    public function getPictures(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            "SELECT link, " . $this->getForeignKeyNameFromTable(static::TABLE) . "
                    FROM bt_picture p
                        INNER JOIN " . static::TABLE . " ba
                        ON p." . $this->getForeignKeyNameFromTable(static::TABLE) . " = ba." . $this->getPrimaryKeyNameFromTable() . "
                        WHERE " . $this->getForeignKeyNameFromTable(static::TABLE) . " = :id"
        );
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

    public function getAuthor(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            "SELECT user_name
                    FROM bt_user u
                        INNER JOIN " . static::TABLE . " ba
                        ON u." . $this->getPrimaryKeyNameFromTable('bt_user') . " = ba." . $this->getForeignKeyNameFromTable('bt_user') . "
                        WHERE ba." . $this->getPrimaryKeyNameFromTable('bt_article') . " = :id"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
