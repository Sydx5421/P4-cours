<?php ob_start(); ?>
    <span class="title">Billet simple pour l'Alaska</span>
    <span  class="author">Jean FORTEROCHE</span>
<?php $titleVue = ob_get_clean();?>
<?php $pageClass = "blogHome"?>
<?php ob_start(); ?>

<div class="container">
    <div class="">
        <div class="text-center">
            <h2 class="mt-5">Bienvenue sur le roman-blog de Jean Forteroche</h2>
            <p class="lead">Chaque semaine découvrez un nouveau chapitre de mon nouveau roman en ligne !</p>
        </div>
    </div>
    <section  class="row">
        <?php //* @var $lastPost App\Model\Entity\Post */ ?>             	
        <article class="nwl_last_article mb-5 mt-5  col-sm-12 col-md-6">
            <h3>Retrouvez ici tous les chapitres précédents</h3>
            <hr>
            <h4>Résumé</h4>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>
            
            <a href="posts" title="Accéder à la liste de tous les chapitres publiés" class="btn btn-secondary  mt-4 mb-2" role="button">voir tous les chapitres publiés</a>
            <hr>
        </article>
        <article class="nwl_last_article mb-5 mt-5  col-md-6 col-sm-12">
            <h3>Découvrez sans attendre le dernier chapitre !</h3>
            <hr>
            <h4><?= htmlspecialchars($lastPost->getTitle()) ?></h4>
            <p>Publié le <?= ($lastPost->getCreation_date())?></p>
            <div class="text-justify">
                <?= extrait($lastPost->getContent(), 0, 250) ?>
            </div>
            <a href="post/<?= ($lastPost->getId())?>" title="Lire la suite de l'article" class="btn btn-secondary  mt-4 mb-2" role="button">Lire la suite</a>
            <hr>
        </article>
    </section>
    <section>
        <h3>A propos...</h3>
        <hr>
        <h4>de l'auteur</h4>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
        <h4>du choix du roman en ligne</h4>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            
        </p>
        <p>
            N'hésitez donc pas à commenter les chapitres, vos retours, suggestions, ressentis, envies sont toutes les biens venues !
        </p>
        <p>Bonne lecture et au plaisir de vous lire ! ;)</p>
        
        <a href="<?=$this->basePath?>posts" title="liste de tous les chapitres publiés" class="btn btn-secondary  mt-4 mb-2" role="button">Commencer la lecture</a>
        
    </section>
</div>


<p>
    <?php if(isset($data)): ?>
        <?= $data; ?>
    <?php endif; ?>
</p>
<?php $content = ob_get_clean();?>

<?php require('blogTemplate.php') ?>