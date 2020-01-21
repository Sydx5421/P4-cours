<?php $titleVue = "Home sweet home"; ?>
<?php ob_start(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Jean Forteroche - Billet simple pour l'Alaska</h1>
            <p class="lead">Chaque semaine découvrez un nouveau chapitre de mon nouveau roman en ligne !</p>
        </div>
    </div>
</div>


<p>
    <?php if(isset($data)): ?>
        <?= $data; ?>
    <?php endif; ?>
</p>
<a href="posts">voir les posts</a>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>