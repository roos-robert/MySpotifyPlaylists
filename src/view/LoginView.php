<?php
namespace view;

class LoginView {

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

    public function showPage() {
        return "
    <div class='container'>
        <h2>Login</h2>
         <form action='?login' method='post' name='loginForm'>
            <fieldset>
            <legend>Enter username and password</legend>
            <label><strong>Username: </strong></label>
            <input type='text' name='username' class='form-control' value='' /><br />
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
}