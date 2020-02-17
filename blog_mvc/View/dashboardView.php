<?php $titleVue = "Tableau de bord"; ?>
<?php $pageClass = "dashboard"?>
<?php ob_start(); ?>
<div class="card-body text-center">
    <h3>Bienvenue sur votre tableau de bord Jean</h3>

    <a href="postEdition" title="Aller rédiger un nouvel article" class="btn btn-secondary  mt-4 mb-2" role="button">Rédiger un nouvel article</a>

    <h4>Modération des commentaires</h4>
    <h5>Commentaires signalés</h5>
    <div>
        <div class="media mb-4">  
            <form action="<?=$this->basePath?>dashboard" method="post">
                <table class="table">
                    <thead class="">
                        <tr class="d-flex">
                            <th scope="col" class="col-7">Commentaire</th>
                            <th scope="col" class="col-2">Article ou chapitre</th>
                            <th scope="col" class="col-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php if($comments == null):?>
                        <tr class="d-flex">
                            <td class="col-12 text-center">
                                <h5 class="mt-0">Vous n'avez aucun commentaires signalés</h5>
                            </td>
                        </tr>
                        <?php endif ; ?>
                        <?php foreach ($comments as $comment):?>
                            <tr class="d-flex">
                                <td class="col-7 text-left">
                                    <h5 class="mt-0"><?= htmlspecialchars($comment->getAuthor()) ?> - le <?= $comment->getComment_date(); ?></h5>
                                    <?= htmlspecialchars($comment->getComment()) ?>
                                </td>
                                <td class="col-2">
                                    <a href="<?=$this->basePath?>post/<?= $comment->getPostId(); ?>" target="_blank"><?= htmlspecialchars($postsManager->getPost($comment->getPostId())->getTitle()) ?></a>
                                </td>
                                <td class="col-3">
                                    <input type="radio" name="actionSignalement_<?= $comment->getId(); ?>" value="checked">Valider<br>
                                    <input type="radio" checked="checked" name="actionSignalement_<?= $comment->getId(); ?>" value="unprocessed"> Non traité<br>
                                    <input type="radio" name="actionSignalement_<?= $comment->getId(); ?>" value="delete"> Supprimer 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <tfoot>
                        <tr class="d-flex">
                            <th scope="col" class="col-8">Commentaire</th>
                            <th scope="col" class="col-1"><i class="fas fa-flag"></i></th>
                            <th scope="col" class="col-3">
                                <!--<button type="button" class="btn btn-secondary">Valider</button>-->
                                <input type="submit" value="Valider" class="btn login_btn">
                            </th>
                        </tr>
                    </tfoot>

                    </tbody>
                </table>
            </form>
        </div>

    </div>
    <h5>Nouveaux Commentaires </h5>
    <div>

    </div>
</div>
<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>