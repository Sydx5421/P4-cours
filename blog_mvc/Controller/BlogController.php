<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;


class BlogController extends AbstractController
{    
    
    public function home(){
//        echo('je suis la page home');
        $data = 'mes données provenant du controller (soon via le Model...)'; //peut être utilisé directement car le require est fait au sein de  la méthode
        
        $this->addFlash('Coucou', 'success');
        
        require 'View/home.php';   
    }
    
    public function posts(){
        $postsManager = new PostsManager();
        $posts = $postsManager->getPosts();
        
        require 'View/listPostsView.php';
    }
    
    public function onePost($postId) {
        
        $postsManager = new PostsManager();
        $commentsManager = new CommentsManager();
        // rendre dynamique le choix du post
        $post = $postsManager->getPost($postId);
        $comments = $commentsManager->getComments($postId);
        
//        if($this->isPost()){
//            $comment = new \App\Model\Entity\Comment;
//            $comment->setAuthor($_POST['author']);
//            $comment->setComment($_POST['comment']);
//            $comment->setPost_id($post_id);
//            $newComment = $commentsManager->postComment($comment);
//
//            if ($newComment === false) {
//                die('Impossible d\'ajouter le commentaire !');
//            }
//            else {
//                header('Location: index.php/post/' . $comment->getPost_id());
//            }
//        }
        
        require 'View/onePostView.php';
    }
    
    public function addComment(){// à supprimer 
//        vd($_POST);
        $comment = new \App\Model\Entity\Comment;
        $comment->setAuthor($_POST['author']);
        $comment->setComment($_POST['comment']);
        $comment->setPost_id($_POST['post_id']);
//        vd($comment);
//        vd('on entre dans la fonction addComment!');
//        $commentsManager = new CommentsManager();
        $newComment = $commentsManager->postComment($comment);

        if ($newComment === false) {
            die('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: index.php/post/' . $comment->getPost_id());
        }
        require 'View/onePostView.php';
    }
    
    public function connection(){
        
        require 'View/connexionView.php';   
    }
    
}