<?php

class DBConnector
{
    protected static $servername = "localhost";
    protected static $db_name = "twitter";
    protected static $username = "root";
    protected static $password = "";
    protected static $pdo;

    public function __construct()
    {
    }
    // This method establishes a connection to a MySQL database
    public static function connect(): PDO
    {
        // These properties hold the host name of the server and the name of the database
        $servername = self::$servername;
        $db_name = self::$db_name;
        // Tries to establish a connection to the database
        try {
            // creates a new instance of the PDO class passing the connection string,
            // the username, and the password as arguments
            // PDO is a database access layer that provides a uniform method of access to databases
            // A PDO represents connection to a database server
            $conn = new PDO("mysql:host=$servername;dbname=$db_name", self::$username, self::$password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $conn;
    }

}


