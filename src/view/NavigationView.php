<?php

namespace view;

class NavigationView {
    private static $action = 'action';

    public static $actionLogin = 'login';
    public static $actionSignup = 'signup';
    public static $actionNewMixtape = 'newMixtape';
    public static $actionMixtape = 'mixtape';
    public static $actionMyMixtapes = 'myMixtapes';
    public static $actionAllMixtapes = 'allMixtapes';
    public static $home = 'home';

    public static function getAction() {
        if (isset($_GET[self::$action]))
        {
            return $_GET[self::$action];
        }
        else
        {
            return self::$home;
        }
    }

}