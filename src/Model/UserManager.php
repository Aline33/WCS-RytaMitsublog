<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'bt_user';
    // TODO : create methods to get user info depending on one field, (email and username would be good)
    public function selectOneByEmail(string $email): array | false
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectOneById(int $id): array | false
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE id_user = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectOneByUsername(string $username): array | false
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE user_name = :username";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (user_name, email, user_password)
        VALUES (:username, :email, :password)");
        $statement->bindValue(':username', $user['new-username'], PDO::PARAM_STR);
        $statement->bindValue(':email', $user['new-email'], PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($user['new-password'], PASSWORD_BCRYPT), PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function getUserArticlesAndCommentsWithPhotos(): array
    {
        $userId = 1;

        $statement = $this->pdo->prepare("
        SELECT a.*, p.link
        FROM bt_article a
        LEFT JOIN bt_picture p ON p.article_id = a.id_article
        WHERE a.user_id = :user_id AND is_main = 1
         ");
        $statement->bindValue(':user_id', $userId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
