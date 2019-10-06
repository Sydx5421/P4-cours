<?php

//require('../public/functions.php'); // ajout perso pour y mettre mes fonction var_dump et var_dump+die

require('./model/frontend.php');

function listPosts(){
    $posts = getPosts();
    require('./view/frontend/listPostsView.php');
}

function post(){
    $post = getPost($_GET['id']);
    $comments = getComments($_GET['id']);
    require('./view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $affectedLines = postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}