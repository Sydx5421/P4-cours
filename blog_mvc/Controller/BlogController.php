<?php

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;
use App\Model\Entity\Post;



class BlogController extends AbstractController
{    

    public function reportComment(){
        // Gestion des actions sur les commentaires en Ajax
        $commentsManager = new CommentsManager();
        if($this->isPost()){     
            if(isset($_POST['commentAction']) && isset($_POST['id'])){
                if($_POST['commentAction'] == 'reported'){
                    $response = new \stdClass();
                    $response->result = $commentsManager->reportComment($_POST['id']);
                    echo json_encode($response);
                }
            }
        }
    }
        
    public function home(){
        $postsManager = new PostsManager();
        $lastPost = $postsManager->getLastPost();
        require 'View/homeView.php';   
    }
    
    public function posts($currentPage=1){
        $postsManager = new PostsManager();
        $returnVars = $postsManager->getPosts($currentPage);
        
        $posts = $returnVars["posts"];
        $nbPages = $returnVars["nbPages"];
        $currentPage = $returnVars["currentPage"];
        
        require 'View/listPostsView.php';
    }
    
    // Affichage d'un Post et de ses commentaires + ajout de commentaires
    public function onePost($postId) {
        
        $postsManager = new PostsManager();
        $commentsManager = new CommentsManager();
        
        $post = $postsManager->getPost($postId);
        if($this->isPost()){     
            // gestion du signalement de commentaire
            if(isset($_POST['commentAction']) && isset($_POST['id'])){
                if($_POST['commentAction'] == 'reported'){
                    $response = new \stdClass();
                    $response->result = "on rentre dans l'action home";
                    echo json_encode($response);
                    die;                
                }
            }
            // gestion de l'ajout des nouveaux commentaires      
            $comment = new \App\Model\Entity\Comment;
            $comment->setAuthor($_POST['author']);
            $comment->setComment($_POST['comment']);
            if($comment->isValid()){
                $comment->setPostId($postId);
                $newComment = $commentsManager->postComment($comment);
            }else{
                $this->addFlash('Veuillez remplir tous les champs', 'danger');
            }

            if ($newComment === false) {
                die('Impossible d\'ajouter le commentaire !');
            }else {
                // On réoriente vers la page du post
                $referer = $_SERVER['HTTP_REFERER'];
                header("Location: $referer");
            }
        }
        
        $comments = $commentsManager->getComments($postId);
        require 'View/onePostView.php';
    }
    
    
    public function connexion(){
        if($this->isPost()){            
            if(isset($_POST['admin']) && isset($_POST['mdp'])){
                $yaml = yaml_parse_file('./Config/parameters.yml');

                $authorisedAdmin = $yaml["admin_login"];
                $mdp = $yaml["admin_password"];

                if($_POST['admin']===$authorisedAdmin && $_POST['mdp']===$mdp){  
                    $_SESSION['adminConnected'] = true;  
                    $this->isAdmin = true;   
                    $this->addFlash('Bienvenue ', 'success');
                    
                    $referer = $this->basePath . "dashboard";
                    header("Location: $referer");
                }else{
                    $this->addFlash('Erreur, le mot de passe et/ou le login sont incorrectes', 'danger');
                }
            }
        }      
        require 'View/connexionView.php';   
    }
    
}