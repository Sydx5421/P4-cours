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
        
//        vd($this->isPost());
        
        if($this->isPost()){
            $comment = new \App\Model\Entity\Comment;
            $comment->setAuthor($_POST['author']);
            $comment->setComment($_POST['comment']);
            $comment->setPostId($postId);
            $newComment = $commentsManager->postComment($comment);

            if ($newComment === false) {
                die('Impossible d\'ajouter le commentaire !');
            }
            else {
                // On réoriente vers la page du post
                $referer = $_SERVER['HTTP_REFERER'];
                header("Location: $referer");
            }
        }
        
        require 'View/onePostView.php';
    }
    
    
    public function connection(){
        
        $yaml = yaml_parse_file('App\Config\parameters.yml');
        $parsed = yaml_parse($yaml);
        require 'View/connexionView.php';   
    }
    
    public function edition(){
        require 'View/newPostView.php'; 
    }
    
}