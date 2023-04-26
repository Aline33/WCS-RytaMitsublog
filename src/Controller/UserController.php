<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    // TODO : get data from $_POST,
    // TODO :  verify their safety,
    // TODO : select one user corresponding to email or username,
    // TODO : check compatibility
    // TODO :  set global $user used to test when the user is connceted or not
    public function login(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userLogin = array_map('trim', $_POST);
            $userLogin = array_map('htmlentities', $userLogin);

            $password = $userLogin['password'];

            $userManager = new UserManager();
            $user = $userManager->selectOneByEmail($userLogin['email']);

            $email = $user['email'];
            $hashPassword = $user['user_password'];

            if (password_verify($password, $hashPassword)) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['user_email'] = $email;
            }
        }
        return $this->twig->render('');
    }
}
