<?php $titleVue = "Edition"; ?>


<!-- Page Content -->
<?php ob_start(); ?>

<textarea class="tinymce"></textarea>

<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>

