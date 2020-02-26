<?php $titleVue = "Page des Posts"; ?>
<?php $pageClass = "insideBlog"?>
<?php ob_start(); ?>

    
<section id="section_article">
    <div class="container">
        <div id="div_article" class="row text-left">
            <div class="col-md-12">
                <?php //* @var $post App\Model\Entity\Post */ ?>
                <?php foreach ($posts as $post):?>
                    <article class="mb-5 mt-5 offset-1">
                    <h2><?= htmlspecialchars($post->getTitle()) ?></h2>
                    <p>Publié le <?= ($post->getCreation_date())?></p>
                    <div class="text-justify">
                        <?= extrait($post->getContent(),0, 200) ?>
                    </div>
                    <a href="<?=$this->basePath?>post/<?= ($post->getId())?>" title="Lire la suite de l'article" class="btn btn-secondary  mt-4 mb-2" role="button">Lire la suite</a>
                    <hr>
                    </article>	
                <?php endforeach; ?>
            </div>
        </div>	
    </div>
    
    <!-- Pagination -->
    
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if($currentPage-2 > 0): ?> 
                <li class="page-item">
                    <a class="page-link" href="<?=$this->basePath?>posts/<?= $currentPage-2?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <?php endif;?>
            <?php if($currentPage-1 > 0): ?>  
                <li class="page-item"><a class="page-link" href="<?=$this->basePath?>posts/<?= $currentPage-1?>"><?= $currentPage-1?></a></li>
            <?php endif;?>    
                <li class="page-item active"><a class="page-link" href="<?=$this->basePath?>posts/<?= $currentPage?>"><?= $currentPage?></a></li>
            <?php if($currentPage+1 <= $nbPages): ?>
                <li class="page-item"><a class="page-link" href="<?=$this->basePath?>posts/<?= $currentPage+1?>"><?= $currentPage+1?></a></li>
            <?php endif;?>
            <?php if($currentPage+2 <= $nbPages): ?>
                <li class="page-item">
                    <a class="page-link" href="<?=$this->basePath?>posts/<?= $currentPage+2?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <?php endif;?>
        </ul>
    </nav>
    <div class="justify-content-center">
        <a href="<?=$this->basePath?>home" title="retour à l'accueil" class="btn btn-secondary  mt-4 mb-2" role="button">retour à l'accueil</a>
    </div>
        
</section>

<?php $content = ob_get_clean();?>
<?php require('blogTemplate.php') ?>