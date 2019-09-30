<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Blog</title>
  <link rel="stylesheet" href="style_blog.css">
  <script src="script.js"></script>
  
</head>
<body>
    <h1>Mon super Blog !</h1>
        
    <div id="billetsDisplay">
        <?php
           
            while($data = $posts->fetch())
            {
        ?>
            <div class="news">
                <h3><?php echo htmlspecialchars($data['titre']) . ' le : ' . htmlspecialchars($data['date_creation'])?></h3>
                <p>
                    <?php echo htmlspecialchars($data['contenu'])?><br>
                    <a href="commentaires_blog.php?idBillet=<?php echo $data['id'] ?>">Commentaires</a>
                </p>
            </div>
        <?php
            }
            $posts->closeCursor(); // Termine le traitement de la requête
        ?>
    </div>
    
</body>
</html>
