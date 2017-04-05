<?php

//The following virtual server has been set up successfully :
//Domain name:             saddiqs1.eas-cs2410-1617.aston.ac.uk
//
//Administration URL:      https://www.saddiqs1.eas-cs2410-1617.aston.ac.uk:10000/
//
//Website:                 http://www.saddiqs1.eas-cs2410-1617.aston.ac.uk/
//MySQL PhpMyAdmin URL:    http://www.saddiqs1.eas-cs2410-1617.aston.ac.uk/phpmyadmin
//MySQL database:          saddiqs1_db
//User login:             saddiqs1
//User password:          owls77sale

class Database
{

    protected static $db;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        try {
            //TODO - email for access to ftp/server
            self::$db = new PDO('mysql:host=localhost;dbname=filo', 'root', '');
//            self::$db = new PDO('mysql:host=localhost;dbname=saddiqs1_db', 'saddiqs1', 'owls77sale');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public static function getDB() {
        if(!self::$db) {
            new Database();
        }
        return self::$db;
    }
}