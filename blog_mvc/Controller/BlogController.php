<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;
use App\Model\Entity\Post;



class BlogController extends AbstractController
{    

    public function __construct() {
        parent::__construct();
    }
    
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
                $this->isAdmin = true;   
                $this->addFlash('Bienvenue ', 'success');
            }else{
                $this->addFlash('Erreur, le mot de passe et/ou le login sont incorrectes', 'danger');
            }
        }
        
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getAllComments();
                        
        require 'View/connexionView.php';   
    }
    
}