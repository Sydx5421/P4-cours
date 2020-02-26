<?php $titleVue = (isset($post) && $post !=null)? htmlspecialchars($post->getTitle()) : ''; ?>
<?php $pageClass = "onePostVIew"?>
<!-- Page Content -->
<?php ob_start(); ?>
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-12">
            <!-- Author -->
            <div class="d-flex justify-content-between">
                <p class="lead">
                  by
                  <a href="<?=$this->basePath?>home#author_description">Jean Forteroche</a>
                </p>
                <?php if($this->isAdmin===true): ?>
                    <div>
                        <a href="<?=$this->basePath?>postEdition/<?= ($post->getId())?>" type="button" class="btn btn-secondary">Editer</a>
                        <a href="<?=$this->basePath?>deletePost/<?= ($post->getId())?>" type="button" onclick="return confirm('Êtes-vous sur de vouloir supprimer cet article ?')" class="btn btn-danger">Supprimer</a>
                    </div>                
                <?php endif; ?>
            </div>

            <hr>

            <!-- Date/Time -->
            <p><?= ($post->getCreation_date())?></p>

            <!-- Post Content -->

            <div class="text-justify nwl_postContent">
                <?= nl2br($post->getContent()) ?>
            </div>

            <hr>

            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Laissez un commentaire:</h5>
                <div class="card-body">
                    <form action="" method="post">

                        <div class="form-group">
                            <?= isset($erreurs) && in_array(\Entity\Comment::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : '' ?>
                        </div>
                        <div class="form-group">
                            <label for="author">Pseudo</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Votre Pseudo" value="<?= isset($comment) ? htmlspecialchars($comment['auteur']) : '' ?>" /><br />
                        </div>
                        <div class="form-group">
                            <?= isset($erreurs) && in_array(\Entity\Comment::CONTENU_INVALIDE, $erreurs)? 'Le contenu est invalide.<br />' : '' ?>
                        </div>
                        <div class="form-group">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Votre commentaire"><?= isset($comment) ? nl2br(htmlspecialchars($comment['contenu'])) : '' ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Commenter</button>
                    </form>
                </div>
            </div>

            <!-- Single Comment -->
            <?php foreach ($comments as $comment):?>
                <div class="media mb-4 comment_elt">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?= htmlspecialchars($comment->getAuthor()) ?> - le <?= $comment->getComment_date() ?></h5>
                        <?= nl2br(htmlspecialchars($comment->getComment())) ?>
                    </div>
                    <div>
                        <?php if($this->isAdmin===false): /* Vu pour les lecteurs */ ?>
                            <?php if($comment->getChecked() == 1): ?>
                                <div title="Ce commentaire a été validé par l'admin"><i class="fas fa-check"></i></div>
                            <?php elseif($comment->getReported() == 0): ?>
                                <button class="btn nwl_reportComment" data-id="<?= $comment->getId(); ?>" title="Signale ce commentaire à l'administrateur">signaler</button>
                            <?php else: ?>    
                                <div title="Ce commentaire a déjà été signalé et sera modéré par l'admin"><i class="fas fa-flag"></i></div>
                            <?php endif; ?>
                            
                        <?php else: /* Vu pour l'admin */ ?>                        
                            <?php if($comment->getCommentRead() == 0): ?>
                                <button class="btn btn-dark nwl_read" data-id="<?= $comment->getId(); ?>" title="Nouveau commentaire! clickez pour faire disparaitre cette alerte."><i class="fas fa-exclamation-circle"></i></button>
                            <?php endif; ?>
                            <?php if($comment->getReported() == 1): ?>
                                <button class="btn btn-dark nwl_check" data-id="<?= $comment->getId(); ?>" title="Commentaire signalé par un utilisateur. clickez pour valider ce commentaire, sinon cliquez sur la corbeille pour le supprimer"><i class="fas fa-flag"></i></button>
                            <?php endif; ?>
                            <button class="btn nwl_suprimer  btn-dark" data-id="<?= $comment->getId(); ?>" title="Supprimer ce commentaire"><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>

<script>
    // On récupère tous les button de la page
    var allButtons = document.querySelectorAll('button[class^=btn]');
    
    // On abonne chaque bouton à un evt click
    for (var i = 0; i < allButtons.length; i++) {
        allButtons[i].addEventListener('click', function() {
            if(this.classList.contains("nwl_reportComment")){
                if ( confirm( "Êtes-vous sur-e de vouloir supprimer ce message?" ) ) {
                    // Code à éxécuter si le l'utilisateur clique sur "OK"
                    reportComment(this.getAttribute("data-id"));
                    parentElt = this.parentNode;
                    $(parentElt).append('<div title="Ce commentaire a déjà été signalé et sera modéré par l\'admin"><i class="fas fa-flag"></i></div>');
                    parentElt.removeChild(this);                    
                } 
            }else if(this.classList.contains("nwl_read")){                
                if ( confirm( "Êtes-vous sur-e de vouloir déclaré ce message comme lu?" ) ) {
                    // Code à éxécuter si le l'utilisateur clique sur "OK"
                    adminActionComment(this.getAttribute("data-id"), 'read');
                    parentElt = this.parentNode;
                    parentElt.removeChild(this);                    
                } 
            }else if(this.classList.contains("nwl_check")){
                if ( confirm( "Ce message a été signalé par un utilisateur. Êtes-vous sur-e de vouloir valider ce message?" ) ) {
                    // Code à éxécuter si le l'utilisateur clique sur "OK"
                    adminActionComment(this.getAttribute("data-id"), 'checked');
                    parentElt = this.parentNode;
                    parentElt.removeChild(this);                    
                } 
            }else if(this.classList.contains("nwl_suprimer")){
                if ( confirm( "Êtes-vous sur-e de vouloir suprimer ce message?" ) ) {
                    // Code à éxécuter si le l'utilisateur clique sur "OK"
                    adminActionComment(this.getAttribute("data-id"), 'delete');
                    commentElt = $(this).parents(".comment_elt");
                    commentEltParent = commentElt[0].parentNode;
                    commentEltParent.removeChild(commentElt[0]);                    
                } 
            }
        });
    }
    // action utilisateur
    function reportComment(commentId){ 
        var xhr = new XMLHttpRequest();
        let formData = new FormData(); //objet permettant de transmettre des données en POST
        formData.append("commentAction", "reported"); 
        formData.append("id", commentId); 
        xhr.open('POST','<?=$this->basePath?>reportComment' );
        xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si le fichier est chargé sans erreur
                let response = JSON.parse(xhr.response);
            }
        });

        xhr.send(formData);
    }
    
    function adminActionComment(commentId, action){ // actions administrateur
        var xhr = new XMLHttpRequest();
        let formData = new FormData();
        formData.append("commentAction", action); 
        formData.append("id", commentId); 
        xhr.open('POST','<?=$this->basePath?>adminActionComment' );
        xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si le fichier est chargé sans erreur
                let response = JSON.parse(xhr.response);
                if(response.result == 1){
                    let response = JSON.parse(xhr.response);
                }else if(response.result == 0) {
                    alert('le  commentaire d\'id : ' + commentId + ', n\'a PAS été ' + action);
                }
            }
        });
        xhr.send(formData);
    }
    
</script>