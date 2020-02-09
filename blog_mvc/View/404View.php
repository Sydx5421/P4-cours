<?php $titleVue = "404"; ?>
<?php $pageClass = "404"?>
<?php ob_start(); ?>
<div class="text-center">
    <p>Vous n'avez pas accès à cette page</p>
    <a class="nav-link" href="<?=$this->basePath?>home">Retour à l'accueil
        <span class="sr-only">(current)</span>
    </a>    
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>