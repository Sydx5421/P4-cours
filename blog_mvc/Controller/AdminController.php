<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;



class AdminController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        
//        vd($_SESSION['adminConnected'], $this->isAdmin);
        
        if($this->isAdmin === false){
            // Vous n'avez rien à faire là ! 
////            echo("Vous n'avez rien à faire là ! ");
//            $this->addFlash("Ces pages sont réservées à l'administrateur ", "danger");
//            require 'View/connexionView.php'; 
            $this->redirectIfNotCOnnected();
        }
    }

    protected function redirectIfNotCOnnected(){
        $this->addFlash("Ces pages sont réservées à l'administrateur ", "danger");
        require 'View/404View.php'; //virer
        exit();//virer
        // faire une redirection
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
            // vérifié si on est en mode ajax :
            if(isset($_POST['commentAction']) && isset($_POST['id'])){
                if($_POST['commentAction'] == 'read'){
//                    vd('Fonction READ !');
                    $response = new \stdClass();
                    $response->result = $commentsManager->readComment($_POST['id']);
                    echo json_encode($response);
                }elseif($_POST['commentAction'] == 'checked'){
                    $response = new \stdClass();
                    $response->result = $commentsManager->checkComment($_POST['id']);
                    echo json_encode($response);
//                    die;
                }elseif($_POST['commentAction'] == 'delete'){
                    $response = new \stdClass();
                    $response->result = $commentsManager->deleteComment($_POST['id']);
                    echo json_encode($response);
//                    die;
                }
            }
        }
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
                if(isset($_POST['postId'])){// UPDATE   
                    $post = $postsManager->getPost($_POST['postId']);
                    $post->setContent($_POST['contentPost']);
                    $post->setTitle($_POST['postTitle']);
//                    vd($post, $post->getContent(), $post->getId(), $post->getTitle());
                    // faire mon update ici
                    // créer la fonciton update post
                    $updatedPost = $postsManager->updatePost($post);
//                    vd("On post un formulaire et les var title et content sont bien rempli Et on a un post Id", '$updatedPost', $updatedPost );
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
    
}