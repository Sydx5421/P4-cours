<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;

class BlogController
{
    public function home(){
//        echo('je suis la page home');
        $data = 'mes données provenant du controller (soon via le Model...)'; //peut être utilisé directement car le require est fait au sein de  la méthode
        require 'View/home.php';   
    }
    public function posts(){
        $postsManager = new PostsManager();
        $posts = $postsManager->getPosts();
        
        require 'View/listPostsView.php';
    }
    
    public function onePost($id) {
        
        $postsManager = new PostsManager();
        // rendre dynamique le choix du post
        $post = $postsManager->getPost($id);
        
        require 'View/onePostView.php';
    }
    
}