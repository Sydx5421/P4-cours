<?php $titleVue = "Connectez-vous"; ?>
<?php ob_start(); ?>
<div class="card-body text-center">
    <?php if($adminConnected === false): ?>
    <form action="" method="post" class="col-md-8 col-lg-6 text-center">
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="username" name="admin">

        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="password" name="mdp">
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn float-right login_btn">
        </div>
    </form>
    <?php else: ?>
        <h3>Bienvenue sur votre tableau de bord Jean</h3>
    <?php endif; ?>
</div>
<a href="posts">voir les posts</a>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>