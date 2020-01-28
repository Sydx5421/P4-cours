<?php
//P4 Brouillon
namespace App\Model\Manager;

use App\Model\Entity\Comment;
 
require_once('Manager.php');


class CommentsManager extends Manager
{
    public function getComments($postId)
    {
//        vd('ENTER');
        $db = $this->dbConnect(); 
        $req = $db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC');

        $req->execute(array($postId));
        
//        $comments = array();
        $comment = $req->fetchObject('App\Model\Entity\Comment');
//        vd($comment);
        $comments = [];
        if($comment != false){
            while($comment = $req->fetchObject('App\Model\Entity\Comment')){
//                    vd($comment);
                    $comments[] = $comment;
                }            
                
            $req->closeCursor();
        
        }
        
        return $comments;
    }

    public function postComment(Comment $comment)
    {
        
        $db = $this->dbConnect(); 
        $req = $db->prepare('INSERT INTO comments(post_id, author, comment) VALUES(:post_id, :author, :comment)');
        
        $req->bindValue(':post_id', $comment->getPostId(), \PDO::PARAM_INT);
        $req->bindValue(':author', $comment->getAuthor());
        $req->bindValue(':comment', $comment->getComment());
        
        $reqExec = $req->execute();
        
        return $reqExec;
        
    }
    
    public function getALlComments(){
        $db = $this->dbConnect(); 
        $req = $db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date FROM comments ORDER BY comment_date DESC');
        
        $req->execute();
        
        $comment = $req->fetchObject('App\Model\Entity\Comment');
        
        $comments = [];
        if($comment != false){
            while($comment = $req->fetchObject('App\Model\Entity\Comment')){
                $comments[] = $comment;
            }            
                
            $req->closeCursor();        
        }
        
        return $comments;
        
    }
    
}
