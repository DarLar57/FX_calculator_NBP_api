<?php

namespace App;

use PDO;
use Exception;

class DB
{
    public static $dbConn;
    
    public function __construct() 
    {
        // get db credentials from config.ini
        $dbCredentials = $this->getDbCredentials(__DIR__ . '/../db/config.ini');
        
        try {
            self::$dbConn = new PDO("mysql:host={$dbCredentials[0]};dbname={$dbCredentials[1]};charset=utf8mb4", $dbCredentials[2], $dbCredentials[3]);

            self::$dbConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {
            die ('Connection with the database failed ! Check your credentials!');
        }
    }

    // get db credentials from ini file
    private function getDbCredentials($file): array
    {
        if(file_exists($file)) {
            $configFile = parse_ini_file($file); 
        } else {
            die ('Configuration file is missing. Please check !');
        }
        
        $dbCredentials = [
            $configFile['host'], 
            $configFile['database_name'], 
            $configFile['login'], 
            $configFile['password']
        ];
        return $dbCredentials;
    }
}