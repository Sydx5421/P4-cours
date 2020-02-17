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
                
        // traitement du formulaire de gestion des commentaires
        if(isset($_POST['actionSignalement_(\d+)'])){            
            //Prise en compte du traitement des commentaires signalés
            $commentsManager = new CommentsManager();
            $comments = $commentsManager->getReportedComments();

            foreach($comments as $comment){
                if($_POST['actionSignalement_' . $comment->getId()] === 'checked'){
                    // le commentaire est valider ->x mettre le champ checked à 1
                    $commentsManager->checkComment($comment->getId());

                }elseif($_POST['actionSignalement_' . $comment->getId()] === 'unprocessed'){
                    // le commentaire n'a pas été traité par l'auteur, il reste donc signalé -> laisser le champ reported à 1
                    $commentsManager->reportComment($comment->getId());
                }elseif($_POST['actionSignalement_' . $comment->getId()] === 'delete'){
                    // le commentaire est supprimé -> appeler la fonction de suppression sur ce commentaire
                    $commentsManager->deleteComment($comment->getId());
                }
            }                
        }
        
        $postsManager = new PostsManager();
//        $post = $postsManager->getPost($postId) ;
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getReportedComments();
        
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