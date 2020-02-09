<?php $titleVue = "Connectez-vous"; ?>
<?php $pageClass = "connexion_dashboard"?>
<?php ob_start(); ?>
<div class="card-body text-center">
    <?php // if($adminConnected === false): ?>
    <?php if($this->isAdmin===false): ?>
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
        
        <a href="postEdition" title="Aller rédiger un nouvel article" class="btn btn-secondary  mt-4 mb-2" role="button">Rédiger un nouvel article</a>
        
        <h4>Modération des commentaires</h4>
        <h5>Commentaires signalés</h5>
        <div>
            <div class="media mb-4">  
                <table class="table">
                    <thead class="">
                        <tr class="d-flex">
                            <th scope="col" class="col-8">Commentaire</th>
                            <th scope="col" class="col-1"><i class="fas fa-flag"></i></th>
                            <th scope="col" class="col-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($comments as $comment):?>
                            <tr class="d-flex">
                                <td class="col-8">
                                    <h5 class="mt-0"><?= htmlspecialchars($comment->getAuthor()) ?> - le <?= $comment->getComment_date(); ?></h5>
                                    <?= htmlspecialchars($comment->getComment()) ?>
                                </td>
                                <td class="col-1">
                                    NB
                                </td>
                                <td class="col-3">
                                    <input type="radio" name="actionSignalement" value="male">Valider<br>
                                    <input type="radio" name="actionSignalement" value="female"> Non traité<br>
                                    <input type="radio" name="actionSignalement" value="other"> Supprimer 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <tfoot>
                        <tr class="d-flex">
                            <th scope="col" class="col-8">Commentaire</th>
                            <th scope="col" class="col-1"><i class="fas fa-flag"></i></th>
                            <th scope="col" class="col-3"><button type="button" class="btn btn-secondary">Valider</button></th>
                        </tr>
                    </tfoot>
                        
                    </tbody>
                </table>
            </div>
            
        </div>
        <h5>Nouveaux Commentaires </h5>
        <div>
            
        </div>
        
    <?php endif; ?>
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>