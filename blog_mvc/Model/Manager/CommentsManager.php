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
        $req = $db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date');

        $req->execute(array($postId));
        
//        $comments = array();
        
        while($comment = $req->fetchObject('App\Model\Entity\Comment')){
                $comments[] = $comment;
            }
        
            $req->closeCursor();
        
        return $comments;
    }

    public function add(Comment $comment)
    {
        $db = $this->dbConnect(); 
        $req = $db->prepare('INSERT INTO comments SET post_id = :post_id, author = :author, comment = :comment, date = NOW()');
        
        $req->bindValue(':post_id', $comment->getPost_id(), \PDO::PARAM_INT);
        $req->bindValue(':author', $comment->getAuthor());
        $req->bindValue(':comment', $comment->getComment());
        
        $req->execute();
        
        $comment->setId($id);        
    }
    
}
