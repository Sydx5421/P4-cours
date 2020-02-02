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
//        $posts = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

//        return $posts;
        
        // Version fetchObject :
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date FROM posts ORDER BY creation_date DESC');
        
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
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date FROM posts WHERE id = ?');
        
        $req->execute(array($postId));
        
        $post = $req->fetchObject('App\Model\Entity\Post');
        
        $req->closeCursor();

        return $post;
    }
    
    public function getLastPost()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 1');
        
        $lastPost = $req->fetchObject('App\Model\Entity\Post');

        $req->closeCursor();

        return $lastPost;
    }
    
    public function postPost(Post $post)
    {
        $db = $this->dbConnect(); 
        $req = $db->prepare('INSERT INTO posts(title, content) VALUES(:title, :content)');
        
        $req->bindValue(':content', $post->getContent());
        $req->bindValue(':title', $post->getTitle());
        $reqExec = $req->execute();
        
        return $reqExec;        
    }
    
}