<?php $titleVue = "Home sweet home"; ?>
<?php ob_start(); ?>
<p>Voici la page d'accueil de mon blog</p>
<h3>Contenu spécifique à la vue demandée</h3>
<p>
    Avec le des données dynamique provenant de la BDD...
    <br/>
    Comming up soon !<br/>
    <?= $data ?>
</p>
<a href="posts">voir les posts</a>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>