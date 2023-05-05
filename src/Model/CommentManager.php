<?php

namespace App\Model;

use PDO;

class CommentManager extends AbstractManager
{
    public const TABLE = 'bt_comment';
    public function insertComment($newComment): bool
    {
        $user_id = $_SESSION['user_id']; //TO DO, GET THE USER_ID FROM $SESSIONS WHEN LOGGED IN
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

    // WORK IN PROCESS -- Edit a comment

    public function updateComment($newComment): bool
    {
        $comment_id = $_GET['id'];
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `content_comment` =
         :comment WHERE id_comment = :comment_id");
        $statement->bindValue('comment', $newComment['content_comment'], PDO::PARAM_STR);
        $statement->bindValue('comment_id', $comment_id, PDO::PARAM_INT);

        return $statement->execute();
    }

    /* public function deleteComment()
    {
        $comment_id = $_GET['comment_id];
        $statement = $this->pdo->prepare("
        DELETE FROM " . self::TABLE . " WHERE id_comment = :id");
        $statement->bindValue('id', $comment_id)
    } */
}
