<?php

namespace model;

class UserLoginData {
    private $userName;
    private $password;
    private $keepLogin;

    public function __construct($userName, $password, $keepLogin) {
        if (!$userName) {
            throw new \Exception('Username is missing');
        }

        if (!$password) {
            throw new \Exception('Password is missing');
        }

        $this->userName = $userName;
        $this->password = $password;
        $this->keepLogin = $keepLogin;
    }

    public function username(): string {
        return $this->userName;
    }

    public function password(): string {
        return $this->password;
    }
}
