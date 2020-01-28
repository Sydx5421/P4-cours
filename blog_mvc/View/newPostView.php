<?php $titleVue = "Edition"; ?>
<?php $pageClass = "insideBlog"?>

<!-- Page Content -->
<?php ob_start(); ?>
<div class="container">
    <h3>Editer un nouvel article</h3>
    <form action="" method="post">
    <!--    <label for="postTitle">Titre de l'article</label>
        <input type="text" id="postTitle" name="postTitle">-->
        <label for="contentPost">Contenu de l'article</label>
        <textarea class="tinymce" id="contentPost" name="contentPost"></textarea>
        <button type="submit" class="btn btn-primary text-right">Poster cet article</button>
    </form>    
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>

