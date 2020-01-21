<?php
//94 Brouillon
namespace App\Model\Manager;

use App\Model\Entity\Post;

require_once('Manager.php');


class PostsManager extends Manager
{
    public function getPosts()
    {
//        vd('ENTER');
        $db = $this->dbConnect(); 
//        $posts = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

//        return $posts;
        
        // Version fetchObject :
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');
        
        $posts = array();
        
        while($post = $req->fetchObject('App\Model\Entity\Post')){
            $posts[] = $post;
        }

        $req->closeCursor();

        return $posts;
        
        
    }

    public function getPost($postId=1)
    {
        $db = $this->dbConnect(); 
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
        
        $req->execute(array($postId));
        
        $post = $req->fetchObject('App\Model\Entity\Post');
        
        $req->closeCursor();

        return $post;
    }
    
    public function postPost(Post $post)
    {
        $db = $this->dbConnect(); 
        $req = $db->prepare('INSERT INTO posts(content) VALUES(:content)');
        
        $req->bindValue(':content', $post->getContent());
        $reqExec = $req->execute();
        
        return $reqExec;        
    }
    
}