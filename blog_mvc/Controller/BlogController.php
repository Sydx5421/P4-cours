<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;



class BlogController extends AbstractController
{    
    
    public function home(){
        // vérifié si on est en mode post
//        $response = new \stdClass();
//        $response->result = $_POST['id'];
//        echo json_encode($response);
////        vd($response);
//        die;
        $postsManager = new PostsManager();
        $lastPost = $postsManager->getLastPost();
        require 'View/home.php';   
    }
    
    public function posts(){
        $postsManager = new PostsManager();
        $posts = $postsManager->getPosts();
        
        require 'View/listPostsView.php';
    }
    
    // Affichage d'un Post et de ses commentaires + ajout de commentaires
    public function onePost($postId) {
        
        $postsManager = new PostsManager();
        $commentsManager = new CommentsManager();
        
        $post = $postsManager->getPost($postId);
        $comments = $commentsManager->getComments($postId);
        
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
//        $adminConnected = false;
        if($this->isPost() && isset($_POST['admin']) && isset($_POST['mdp'])){
            $yaml = yaml_parse_file('./Config/parameters.yml');
            
            $authorisedAdmin = $yaml["admin_login"];
            $mdp = $yaml["admin_password"];
            
            if($_POST['admin']===$authorisedAdmin && $_POST['mdp']===$mdp){
                $_SESSION['adminConnected'] = true;         
                $this->addFlash('Bienvenue ', 'success');
            }else{
                $this->addFlash('Erreur, le mot de passe et/ou le login sont incorrectes', 'danger');
            }
        }
        
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getAllComments();
                        
        require 'View/connexionView.php';   
    }
    
    public function deconnection(){
        session_destroy();
        session_start();// On redémarre une session anonyme pour pouvoir afficher le message de déconnexion
        $this->addFlash('Deconnexion ', 'danger');
        
        $referer = $this->basePath . "home";
        header("Location: $referer");
    }
    
    public function postEdition(){
        $postsManager = new PostsManager();
        if($this->isPost()){
            $post = new \App\Model\Entity\Post;
            $post->setContent($_POST['contentPost']);
            $newPost = $postsManager->postPost($post);

            if ($newPost === false) {
                die('Impossible d\'ajouter le l\'article !');
            }
            else {
                // On réoriente vers la page du post
                $referer = $this->basePath . "postEdition";
                header("Location: $referer");
            }
        }
        
        require 'View/newPostView.php'; 
    }
    
}