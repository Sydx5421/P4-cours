<?php
//P4 Brouillon
namespace App\Model\Manager;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=blog_cours;charset=utf8', 'root', '');
        return $db;
    }
}