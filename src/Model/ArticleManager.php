<?php

namespace App\Model;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'bt_article';
    /*public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id_article=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }*/
}
