<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Blog - commentaires</title>
  <link rel="stylesheet" href="style_blog.css">
  <script src="script.js"></script>
  
</head>
<body>
    <h1>Mon super Blog !</h1>
    <div>
        <p>
            <a href="blog.php">Retour au blog</a>
        </p>
        <?php
            try
            {
                $db = new PDO('mysql:host=localhost;dbname=blog_cours;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch (Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
                       
            $reponseBillet = $db->prepare('SELECT * FROM billets WHERE id = ?');
            $reponseCommentaires = $db->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, "%d/%m/%Y à %Hh%imin%ss") AS date FROM commentaire WHERE id_billet = ?');

            
            if ($_GET['idBillet']!=null){
                $reponseBillet->execute(array(htmlspecialchars($_GET['idBillet'])));

                $dataB = $reponseBillet->fetch();
                if(!empty($dataB))
                {
        ?> 
                    <div class="news">
                        <h3><?php echo htmlspecialchars($dataB['titre']) . ' le : ' . htmlspecialchars($dataB['date_creation'])?></h3>
                        <p>
                            <?php echo htmlspecialchars($dataB['contenu'])?><br>
                        </p>
                    </div>           
        <?php
                }else{
        ?>     
                    <p>Erreur : Ce billet n'existe pas !</p>
        <?php    
                }            
                $reponseBillet->closeCursor(); // Termine le traitement de la requête    
                echo '<h2>Commentaires</h2>';
                $reponseCommentaires->execute(array(htmlspecialchars($_GET['idBillet'])));
                while($dataC = $reponseCommentaires->fetch())
                {
        ?> 
                    <div>
                        <p><strong><?php echo htmlspecialchars($dataC['auteur'])?></strong> le <?php echo htmlspecialchars($dataC['date'])?> </p>
                        <p><?php echo htmlspecialchars($dataC['commentaire'])?></p>
                    </div>
        <?php
                }
                $reponseCommentaires->closeCursor(); // Termine le traitement de la requête   
            }
        ?>
    </div>
    
</body>
</html>