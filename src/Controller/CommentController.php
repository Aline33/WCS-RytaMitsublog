<?php

namespace App\Controller;

use App\Model\CommentManager;

class CommentController extends AbstractController
{
    public function addNewComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            //$newComment = array_map('trim', $_POST);

            $comment = new CommentManager();
            $comment->insertComment();
        }
    }

    public function selectCommentsWithUsernames(): array
    {
        $commentManager = new CommentManager();
        return $commentManager->selectCommentsWithUsernames();
    }
}
