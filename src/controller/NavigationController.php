<?php

namespace controller;

use view\MyMixtapesView;

require_once('./src/view/NavigationView.php');
require_once('./src/controller/HomeController.php');
require_once('./src/controller/LoginController.php');
require_once('./src/controller/SignupController.php');
require_once('./src/controller/NewMixtapeController.php');
require_once('./src/controller/MixtapeController.php');
require_once('./src/controller/MixtapesController.php');
require_once('./src/controller/MyMixtapesController.php');

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
                case \view\NavigationView::$actionSignup:
                    $this->controller = new SignupController();
                    return $this->controller->checkActions();
                    break;
                case \view\NavigationView::$actionNewMixtape:
                    $this->controller = new NewMixtapeController();
                    return $this->controller->checkActions();
                    break;
                case \view\NavigationView::$actionMixtape:
                    $this->controller = new MixtapeController();
                    return $this->controller->checkActions();
                    break;
                case \view\NavigationView::$actionMyMixtapes:
                    $this->controller = new MyMixtapesController();
                    return $this->controller->checkActions();
                    break;
                case \view\NavigationView::$actionAllMixtapes:
                    $this->controller = new MixtapesController();
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