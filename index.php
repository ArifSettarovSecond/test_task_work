<?php
require_once 'core/DotEnv.php';
require_once 'core/Database.php';
require_once 'core/Main.php';
require_once 'models/Session.php';
require_once 'models/Users.php';

use core\DotEnv;
use core\Database;
use core\Main;
use models\Session;

/*Подлючаем env файл в глобальный ENV*/
(new DotEnv('core/.env'))->load();


/*Создаем экземпляр подключения к бд*/
$database = new Database();

/*Ядро контроллера, глобальный scope*/
$Main = new Main();

/* Разрешаем наследникам Main пользоваться подключением */
$Main->setDatabase($database);

/*Запускаем сессию*/
$Main->startSession();

/*Проверяем юзера и логиним его*/
$uid = $Main->getSession('uid');
if ($uid) {
    $user_id = (new Session())->checkSession($uid);
}
/*Роутим запросы*/
require('./routes.php');


