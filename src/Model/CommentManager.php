<?php

namespace App\Model;

use PDO;

class CommentManager extends AbstractManager
{
    public const TABLE = 'bt_comment';
    public function insertComment($newComment): bool
    {
        $user_id = 1; //TO DO, GET THE USER_ID FROM $SESSIONS WHEN LOGGED IN
        $content = $_POST['comment'];
        $article_id = $_GET['id'];

        // Prepare SQL statement
        $stmt = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . "
            (article_id, user_id, content_comment, comment_created_at)
            VALUES (?, ?, ?, NOW())"
        );
        $stmt->bindParam(1, $article_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $content, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function selectComments(): array
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM bt_comment WHERE article_id = :article_id"
        );
        $statement->execute(['article_id' => $_GET['id']]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
