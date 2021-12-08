<?php

require_once 'controllers/ControllerIndex.php';
require_once 'controllers/ControllerProfile.php';
require_once 'core/Main.php';

use controllers\ControllerIndex;
use controllers\ControllerProfile;
use core\Main;
if ($_REQUEST['path']){
    $method = $_SERVER['REQUEST_METHOD'];
    $path = $_SERVER['REQUEST_URI'];
    if (substr($path, -1) == '/'){
        $path = substr($path, 0, -1);
    }
    switch ($path) {
        case '/login' :
            $method == 'GET'?
            (new ControllerIndex())->login() :
            (new ControllerIndex())->loginProcess();
            break;
        case '/register' :
            (new ControllerIndex())->register();
            break;
        case '/logout' :
            (new ControllerIndex())->logout();
            break;
        case '/profile' :
            (new ControllerProfile())->index();
            break;
        case '/change_username' :
            (new ControllerProfile())->changeUsername();
            break;
        case '/change_password' :
            (new ControllerProfile())->changePassword();
            break;
        default:
            http_response_code(404);
    }

}else{
    (new ControllerIndex)->login();
}