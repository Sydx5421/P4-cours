<?php
//P4 Brouillon

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
            // vérifié si on est en mode ajax :
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
        
        if($this->isPost()){
     
            // vérifié si on est en mode ajax :
            if(isset($_POST['commentAction']) && isset($_POST['id'])){
//                    $dferer = $this->basePath . "posts";
//                    header("Location: $referer");
                if($_POST['commentAction'] == 'reported'){
                    $response = new \stdClass();
//                    $response->result = $commentsManager->reportComment($_POST['id']);
                    $response->result = "on rentre dans l'action home";
                    echo json_encode($response);
//                    vd($response);
                    die;                
                }
            }
            //------            
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
        $comments = $commentsManager->getComments($postId);
        require 'View/onePostView.php';
    }
    
    
    public function connection(){
        if($this->isPost()){            
            if(isset($_POST['admin']) && isset($_POST['mdp'])){
                $yaml = yaml_parse_file('./Config/parameters.yml');

                $authorisedAdmin = $yaml["admin_login"];
                $mdp = $yaml["admin_password"];

                if($_POST['admin']===$authorisedAdmin && $_POST['mdp']===$mdp){  
                    $_SESSION['adminConnected'] = true;  
                    $this->isAdmin = true;   
                    $this->addFlash('Bienvenue ', 'success');
                    // Faire un redirec vers une page Dashboard que j'aurait créer !
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