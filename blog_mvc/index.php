<?php
require('./controller/frontend.php');

try{// on essaie de faire des choses..
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            }
            else {
                // Erreur !  On arrête tout, on envoie une exception, donc on saute directement au catch
                Throw new Exception('aucun identifiant de billet envoyé') ;
            }
        }
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    Throw new Exception('tous les champs ne sont pas remplis !') ;
                }
            }
            else {
                Throw new Exception('aucun identifiant de billet envoyé') ;
            }
        }
    }
    else {
        listPosts();
    }
}
catch(Exception $e){ // s'il y a une erreur, alors...
    $errorMessage = $e->getMessage();
    require('./view/frontend/errorView.php');
}