<?php

namespace controllers;

use \core\Main;

require_once('models/Users.php');
require_once('models/Session.php');

use models\Session;
use \models\Users;


class ControllerIndex extends Main
{

    public function login()
    {

        if($GLOBALS['user_info']['id']){
            $this->redirect('/profile');exit;
        }

        return $this->render('views/index.php');
    }
    public function loginProcess()
    {
        $this->validate('login');
        $login = $_POST['login'];
        $password = $_POST['password'];

        $user = (new Users())->getUserNoClean($login);

        if(!$user){
            echo json_encode(['status' => false, 'text' => 'Пользователя с такими данными не существует']);
            exit;
        }
        if (!(new Users())->checkPassword($user, $password)) {
            echo json_encode(['status' => false, 'text' => 'Введенный логин или пароль не верны']);
            exit;
        }

        if ($user['id']) {
            $user_uid = (new Session())->createSession($user['id']);
            $this->set_session_var('uid', $user_uid);
            echo json_encode(['status'=>true, 'redirect'=>'/']);exit;
        }
    }

    public function register()
    {
        $this->validate('register');

        $username = $_REQUEST['username'];
        $email = $_REQUEST['email'];
        $login = $_REQUEST['login'];
        $password = $_REQUEST['password'];

        $user_model = new Users();
        $user_uid = $user_model->newUser($login, $email, $username, $password);

        $this->set_session_var('uid', $user_uid);


        echo json_encode(['status'=>true, 'redirect'=>'/']);exit;

    }
    public function logout()
    {
        $this->delete_session_var('uid',);
        $this->redirect('/');exit;
    }
    private function validate($action){
        if ($action == 'register'){

            $username = $_REQUEST['username'];
            $email = $_REQUEST['email'];
            $login = $_REQUEST['login'];
            $password = $_REQUEST['password'];
            $confirm = $_REQUEST['confirm_password'];

            if (!$username) {
                echo json_encode(['status' => false, 'text' => 'ФИО обязательно для заполнения']);
                exit;
            }
            if (!$email) {
                echo json_encode(['status' => false, 'text' => 'Email обязательно для заполнения']);
                exit;
            }
            if (!$login) {
                echo json_encode(['status' => false, 'text' => 'Введите логин']);
                exit;
            }
            if (!$password) {
                echo json_encode(['status' => false, 'text' => 'Введите пароль']);
                exit;
            }
            if (!$confirm) {
                echo json_encode(['status' => false, 'text' => 'Введите пароль']);
                exit;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status' => false, 'text' => 'Неврный формат email']);
                exit;
            }
            if ($password !== $confirm) {
                echo json_encode(['status' => false, 'text' => 'Введенные пароли не совпадают']);
                exit;
            }

            if ((new Users())->checkUserByEmail($email)) {
                echo json_encode(['status' => false, 'text' => 'Email уже занят']);
                exit;
            }
            if ((new Users())->checkUserByLogin($login)) {
                echo json_encode(['status' => false, 'text' => 'Логин уже занят']);
                exit;
            }
        }
        if ($action == 'login') {
            $login = $_POST['login'];
            $password = $_POST['password'];
            if (!$login or !$password) {
                echo json_encode(['status'=>false, 'Введите login/email и пароль']);
                exit;
            }

            if (!(new Users())->checkUserByEmail($login) and !(new Users())->checkUserByLogin($login)) {

                echo json_encode(['status' => false, 'text' => 'Пользователя с такими данными не существует']);
                exit;
            }
        }
    }


}