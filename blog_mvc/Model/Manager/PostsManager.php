<?php
//94 Brouillon
namespace App\Model\Manager;

use App\Model\Entity\Post;

require_once('Manager.php');


class PostsManager extends Manager
{
    public function getPosts($currentPage=1)
    {
        $db = $this->dbConnect(); 
        
        $reqNbPosts = $db->query('SELECT COUNT(id) as nbPosts FROM posts');
        $resultNbPosts = $reqNbPosts->fetch();
        
        $nbPosts = $resultNbPosts['nbPosts'];
        $nbPostsPerPage = 3;
        $nbPages = ceil($nbPosts/$nbPostsPerPage);
        
        if(isset($currentPage) && $currentPage > 0 && $currentPage <= $nbPages){
            $currentPage = $currentPage;
        }else{
            $currentPage = 1;
        }
                
        // Version fetchObject :
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date FROM posts p ORDER BY p.creation_date DESC LIMIT ' . (($currentPage-1)*$nbPostsPerPage) .',3');
        
        $posts = array();
        
        while($post = $req->fetchObject('App\Model\Entity\Post')){
            $posts[] = $post;
        }

        $req->closeCursor();
        
        $returnVars = array(
            "posts" => $posts,
            "nbPages" => $nbPages,            
            "currentPage" => $currentPage            
        );
        
        return $returnVars;               
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
    
    public function updatePost(Post $post)
    {
        $db = $this->dbConnect(); 
        $req = $db->prepare('UPDATE posts SET title = :title, content = :content WHERE id =' . $post->getId());
        
        $req->bindValue(':content', $post->getContent());
        $req->bindValue(':title', $post->getTitle());
        $reqExec = $req->execute();
        
        return $reqExec;             
    }
    
    public function deletePost ($postId){
        $db = $this->dbConnect(); 
        $req = $db->exec('DELETE FROM posts WHERE id =' . $postId);
        
        return $req;        
    }
    
}