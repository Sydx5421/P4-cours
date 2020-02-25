<?php
//P4 Brouillon
namespace App\Model\Manager;

use App\Model\Entity\Comment;
 
require_once('Manager.php');


class CommentsManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect(); 
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC');

        $req->execute(array($postId));
        
        $comments = [];
        
        while($comment = $req->fetchObject('App\Model\Entity\Comment')){                
            $comments[] = $comment;
        }                   
        $req->closeCursor();

        return $comments;
    }

    public function getReportedComments(){
        $db = $this->dbConnect(); 
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date FROM comments WHERE reported = 1 ORDER BY comment_date DESC');

        $req->execute(array());
        
        $comments = [];
        while($comment = $req->fetchObject('App\Model\Entity\Comment')){                
            $comments[] = $comment;
        }                            
        $req->closeCursor();       
        return $comments;        
    }
    
    public function getNewComments(){
        $db = $this->dbConnect(); 
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date FROM comments WHERE commentRead = 0 ORDER BY comment_date DESC');

        $req->execute(array());
        
        $comments = [];
        while($comment = $req->fetchObject('App\Model\Entity\Comment')){                
            $comments[] = $comment;
        }                            
        $req->closeCursor();       
        return $comments;        
    }
    
    public function getReportedCommentsNb(){
        $db = $this->dbConnect(); 
        $req = $db->query('SELECT COUNT(reported) as reportedCommentsNb FROM comments WHERE reported = 1');
        $result = $req->fetch();
        $req->closeCursor();       
        
        return $result['reportedCommentsNb'];
    }
    
    public function getNewCommentsNb(){
        $db = $this->dbConnect(); 
        $req = $db->query('SELECT COUNT(commentRead) as newCommentsNb FROM comments WHERE commentRead = 0');
        $result = $req->fetch();
        $req->closeCursor();       
        
        return $result['newCommentsNb'];
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
        
        $comments = [];
        while($comment = $req->fetchObject('App\Model\Entity\Comment')){
            $comments[] = $comment;
        }            
        $req->closeCursor();     
        
        return $comments;
        
    }
    
    public function reportComment($commentId){
        $db = $this->dbConnect();
        $req = $db->exec('UPDATE comments SET reported = 1 WHERE id =' . $commentId);
        
        return $req;          
    }
    
    public function readComment($commentId){
        $db = $this->dbConnect();
        $req = $db->exec('UPDATE comments SET commentRead = 1 WHERE id =' . $commentId);
                
        return $req;          
    }
    
    public function checkComment($commentId){
        $db = $this->dbConnect();
        $req = $db->exec('UPDATE comments SET checked = 1, reported = 0, commentRead = 1 WHERE id =' . $commentId);
        
        return $req;          
    }
    
    public function deleteComment($commentId){
        $db = $this->dbConnect();
        $req = $db->exec('DELETE FROM comments WHERE id =' . $commentId);
        
        return $req;  
    }
    
}
