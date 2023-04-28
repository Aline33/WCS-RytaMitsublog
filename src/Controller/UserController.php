<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public const FIELDS = [
        'first_name' => 'string',
        'last_name' => 'string',
        'username' => 'string',
        'email' => 'email',
        'birthday' => 'date',
        'password' => 'string'
    ];

    public const FIELDS_LOGIN = [
        'username' => 'string',
        'password' => 'string'
    ];

    public const FIELDS_REGISTER = [
        'new-username' => 'string',
        'new-email' => 'email',
        'new-password' => 'string'
    ];

    // TODO : get data from $_POST,
    // TODO :  verify their safety,
    // TODO : select one user corresponding to email or username,
    // TODO : check compatibility
    // TODO :  set global $user used to test when the user is connected or not
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
            $userLogin = $this->sanitizeData($_POST, self::FIELDS_LOGIN);

            $password = $userLogin['password'];

            $userManager = new UserManager();
            $user = $userManager->selectOneByUsername($userLogin['username']);

            $username = $user['user_name'];
            $hashPassword = $user['user_password'];

            if (password_verify($password, $hashPassword)) { // password_verify($password, $hashPassword) $password === $hashPassword
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $username;
                header('Location: /article/show?id=1');
            }
        }
    }
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerSubmit'])) {
            $userRegister = $this->sanitizeData($_POST, self::FIELDS_REGISTER);
            $errors = $this->validateData($userRegister, self::FIELDS_REGISTER);

            if (empty($errors)) {
                $userManager = new UserManager();
                $userManager->insert($userRegister);
            } else {
                echo '$errors: ';
                var_dump($errors);
            }
        }
    }
}
