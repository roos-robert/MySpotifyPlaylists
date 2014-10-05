<?php

require_once('src/view/HTMLView.php');
require_once('src/controller/NavigationController.php');

$HTMLview = new HTMLView();

$navigationCtrl = new \controller\NavigationController();

$htmlBody = $navigationCtrl->doControll();

$HTMLview->echoHTML($htmlBody);