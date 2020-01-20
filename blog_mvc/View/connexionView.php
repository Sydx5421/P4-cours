<?php $titleVue = "Connectez-vous"; ?>
<?php ob_start(); ?>
<div class="card-body">
    <form>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="username">

        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="password">
        </div>
        <div class="row align-items-center remember">
            <input type="checkbox">Remember Me
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn float-right login_btn">
        </div>
    </form>
</div>
<a href="posts">voir les posts</a>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>