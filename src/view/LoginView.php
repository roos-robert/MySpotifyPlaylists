<?php
namespace view;

class LoginView {
    private $model;
    private $messages;

    public function __construct(\model\UserModel $model)
    {
        $this->model = $model;
        $this->messages = new \view\MessageView();
    }

    // Checks if the user has pressed the login button.
    public function onClickLogin() {
        if(isset($_POST["loginButton"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Checks if the user has pressed the logout button.
    public function onClickLogout() {
        if(isset($_GET['logout']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function sessionCheck() {
        if ($_SESSION["httpAgent"] != $_SERVER["HTTP_USER_AGENT"])
        {
            return false;
        }
        return true;
    }

    public function showPage() {
        if($this->model->getLoginStatus() === false || $this->sessionCheck() === false)
        {
            $username = isset($_POST["username"]) ? $_POST["username"] : "";
            return "
        <div class='container'>
            <h1>Login</h1>
             <form action='' method='post' name='loginForm'>
                <fieldset>
                <legend>Enter your username and password</legend><p>" . $this->messages->load() . "</p>
                <label><strong>Username: </strong></label>
                <input type='text' name='username' class='form-control' value='$username' /><br />
                <label><strong>Password: </strong></label>
                <input type='password' name='password' class='form-control' value='' /><br />
                <label><strong>Keep me logged in: </strong></label>
                <input type='checkbox' name='stayLoggedIn' /><br /><br />
                <input type='submit' value='Login' name='loginButton' class='btn btn-default' />
                </fieldset>
            </form>
            <p>&nbsp;</p>
            <p>Not a member? <a href='?action=signup'>Register here!</a></p>
        </div>";
        }
        else
        {
            return "
            <div class='container'>
                <h1>Welcome!</h1>
                <h3>" . $this->model->retriveUsername() . " is logged in</h3>
                <p>" . $this->messages->load() . "</p>
                <a href='?action=login&logout=true'>Log out</a>
             </div>";
        }
    }
}