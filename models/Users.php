<?php

namespace models;
require_once 'models/Session.php';

use \models\Session;
use \core\Database;

class Users extends Database
{
    /**
     * @param $email
     * @return bool
     */
    public function checkUserByEmail($email): bool
    {

        $res = $this->db->query('SELECT * FROM users WHERE email = ' . $this->sql_prepare($email));
        $res = mysqli_fetch_array($res);
        if (!$res) {
            return false;
        }
        return $res['id'];
    }

    /**
     * @param $login
     * @return bool
     */
    public function checkUserByLogin($login)
    {
        $res = $this->db->query('SELECT * FROM users WHERE login = ' . $this->sql_prepare($login));
        $res = mysqli_fetch_array($res, MYSQLI_ASSOC);

        if ($res) {
            if (!$res['email']) {
                return false;
            }
            return $res['id'];
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function storeUserInGlobal($id): bool
    {
        $res = $this->db->query('SELECT * FROM users WHERE id = ' . $this->sql_prepare($id));
        $res = mysqli_fetch_assoc($res);
        if ($res) {
            unset($res['password'], $res['salt']);
            $GLOBALS['user_info'] = $res;
            return true;
        }
        return false;
    }

    public function newUser($login, $email, $name, $password)
    {
        $salt = $this->genarateKey(8);
        $password = sha1(sha1($password) . $salt);

        $res = $this->db->query("INSERT INTO users (login, email, name, password, salt) 
            VALUES(" . $this->sql_prepare($login) . ", " . $this->sql_prepare($email) . ", " . $this->sql_prepare($name) . "," . $this->sql_prepare($password) . "," . $this->sql_prepare($salt) . ")");
        if ($res) {
            $user_id = $this->checkUserByLogin($login);
        }
        if ($user_id) {
            return (new Session())->createSession($user_id);

        } else {
            return false;
        }
    }

    public function getUserNoClean($login)
    {
        $user = $this->db->query("SELECT * FROM users WHERE login = " . $this->sql_prepare($login));
        $user = mysqli_fetch_array($user);

        if (!$user) {
            $user = $this->db->query("SELECT * FROM users WHERE email = " . $this->sql_prepare($login));
        }
        $user = mysqli_fetch_assoc($user);
        return $user;

    }
    public function checkPassword($user, $password)
    {
        $password_hash = sha1(sha1($password) . $user['salt']);
        if ($password_hash != $user['password']) {
            return false;
        }
        return true;
    }
    public function changePassword($user, $password)
    {
        $password_hash = sha1(sha1($password) . $user['salt']);
        $result = $this->db->query("UPDATE users SET password = ".$this->sql_prepare($password_hash). " WHERE id = ".$this->sql_prepare($user['id']));
        if ($result) {
            return true;
        }
        return false;
    }
    public function changeUsername($user_id, $userName)
    {
        $result = $this->db->query("UPDATE users SET name = ".$this->sql_prepare($userName). " WHERE id = ".$this->sql_prepare($user_id));

        if ($result) {
            return true;
        }
        return false;
    }
}