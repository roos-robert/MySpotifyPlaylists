<?php

namespace model;

require_once("src/model/UserRepository.php");

class UserModel {

    private $userRepository;
    private $sessionLocation = "LoggedIn";
    private $sessionUsername = "Username";

    public function __construct() {
        $this->userRepository = new \model\UserRepository();
    }

    // Checks the credentials, if correct the LoggedIn session is set to true.
    public function doLogin($username, $password) {
        $user = $this->userRepository->get($username);

        if($user != NULL)
        {
            if($user["Username"] == $username && $user["Password"] == $password)
            {
                $_SESSION[$this->sessionLocation] = true;
                $_SESSION[$this->sessionUsername] = $username;
            }
        }
        else
        {
            throw new \Exception;
        }
    }

    // Automatic login.
    public function doAutoLogin($username, $token) {
        if ($username == "Admin" && $this->retriveToken($username) == $token)
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

    public function retriveToken($username) {
        $user = $this->userRepository->get($username);

        if($user != NULL)
        {
            return $user["LoginToken"];
        }
    }
}