<?php

namespace model;

class UserModel {
    // Checks the credentials, if correct the LoggedIn session is set to true.
    public function doLogin($username, $password) {
        if($username == "Admin" && $password == "Password")
        {
            $_SESSION[$this->sessionLocation] = true;
            $_SESSION[$this->sessionUsername] = $username;
        }
        else
        {
            throw new \Exception;
        }
    }

    // When a user wants to logout, the session is returned to be null.
    public function doLogout() {
        $_SESSION[$this->sessionLocation] = null;
    }

    // Function for checking if a user is currently logged in or not.
    public function getLoginStatus() {
        if(!(isset($_SESSION[$this->sessionLocation])) || $_SESSION[$this->sessionLocation] === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    // Function for retrieving the username of the user currently logged in.
    public function retriveUsername() {
        return $_SESSION[$this->sessionUsername];
    }
}