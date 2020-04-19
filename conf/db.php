<?php

class DB
{
    const USER = "root";
    const PASS = "";
    const HOST = "localhost";
    const DB = "task_db";

    public static function connToDB() {

        $user = self::USER;
        $pass = self::PASS;
        $host = self::HOST;
        $db   = self::DB;

        $conn = new PDO("mysql:dbname=$db;host=$host;charset=UTF8", $user, $pass);

        return $conn;
        
        }
}