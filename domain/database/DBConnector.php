<?php

class DBConnector
{
    protected static $dbDetails = [
        'servername' => 'localhost',
        'db_name' => 'twitter',
        'username' => 'root',
        'password' => '',
    ];

    public static function connect(): PDO
    {
        try {
            $conn = new PDO(
                "mysql:host=" . self::$dbDetails['servername'] . ";dbname=" . self::$dbDetails['db_name'],
                self::$dbDetails['username'],
                self::$dbDetails['password']
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $conn;
    }
}