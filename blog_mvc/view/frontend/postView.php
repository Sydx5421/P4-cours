<?php $title = "Mon Blog avec controller"; ?>
<?php ob_start(); ?>
    <div>
        <p><a href="index.php?action=listPosts">Retour au blog!!</a></p>
 
        <div class="news">
            <h3><?= htmlspecialchars($post['title']) ?>
                <em>le : <?= ($post['creation_date_fr'])?></em> 
            </h3>
            
            <p>
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </p>
        </div>           
        
        <h2>Commentaires</h2>
        <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
            <div>
                <label for="author">Auteur</label><br />
                <input type="text" id="author" name="author" />
            </div>
            <div>
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment"></textarea>
            </div>
            <div>
                <input type="submit" />
            </div>
        </form>
        <?php 
        while($comment = $comments->fetch(PDO::FETCH_ASSOC))
        {
        ?> 
        <div>
            <p><strong><?=htmlspecialchars($comment['author'])?></strong> le <?= htmlspecialchars($comment['comment_date_fr'])?> </p>
            <p><?= nl2br(htmlspecialchars($comment['comment']))?></p>
        </div>
        <?php
        }
        ?>
    </div>
<?php $content = ob_get_clean();?>
<?php require('template.php') ?>