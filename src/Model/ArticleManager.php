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
                        ON p." . $this->getForeignKeyNameFromTable(static::TABLE) . "
                        = ba." . $this->getPrimaryKeyNameFromTable() . "
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
                        ON u." . $this->getPrimaryKeyNameFromTable('bt_user') . "
                        = ba." . $this->getForeignKeyNameFromTable('bt_user') . "
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

    public function getPreviousArticle($id): array
    {
        $id = $_GET['id'];

        $statement = $this->pdo->prepare(
            "SELECT id_article, title FROM bt_article WHERE id_article < :id ORDER BY id_article DESC LIMIT 1"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getNextArticle($id): array
    {
        $id = $_GET['id'];

        $statement = $this->pdo->prepare(
            "SELECT id_article, title FROM bt_article WHERE id_article > :id ORDER BY id_article LIMIT 1"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPreviousPhoto($id): array
    {
        $id = $_GET['id'];

        $statement = $this->pdo->prepare(
            "SELECT link FROM bt_picture WHERE article_id < :id AND is_main = 1 ORDER BY article_id DESC LIMIT 1"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNextPhoto($id): array
    {
        $id = $_GET['id'];

        $statement = $this->pdo->prepare(
            "SELECT link FROM bt_picture WHERE article_id > :id AND is_main = 1 ORDER BY article_id LIMIT 1"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
