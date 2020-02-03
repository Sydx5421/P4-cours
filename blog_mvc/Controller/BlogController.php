<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;
use App\Model\Entity\Post;



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
    
    public function postEdition($postId=null){
        $postsManager = new PostsManager();
//        vd('Action post edition');
        $messageFlash;
        $messageType;
        $referer;
        
        
        if(isset($postId)){
            $post = $postsManager->getPost($postId);
            
            $title = $post->getTitle();
            $content = $post->getContent();
            
            $messageFlash = 'Vous pouvez éditer puis publier votre article pour enregistrez les modification';
            $messageType = 'primary';
            
            $referer = "postEdition";
            
        }
        
        if($this->isPost()){
            if(!$_POST['contentPost'] || !$_POST['postTitle']){
                $title = isset($_POST['postTitle']) ? $_POST['postTitle'] : '';
                $content = isset($_POST['contentPost']) ? $_POST['contentPost'] : '';                
                
                $messageFlash = 'Tous les champs doivent être remplit';
                $messageType = 'danger';
                                
                $referer = "postEdition";
                
            }else{
                $post = new \App\Model\Entity\Post;
                
                $post->setContent($_POST['contentPost']);
                $post->setTitle($_POST['postTitle']);
                $newPost = $postsManager->postPost($post);
            
                if ($newPost === false) {
                    
                    $messageFlash = 'Votre Article n\'a pas pu être enregistré';
                    $messageType = 'danger';
                    
                    $referer = "postEdition";                    
                }
                else {
                    $messageFlash = 'Votre Article a bien été posté';
                    $messageType = 'success';
                    
                    $referer = $this->basePath . "posts";
                    
                    header("Location: $referer");
                }                
            }            
        }
        
        if(isset($messageFlash) && isset($messageType)){
            $this->addFlash($messageFlash, $messageType);        
        }
         
        if(isset($referer)){
            if($referer === "posts"){                
                require 'View/listPostsView.php';
            }elseif($referer === "postEdition"){
                require 'View/newPostView.php';
            }            
        }else{
            require 'View/newPostView.php';
        }
    }    
}