<?php

namespace App\Controller;

use App\Model\CommentManager;

class CommentController extends AbstractController
{
    public function addNewComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $newComment = array_map('trim', $_POST);

            $comment = new CommentManager();
            $comment->insertComment($newComment);
        }
    }

    public function selectCommentsWithUsernames(): array
    {
        $commentManager = new CommentManager();
        return $commentManager->selectCommentsWithUsernames();
    }

    /* WORK IN PROCESS --- EDIT COMMENT

    public function edit(int $id): ?string
    {
        $commentManager = new CommentManager();
        $comment = $commentManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = array_map('trim', $_POST);

            $commentManager->updateComment($comment);
        }
        return $this->twig->render('Article/show.html.twig');
    } */
}
