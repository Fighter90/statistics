<?php

class MSQL
{
    protected static $instance = null;

    public static function getInstance()
    {
        if (static::$instance == null) {
            try {
                static::$instance = new PDO('mysql:host=localhost;dbname=' . DB_NAME,
                    DB_USER,
                    DB_PASS,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return static::$instance;
    }

    public function __construct()
    {

    }
}