<?php

require_once('src/view/HTMLView.php');
require_once('src/controller/HomeController.php');

$HTMLview = new HTMLView();
$HomeCtrl = new \controller\HomeController();

$viewHome = $HomeCtrl->checkActions();
$HTMLview->echoHTML($viewHome);