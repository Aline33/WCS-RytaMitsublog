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
    public function update(array $article): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `id_article` = :id_article, `title` = :title,
        `description_article` = :description_article, `body_article` = :body_article WHERE id=:id_article");

        $statement->bindValue(':id', $article['id_article'], PDO::PARAM_INT);
        $statement->bindValue(':title', $article['title']);
        $statement->bindValue(':description', $article['description_article']);
        $statement->bindValue(':content', $article['body_article']);

        return $statement->execute();
    }
}
