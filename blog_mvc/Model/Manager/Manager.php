<?php

namespace App\Model\Manager;

abstract class Manager
{
    
    protected function dbConnect()
    {
        $yaml = yaml_parse_file('./Config/parameters.yml');

        $host = $yaml["database"]["host"];
        $dbname = $yaml["database"]["dbname"];
        $username = $yaml["database"]["username"];
        $password = $yaml["database"]["password"];
        
        $db = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password);
        return $db;
    }
}