
<?php $title = "Mon Blog avec controller"; ?>
<?php ob_start(); ?>
<h1>Mon super Blog bien controllé !</h1>

<div id="billetsDisplay">
    <?php
    while($data = $posts->fetch(PDO::FETCH_ASSOC))
    {
    ?>
    <div class="news">                
        <h3><?php echo htmlspecialchars($data['title']) . ' le : ' . htmlspecialchars($data['creation_date_fr'])?></h3>
        <p>
            <?php echo htmlspecialchars($data['content'])?><br>
            <!--<a href="post.php?id=<?php echo $data['id'] ?>">Commentaires</a>-->
            <a href="index.php?action=post&id=<?php echo $data['id'] ?>">Commentaires</a>
        </p>
    </div>
    <?php
    }
    $posts->closeCursor(); // Termine le traitement de la requête
    ?>
</div>
<?php $content = ob_get_clean();?>

<?php require('template.php') ?>

