<?php

namespace core;


class BaseModel {

    static protected $_connection;
    static private $_dbUser = '';
    static private $_dbPass = '';
    static private $_dbHost = '';
    static private $_dbName = '';

    static public function setUser($_dbUser)
    {
        self::$_dbUser = $_dbUser;
    }

    static public function setPass($_dbPass)
    {
        self::$_dbPass = $_dbPass;
    }


    static public function setHost($_dbHost)
    {
        self::$_dbHost = $_dbHost;
    }


    static public function setName($_dbName)
    {
        self::$_dbName = $_dbName;
    }


    public function __construct()
    {

    }


    /**
     * Nawiązuje połączenie z bazą danych.
     *
     */
    private function connect()
    {
        self::$_connection = new \PDO('mysql:host='.self::$_dbHost.';dbname='.self::$_dbName.';encoding=utf8',
            self::$_dbUser,
            self::$_dbPass,
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }


    /**
     * Zwraca połączenie z bazą.
     *
     */
    protected function db()
    {
        if (TRUE === empty(self::$_connection)) {
            $this->connect();
        }

        return self::$_connection;

    }
}