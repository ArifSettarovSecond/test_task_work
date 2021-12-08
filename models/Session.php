<?php

namespace models;
//require 'models/Users.php';
use \core\Database;
use \models\Users;

class Session extends Database
{
    public function checkSession($key)
    {
        $result = $this->db->query("SELECT user_id FROM sessions WHERE session_key =".$this->sql_prepare($key));
        $result= mysqli_fetch_array($result);
        if ($result) {
            if ($result['user_id']) {
                (new Users)->storeUserInGlobal($result['user_id']);
            }
            return true;

        } else {
            return $result;
        }

    }

    public function createSession($user_id)
    {
        $result = $this->db->query("SELECT * FROM sessions WHERE user_id = " . $this->sql_prepare($user_id));
        $result = mysqli_fetch_array($result);
        $uid = $this->genarateKey(16);
        if ($result['user_id']) {
            $this->db->query("UPDATE sessions SET session_key = " . $this->sql_prepare($uid) . " WHERE user_id = " . $this->sql_prepare($user_id));
        } else {
            $this->db->query("INSERT INTO sessions (session_key, user_id) VALUES (" . $this->sql_prepare($uid) . ", " . $this->sql_prepare($user_id).")");
        }

        return $uid;
    }
}