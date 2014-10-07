<?php
namespace view;

class LoginView {
    public function showPage() {
        return "
    <div class='container'>
        <h2>Login</h2>
        <p>Login here.</p>
        <p>Not a member? <a href='?action=signup'>Register here!</a></p>
    </div>";
    }
}