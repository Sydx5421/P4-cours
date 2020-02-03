<?php $titleVue = "Edition"; ?>
<?php $pageClass = "insideBlog"?>

<!-- Page Content -->
<?php ob_start(); ?>
<?php // echo($title); ?>
<?php // echo($content); ?>
<div class="container">
    <h3>Editer un nouvel article</h3>
    <form action="" method="post">
        <input id="postId" name="postId" type="hidden" value="<?php echo(isset($postId)? $postId : ''); ?>">
        <div class="form-group">
            <label for="postTitle">Titre de l'article</label>
            <input type="text" class="form-control form-control-lg" id="postTitle" name="postTitle" aria-describedby="Titre de l'article" placeholder="Chapitre_ : Titre du chapitre ou de l'article" value="<?php echo(isset($title)? $title : ''); ?>">
            <small id="postTitle" class="form-text text-muted">Ce titre sera le titre principale de la page du post</small>
        </div>
        <label for="contentPost">Contenu de l'article</label>
        <textarea class="tinymce" id="contentPost" name="contentPost"><?php echo(isset($content)? $content : ''); ?></textarea>
        <button type="submit" class="btn btn-primary text-right">Poster cet article</button>
    </form>    
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>

