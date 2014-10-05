<?php

require_once('src/view/HTMLView.php');
require_once('src/controller/LoginController.php');

$view = new HTMLView();
$login = new LoginController();

//$viewLogin = $login->doControl();
$view->echoHTML("Test");