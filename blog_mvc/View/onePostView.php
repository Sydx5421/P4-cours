<?php $titleVue = htmlspecialchars($post->getTitle()); ?>
<?php $pageClass = "onePostVIew"?>
<!-- Page Content -->
<?php ob_start(); ?>
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-12">

            <!-- Title -->
            <!--<h1 class="mt-4"><? // echo htmlspecialchars($post->getTitle()) ?></h1>-->

            <!-- Author -->
            <div class="d-flex justify-content-between">
                <p class="lead">
                  by
                  <a href="#">Jean Forteroche</a>
                </p>
                <?php if(isset($_SESSION['adminConnected'])): ?>
                    <div>
                        <button type="button" class="btn btn-secondary">Editer</button>
                        <button type="button" class="btn btn-danger">Supprimer</button>
                    </div>                
                <?php endif; ?>
            </div>

            <hr>

            <!-- Date/Time -->
            <p><?= ($post->getCreation_date())?></p>

<!--            <hr>

             Preview Image 
            <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">

            <hr>-->

            <!-- Post Content -->

            <div class="text-justify" style="word-break: break-word;">
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
                            <textarea name="comment" class="form-control" rows="3"><?= isset($comment) ? htmlspecialchars($comment['contenu']) : 'Votre commentaire' ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Commenter</button>
                    </form>
                </div>
            </div>

            <!-- Single Comment -->
            <?php foreach ($comments as $comment):?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?= htmlspecialchars($comment->getAuthor()) ?> - le <?= htmlspecialchars($comment->getComment_date()) ?></h5>
                        <?= htmlspecialchars($comment->getComment()) ?>
                    </div>
                    <div>
                        <?php if(!isset($_SESSION['adminConnected']) || $_SESSION['adminConnected'] === false): ?>
                            <a class="nwl_signaler" href=""><i class="fas fa-flag"></i></a>
                        <?php else: ?>
                            <a class="nwl_suprimer" href=""><i class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
          <!-- Comment with nested comments -->
          <!-- [...] -->

        </div>
    </div>
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>