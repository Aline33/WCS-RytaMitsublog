<?php

namespace App\Model;

use PDO;

class CommentManager extends AbstractManager
{
    public const TABLE = 'bt_comment';
    public function insertComment(): bool
    {
        $userId = $_SESSION['user_id']; //TO DO, GET THE USER_ID FROM $SESSIONS WHEN LOGGED IN
        $content = $_POST['comment'];
        $articleId = $_GET['id'];

        // Prepare SQL statement
        $stmt = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . "
            (article_id, user_id, content_comment, comment_created_at)
            VALUES (?, ?, ?, NOW())"
        );
        $stmt->bindParam(1, $articleId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->bindParam(3, $content, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /* public function selectComments(): array
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM bt_comment WHERE article_id = :article_id"
        );
        $statement->execute(['article_id' => $_GET['id']]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } */

    public function selectCommentsWithUsernames(): array
    {
        $statement = $this->pdo->prepare(
            "SELECT c.*, u.user_name
         FROM bt_comment c
         INNER JOIN bt_user u ON c.user_id = u.id_user
         WHERE c.article_id = :article_id"
        );
        $statement->execute(['article_id' => $_GET['id']]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
