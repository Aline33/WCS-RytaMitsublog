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
    public function login(): array
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
            $userLogin = $this->sanitizeData($_POST, self::FIELDS_LOGIN);
            $errors = $this->validateData($userLogin, self::FIELDS_LOGIN);
            $userManager = new UserManager();
            $user = $userManager->selectOneByUsername($userLogin['username']);
            if (!$user) {
                $errors[] = "Cet utilisateur n'existe pas";
            }
            if (empty($errors)) {
                $password = $userLogin['password'];
                $username = $user['user_name'];
                $hashPassword = $user['user_password'];
                if (password_verify($password, $hashPassword)) {
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['username'] = $username;
                    header('Location: /article/show?id=1');
                } else {
                    $errors[] = "Mot de passe ou email incorrect";
                }
            }
        }
        return $errors;
    }
    public function register(): array
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerSubmit'])) {
            $userRegister = $this->sanitizeData($_POST, self::FIELDS_REGISTER);
            $errors = $this->validateData($userRegister, self::FIELDS_REGISTER);

            if (empty($errors)) {
                $userManager = new UserManager();
                $id = $userManager->insert($userRegister);
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $userRegister['new-username'];
            } else {
                return $errors;
            }
        }
        return $errors;
    }
}
