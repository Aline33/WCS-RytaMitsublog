<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\ArticleSectionManager;
use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): array
    {
        $errors = [];
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userLogin = $this->sanitizeData($_POST, self::FIELDS_LOGIN);
        $errors = $this->validateData($userLogin, self::FIELDS_LOGIN);
        $userManager = new UserManager();
        $user = $userManager->selectOneByUsername($userLogin['username']);
        if (!$user) {
            $errors['username']['fatal']['user!Exists'] = "Cet utilisateur n'existe pas";
        }
        if (empty($errors)) {
            $password = $userLogin['password'];
            $username = $user['user_name'];
            $hashPassword = $user['user_password'];
            if (password_verify($password, $hashPassword)) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $username;
            } else {
                $errors['password']['fatal']['password!Match'] = "Mot de passe ou pseudo incorrect";
            }
        }
        //}
        return $errors;
    }
    public function register(): array
    {
        $errors = [];
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        //}
        return $errors;
    }

    public function disconnect(): void
    {
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_unset();
        session_destroy();
        header('Location: /');
        //}
    }

    public function index(): string
    {
        $id = $_SESSION['user_id'];
        return $this->twig->render('Profile/index.html.twig', [
            'id' => $id
        ]);
    }

    public function show(int $id): string
    {
        $userManager = new userManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('Profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    public function edit(): string
    {
        /*if (!$_SESSION['user_id']) {
            header('Location: /');
        } else {

        }*/
        $userManager = new UserManager();
        $id = $_SESSION['user_id'];

        $user = $userManager->selectOneById($id);
        //$user['user_password'] =

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editUserSubmit'])) {
            $userEdit = array_pop($_POST);
            $userEdit = $this->sanitizeData($userEdit, self::FIELDS_EDIT);
            $errors = $this->validateData($userEdit, self::FIELDS_EDIT);

            $userEdit['id'] = $_SESSION['user_id'];


            if (empty($errors)) {
                $userManager = new UserManager();
                $id = $userManager->update($userEdit);
                header('Location: /profil/edit');
                //$_SESSION['user_id'] = $id;
                //$_SESSION['username'] = $userEdit['new-username'];
            }
        }

        if (!empty($errors)) {
            return $this->twig->render('Profile/edit.html.twig', [
                'user' => $user,
                'errors' => $errors
            ]);
        }
        return $this->twig->render('Profile/edit.html.twig', [
            'user' => $user,
        ]);
    }
}
