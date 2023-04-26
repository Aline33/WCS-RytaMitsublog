<?php

namespace App\Controller;

class UserController extends AbstractController
{
    public function login(): string
    {
        // TODO : get data from $_POST, verify their safety, select one user corresponding to email or username, check compatibility and set global $user used to test when the user is connceted or not
    }
}
