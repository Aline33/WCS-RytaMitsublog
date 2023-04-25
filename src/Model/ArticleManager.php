<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'bt_article';

    public function getPictures(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT link FROM bt_picture WHERE " . $this->getForeignKeyName(static::TABLE) . " = :id ORDER BY is_main DESC");//"SELECT link FROM bt_picture WHERE " . $this->getForeignKeyName(static::TABLE) . " = :id"
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
