<?php
namespace view;

require_once("src/model/UserModel.php");
require_once("src/view/MessageView.php");

class SignupView {

    private $model;
    private $messages;

    public function __construct() {
        $this->model = new \model\UserModel();
        $this->messages = new \view\MessageView();
    }

    public function showPage() {
        if($this->model->getLoginStatus() === false || $this->sessionCheck() === false)
        {
            $username = isset($_POST["username"]) ? $_POST["username"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $name = isset($_POST["name"]) ? $_POST["name"] : "";
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