<?php

namespace core;
class Database
{
    private $_host;
    private $_user;
    private $_password;
    private $_dbname;

    protected $db;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $dbname
     */
    public function __construct(string $host = '', string $user = '', string $password = '', string $dbname = '')
    {
        $this->_host = $host ?: $_ENV['DB_HOST'];
        $this->_user = $user ?: $_ENV['DB_USER'];
        $this->_password = $password ?: $_ENV['DB_PASSWORD'];
        $this->_dbname = $dbname ?: $_ENV['DB_DATABASE'];
        $this->db = mysqli_connect($this->_host, $this->_user, $this->_password, $this->_dbname);
    }


    /*Экранируем переменные чтобы не было инъекций*/
    public function sql_prepare($value)
    {

        if (is_string($value)) {
            return "'" . $value . "'";
        } else if (is_numeric($value) and $value + 0 == $value) {
            return $value;
        } else if (is_bool($value)) {
            return $value ? 1 : 0;
        } else if (is_array($value)) {

            foreach ($value as $k => $item) {
                if (!is_numeric($item)) {
                    $value[$k] = '"' . $item . '"';
                }
            }
            return '(' . implode(',', $value) . ')';
        } else {
            return "'" . $value . "'";
        }
    }

    /*Генерация ключа сессии и соли для пароля*/
    function genarateKey($count)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i <$count; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;

    }
}