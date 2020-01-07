<?php
//P4 Brouillon
namespace App\Model\Manager;
 
require_once('Manager.php');


class CommentsManager extends Manager
{
    public function getComments()
    {
//        vd('ENTER');
        $db = $this->dbConnect(); 
        $posts = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

        return $posts;
    }
}