<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected PDO $pdo;

    public const TABLE = '';
    public const TABLE_ID = '';

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     */
    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE " . $this->getPrimaryKeyName() . "=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Delete row form an ID
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE " . $this->getPrimaryKeyName() . "=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getPrimaryKeyName(): string
    {
        $tableName = static::TABLE;
        return preg_replace('/bt/', 'id', $tableName);
    }

    public function getForeignKeyName(string $foreignTable): string
    {
        return preg_replace('/bt_/', '', $foreignTable) . '_id';
    }
}

/*
 *
 * TODO: replace id by regexp to find the right column
SELECT *
FROM bt_article
WHERE (SELECT 'id_' REGEXP 'id') = 1;

SELECT REGEXP_INSTR('🍣🍣b', 'b');

SELECT *
FROM bt_article
WHERE (SELECT REGEXP_REPLACE('id_', '_', '')) = 1;

SELECT REGEXP_REPLACE('id_', '_', '');
FROM bt_user;

SELECT REGEXP_REPLACE("stackoverflow", "(stack)(over)(flow)", '\\2 - \\1 - \\3');

SELECT REGEXP_SUBSTR('id_', 'id');

SELECT REGEXP_LIKE('CamelCase', 'CAMELCASE');

SELECT 'Michael!' REGEXP '.*';

SELECT REGEXP_REPLACE('a b c', 'b', 'X');
 */
