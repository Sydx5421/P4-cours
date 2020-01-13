<?php $titleVue = "Page des Posts"; ?>
<?php ob_start(); ?>

    
<section id="section_article">
    <div class="container bg-white">
        <div id="div_article" class="row text-left">
            <div class="col-md-12">
                <?php //* @var $post App\Model\Entity\Post */ ?>
                <?php foreach ($posts as $post):?>
                    <article class="mb-5 mt-5 offset-1">
                    <h2><?= htmlspecialchars($post->getTitle()) ?></h2>
                    <p>Publié le <?= ($post->getCreation_date())?></p>
                    <div class="text-justify">
                        <?= nl2br(htmlspecialchars($post->getContent())) ?>
                    </div>
                    <a href="post/<?= ($post->getId())?>" title="Lire la suite de l'article" class="btn btn-secondary  mt-4 mb-2" role="button">Lire la suite</a>
                    <hr>
                    </article>	
                <?php endforeach; ?>
            </div>
        </div>	
            <a href="home" title="retour à l'accueil" class="btn btn-secondary  mt-4 mb-2" role="button">retour à l'accueil</a>
    </div>
</section>

<?php $content = ob_get_clean();?>
<?php require('postTemplate.php') ?>