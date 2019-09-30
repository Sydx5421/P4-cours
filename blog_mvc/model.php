<?php

function getPosts()
{
   try
    {
        $db = new PDO('mysql:host=localhost;dbname=blog_cours;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    $posts = $db->query('SELECT id, titre, contenu, date_creation FROM billets');
    
    return $posts;
}