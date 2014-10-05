<?php

namespace controller;

require_once('./src/view/NavigationView.php');
require_once('./src/controller/HomeController.php');
require_once('./src/controller/LoginController.php');

/*
This class handles the applications routing by checking which controller to instantiate, and the method/view to be
returned
*/
class NavigationController {
    private $controller;

    public function doControll() {

        try
        {
            switch (\view\NavigationView::getAction())
            {
                case \view\NavigationView::$actionLogin:
                    $this->controller = new LoginController();
                    return $this->controller->checkActions();
                    break;
                default:
                    $this->controller = new HomeController();
                    return $this->controller->checkActions();
                    break;
            }
        }
        catch (\Exception $e)
        {
            echo "Error in routing";
            die();
        }

    }

}