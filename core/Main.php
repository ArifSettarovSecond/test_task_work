<?php

namespace core;

class Main
{
    protected $database;
    protected $session;

    public function setDatabase(Database $database)
    {
        $this->database = $database;
    }

    public function startSession()
    {

        session_start();
    }

    public function set_session_var($var_name, $value)
    {
        $_SESSION[$var_name] = $value;
    }
    public function delete_session_var($var_name)
    {
        $_SESSION[$var_name] = '';
    }

    public function getSession($var='')
    {
        return ($var ? $_SESSION[$var] : $_SESSION);

    }

    public function checkUserBySessionKey($key)
    {
        return $this->database->checkSession($key);
    }

    public function render($path)
    {
        return require $path;
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}