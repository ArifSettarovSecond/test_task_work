<?php

namespace core;

class Main
{
    protected $database;

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

    /*Ренедерит (.*).PHP визуал*/
    public function render($path)
    {
        return require $path;
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}