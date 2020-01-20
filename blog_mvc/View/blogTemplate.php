<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $titleVue ?> - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="./public/css/style_blog.css" rel="stylesheet" />--> 
  
  <!-- Mon Style -->
  <link href="Public/myStyles.css" rel="stylesheet" />
  
</head>

<body>

    <!-- Navigation -->
        <?php include 'menuView.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Jean Forteroche - Billet simple pour l'Alaska</h1>
                <p class="lead">Chaque semaine découvrez un nouveau chapitre de mon nouveau roman en ligne !</p>
            </div>
        </div>
    </div>

    <div class="col-lg-12 text-center">
        <h2><?= $titleVue ?></h2>
        <?= $content ?>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.slim.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
