<?php

require_once('src/view/HTMLView.php');
require_once('src/controller/NavigationController.php');

session_start();
// Making the session contain info of what browser started the session, to prevent hijacking of session.
if(!isset($_SESSION["httpAgent"]))
{
    $_SESSION["httpAgent"] = $_SERVER["HTTP_USER_AGENT"];
}

$HTMLview = new HTMLView();

$navigationCtrl = new \controller\NavigationController();

$htmlBody = $navigationCtrl->doControll();

$HTMLview->echoHTML($htmlBody);