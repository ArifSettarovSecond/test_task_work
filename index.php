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

(new DotEnv('core/.env'))->load();

$database = new Database();

$Main = new Main();

$Main->setDatabase($database);
$Main->startSession();

$uid = $Main->getSession('uid');
if ($uid) {
    $user_id = (new Session())->checkSession($uid);
}

require('./routes.php');


