<?php

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;
use App\Model\Entity\Post;

class AdminController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        
        if($this->isAdmin === false){
            $this->redirectIfNotCOnnected();
        }
    }

    protected function redirectIfNotCOnnected(){
        $this->addFlash("Ces pages sont réservées à l'administrateur, veuillez vous connecter.", "danger", true);
        $referer = $this->basePath . "connexion";
        header("Location: $referer");       
        die;
    }
    
    public function dashboard(){
        if($this->isPost()){    
            $commentsManager = new CommentsManager();
            foreach ($_POST as $key => $value){
                if(preg_match('#^actionSignalement_(\d+)$#', $key, $matches) === 1){
                    if($value === 'checked'){
                        $commentsManager->checkComment($matches[1]);
                    }elseif($value === 'delete'){
                    $commentsManager->deleteComment($matches[1]);
                    }
                }elseif(preg_match('#^actionNewComment_(\d+)$#', $key, $matches) === 1){
                    if($value === 'commentRead'){
                        $commentsManager->readComment($matches[1]);
                    }elseif($value === 'delete'){
                    $commentsManager->deleteComment($matches[1]);
                    }
                }
            }
        }
        
        $postsManager = new PostsManager();
        $commentsManager = new CommentsManager();
        $reportedComments = $commentsManager->getReportedComments();
        
        $newComments = $commentsManager->getNewComments();
        $newCommentsNb = $commentsManager->getNewCommentsNb();
        $reportedCommentsNb = $commentsManager->getReportedCommentsNb();
        
        
        require 'View/dashboardView.php'; 
    }


    public function adminActionComment(){
        // Gestion des actions sur les commentaires en Ajax
        $commentsManager = new CommentsManager();
        if($this->isPost()){     
            if(isset($_POST['commentAction']) && isset($_POST['id'])){
                if($_POST['commentAction'] == 'read'){
                    $response = new \stdClass();
                    $response->result = $commentsManager->readComment($_POST['id']);
                    echo json_encode($response);
                }elseif($_POST['commentAction'] == 'checked'){
                    $response = new \stdClass();
                    $response->result = $commentsManager->checkComment($_POST['id']);
                    echo json_encode($response);
                }elseif($_POST['commentAction'] == 'delete'){
                    $response = new \stdClass();
                    $response->result = $commentsManager->deleteComment($_POST['id']);
                    echo json_encode($response);
                }
            }
        }
    }

        public function deconnexion(){
        session_destroy();
        session_start();// On redémarre une session anonyme pour pouvoir afficher le message de déconnexion
        $this->addFlash('Vous êtes déconnecté.', 'info');

        $referer = $this->basePath . "home";
        header("Location: $referer");
    }

    public function postEdition($postId=null){
        $postsManager = new PostsManager();
        $messageFlash;
        $messageType;
        $referer;        
        
        if(isset($postId)){
            $post = $postsManager->getPost($postId);
            
            $title = $post->getTitle();
            $content = $post->getContent();
            
            $messageFlash = 'Vous pouvez éditer puis publier votre article pour enregistrez les modifications';
            $messageType = 'primary';            
            $referer = "postEdition";            
        }
        
        if($this->isPost()){
            
            if(!$_POST['contentPost'] || !$_POST['postTitle']){
                $title = isset($_POST['postTitle']) ? $_POST['postTitle'] : '';
                $content = isset($_POST['contentPost']) ? $_POST['contentPost'] : '';                                
                $messageFlash = 'Tous les champs doivent être remplis';
                $messageType = 'danger';
                                
                $referer = "postEdition";
                
            }else{
                if(isset($_POST['postId']) && $_POST['postId'] != null ){// UPDATE   
                    $post = $postsManager->getPost($_POST['postId']);
                    $post->setContent($_POST['contentPost']);
                    $post->setTitle($_POST['postTitle']);
                    
                    $updatedPost = $postsManager->updatePost($post);
                    
                }else{
                    $post = new \App\Model\Entity\Post;                
                    $post->setContent($_POST['contentPost']);
                    $post->setTitle($_POST['postTitle']);
                    $newPost = $postsManager->postPost($post);
                }
                
                if(isset($newPost)){ // Cas de la création d'un post
                    if ($newPost === false) {                    
                        $messageFlash = 'Votre Article n\'a pas pu être enregistré';
                        $messageType = 'danger';

                        $referer = "postEdition";                    
                    }else{
                        $messageFlash = 'Votre Article a bien été posté';
                        $messageType = 'success';

                        $referer = $this->basePath . "posts";

                        header("Location: $referer");
                    }
                }elseif(isset ($updatedPost)){
                    if ($updatedPost === false) {                    
                        $messageFlash = 'Votre Article n\'a pas pu être mis à jour';
                        $messageType = 'danger';

                        $referer = "postEdition";                    
                    }else{
                        $messageFlash = 'Votre Article a bien été mis à jour';
                        $messageType = 'success';

                        $referer = $this->basePath . "posts";

                        header("Location: $referer");
                    }
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
    
    public function deletePost($postId){
        $postsManager = new PostsManager();
        $postToDelete = $postsManager->getPost($postId);
        $messageFlash;
        $messageType;
        $referer;
        
        if(isset($postId)){
            $postDeleted = $postsManager->deletePost($postId);
            if($postDeleted == 1){
                $messageFlash = 'L\'article intitulé : "' . $postToDelete->getTitle() . '" a bien été supprimé';
                $messageType = 'success';
                
                $referer = $this->basePath . "posts";

                header("Location: $referer");
            }else{
                if ($postToDelete instanceof Post ){
                    $messageFlash = 'L\'article intitulÃ© : "' . $postToDelete->getTitle() . '" n\'a pas pu Ãªtre supprimÃ©';
                    $messageType = 'danger';                    
                }else{
                    $messageFlash = "Cet élément n'existe pas";
                    $messageType = 'danger';
                }
                    $referer = $this->basePath . "posts";
                    header("Location: $referer");
            }
        }
        
        //-----
        if(isset($messageFlash) && isset($messageType)){
            $this->addFlash($messageFlash, $messageType, true);        
        }
        
    }
}