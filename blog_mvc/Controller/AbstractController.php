<?php

namespace App\Controller;

class AbstractController
{
    protected $basePath;//chemin de base de mon site pour faire des lien absolu
    //Créer un attribut isAdmin qui permettra de savoir si l'admin est connécté ou non
    
    public function __construct() {
        
        $contextDocumentRoot = $_SERVER["CONTEXT_DOCUMENT_ROOT"];      
        $rootDir = str_replace('\\', '/', realpath(__DIR__.'/../'));
        $relativeRootDir = str_replace($contextDocumentRoot, '', $rootDir);      
//        vd($contextDocumentRoot, $relativeRootDir);
        
        $this->basePath =  $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . $relativeRootDir . '/';
    }
    
    
    protected function addFlash($message, $type = 'info'){
        $_SESSION["message_flash"] = [
           'message' => $message,
            'type' => 'alert-' . $type//(permet d'exploité direct l'info comme class bootstrap
        ];
        
    }
    
    protected function isPost(){
        // a faire
        //vérifier si on est en méthode post ou non (si un formulaire a bien été soumis.
        return isset($_POST);
    }
    
}
