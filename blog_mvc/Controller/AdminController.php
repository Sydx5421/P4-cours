<?php
//P4 Brouillon

namespace App\Controller;

use App\Model\Manager\PostsManager;
use App\Model\Manager\CommentsManager;



class AdminController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        
        if(!$this->isAdmin){
            // Vous n'avez rien à faire là ! 
        }
    }
}