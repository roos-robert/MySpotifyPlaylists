<?php
namespace view;

require_once("src/model/UserModel.php");
require_once("src/model/UserRepository.php");
require_once("src/view/MessageView.php");

class SignupView {

    private $model;
    private $userRepository;
    private $messages;

    // Getters for the forms
    public function getPostedUsername() {
        return $_POST["username"];;
    }
    public function getPostedPassword() {
        return $_POST["password"];;
    }
    public function getPostedPasswordCheck() {
        return $_POST["passwordCheck"];;
    }
    public function getPostedEmail() {
        return $_POST["email"];;
    }

    public function __construct(\model\UserModel $model) {
        $this->model = $model;
        $this->userRepository = new \model\UserRepository();
        $this->messages = new \view\MessageView();
    }

    // Checks if the user has pressed the register button.
    public function onClickRegister() {
        if(isset($_POST["registerButton"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Validates that the the form is correctly filled in
    public function validateUser() {
        $error = "";

        if (strlen($this->getPostedUsername()) < 3 || strlen($this->getPostedPassword()) < 6)
        {
            if (strlen($this->getPostedUsername()) < 3) {
                $error .= " - Username has too few characters. At least 3 needed";
                $this->messages->save($error);
            }
            if (strlen($this->getPostedPassword()) < 6)
            {
                $error .= " - Password has to few characters. At least 6 needed ";
                $this->messages->save($error);
            }
            if (strlen($this->getPostedEmail()) < 6)
            {
                $error .= " - Email has to few characters. At least 6 needed ";
                $this->messages->save($error);
            }

            return false;
        }
        if ($this->getPostedPassword() != $this->getPostedPasswordCheck())
        {
            $error .= " - Passwords don't match ";
            $this->messages->save($error);
            return false;
        }
        if(strpbrk($this->getPostedUsername(), '<>""./') || strpbrk($this->getPostedEmail(), '<>""/'))
        {
            $error .= " - Username and/or email contains illegal characters ";
            $this->messages->save($error);
            return false;
        }

        if($username = $this->userRepository->get($this->getPostedUsername()) != NULL)
        {
            $error .= " - Username is already in use ";
            $this->messages->save($error);
            return false;
        }

        return true;
    }

    public function showSignupMessage() {
        return "
        <div class='container'>
            <h1>Success!</h1>
             <p>You can now move on to <a href='?action=login'>Log in</a> and start using the site!</p>
        </div>";
    }

    public function showPage() {
        if($this->model->getLoginStatus() === false || $this->sessionCheck() === false)
        {
            $username = isset($_POST["username"]) ? $_POST["username"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            return "
        <div class='container'>
            <h1>Register</h1>
             <form action='' method='post' name='loginForm'>
                <fieldset>
                <legend>Enter your desired credentials and info</legend><p>" . $this->messages->load() . "</p>
                <label><strong>Username: </strong></label>
                <input type='text' name='username' class='form-control' value='$username' /><br />
                <label><strong>Password: </strong></label>
                <input type='password' name='password' class='form-control' value='' /><br />
                <label><strong>Password again: </strong></label>
                <input type='password' name='passwordCheck' class='form-control' value='' /><br />
                <label><strong>Email: </strong></label>
                <input type='text' name='email' class='form-control' value='$email' /><br />
                <input type='submit' value='Register' name='registerButton' class='btn btn-default' />
                </fieldset>
            </form>
        </div>";
        }
        else
        {
            header('Location: index.php');
            exit;
        }
    }
}