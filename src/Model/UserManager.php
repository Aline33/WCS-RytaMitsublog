<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const FIELDS = [
      'first_name' => 'string',
        'last_name' => 'string',
        'user_name' => 'string',
        'email' => 'email',
        'birthday' => 'date',
        'user_password' => 'string'
    ];
    public const TABLE = 'bt_user';
    // TODO : create methods to get user info depending on one field, (email and username would be good)
    public function selectOneByEmail(string $email): array
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectOneByUsername(string $username): array
    {
        $query = "SELECT * FROM " . static::TABLE . " WHERE user_name = :username";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':user_name', $username, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
