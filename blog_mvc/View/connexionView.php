<?php $titleVue = "Connectez-vous"; ?>
<?php $pageClass = "connexion"?>
<?php ob_start(); ?>

<div class="card-body text-center">
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
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>

<!--Gestion du message flash-->
<?php if(isset($_SESSION['message_flash'])){
    if($_SESSION['message_flash']['redirect'] === true){
        unset($_SESSION['message_flash']);
    }
}?>
<!------------- End flash---->