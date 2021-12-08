<?php

namespace controllers;
use core\Main;

use models\Users;

class ControllerProfile extends Main
{
    public function __construct()
    {
        if (!$GLOBALS['user_info']) {
            $this->redirect('/login');exit();
        }
    }

    public function index(){
        return $this->render('views/profile.php');
    }
    public function changeUsername(){
        if (!$_POST['username']) {
            echo json_encode(['status'=>false, 'text'=>'Имя не может быть пустым']);exit();
        }
        if((new Users())->changeUsername($GLOBALS['user_info']['id'], $_POST['username'])){
            echo json_encode(['status'=>true, 'text'=>'Имя успешно изменено']);exit();
        }
        echo json_encode(['status'=>false, 'text'=>'Не удалось изменить имя']);exit();
    }

    public function changePassword(){
        $old = $_POST['old_password'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];
        if (!$_POST['old_password'] || !$_POST['password'] ||!$_POST['confirm_password']) {
            echo json_encode(['status'=>false, 'text'=>'Введите старый и новый пароль, подтверждение пароля']);exit();
        }

        $user = (new Users())->getUserNoClean($GLOBALS['user_info']['login']);
        if (!$user) {
            echo json_encode(['status'=>false, 'text'=>'Не удалось выполнить запрос']);exit();
        }
        $old_pass = (new Users())->checkPassword($user, $old);
        if ($old_pass) {
            if ($password !== $confirm) {
                echo json_encode(['status'=>false, 'text'=>'Новый пароль и подтверждение пароля не совпадают']);exit();
            }
            if((new Users())->changePassword($user, $password)){
                echo json_encode(['status'=>true, 'text'=>'Пароль успешно изменен']);exit();
            }
        }else{
            echo json_encode(['status'=>false, 'text'=>'Старый пароль введен неверно']);exit();
        }
    }
}