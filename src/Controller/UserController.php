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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userLogin = $this->sanitizeData($_POST, self::FIELDS_LOGIN);

            $password = $userLogin['password'];

            $userManager = new UserManager();
            $user = $userManager->selectOneByUsername($userLogin['username']);

            $username = $user['user_name'];
            $hashPassword = $user['user_password'];

            if ($password === $hashPassword) { // password_verify($password, $hashPassword)
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $username;
                header('Location: /article/show?id=1');
            }
        }
    }
    /*public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerSubmit'])) {
            $userRegister = $this->sanitizeData($_POST, self::FIELDS_REGISTER);

            $errors = [];

            if (empty($userRegister['new-email']) || filter_var($userRegister['new-email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Votre adresse email est invalide";
            } elseif (strlen($userRegister['new-email']) >= 50) {
                $errors[] = "Votre adresse email est trop longue";
            } elseif (strlen($userRegister['new-email']) <= 5) {
                $errors[] = "Votre adresse email est trop courte";
            }

            if (empty($userRegister['new-pseudo'])) {
                $errors[] = "Veuillez renseigner un pseudo";
            } elseif (strlen($userRegister['new-pseudo']) >= 50) {
                $errors[] = "Votre pseudo est trop long";
            } elseif (strlen($userRegister['new-pseudo']) <= 5) {
                $errors[] = "Votre pseudo est trop court";
            }

            if (empty($userRegister['new-password'])) {
                $errors[] = "Veuillez renseigner un mot de passe";
            } elseif (strlen($userRegister['new-password']) >= 50) {
                $errors[] = "Votre mot de passe est trop long";
            } elseif (strlen($userRegister['new-password']) <= 5) {
                $errors[] = "Votre mot de passe est trop court";
            }

            if (empty($errors)) {
                $userManager = new UserManager();
                $userManager->add($userRegister);
            }
        }
    }*/
}
