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

    public function postComment(Comment $comment)
    {
//        vd('on entre dans la fonction postComment!');
//        vd($comment->getAuthor());
        
        $db = $this->dbConnect(); 
        $req = $db->prepare('INSERT INTO comments(post_id, author, comment) VALUES(:post_id, :author, :comment)');
        
        $req->bindValue(':post_id', $comment->getPost_id(), \PDO::PARAM_INT);
        $req->bindValue(':author', $comment->getAuthor());
        $req->bindValue(':comment', $comment->getComment());
//        $req->bindValue(':date', 'NOW()');
        
        $reqExec = $req->execute();
        
//        vd($req);
        vd($reqExec);
        // je suis pas sur de cette ligne..
        $comment->setId($id);       
        
        return $reqExec;
        
    }
    
}
