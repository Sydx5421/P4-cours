<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $titleVue ?> - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <!--<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!--<link href="./public/css/style_blog.css" rel="stylesheet" />--> 

    <!-- Mon Style -->
    <link href="<?=$this->basePath?>Public/myStyles.css" rel="stylesheet" />

</head>

<body>

    <!-- Navigation -->
    <?php require('menuView.php'); ?>
    
    <!--Gestion du messge flash-->
    <?php if(isset($_SESSION['message_flash'])){?>
    <div class="alert <?= $_SESSION['message_flash']['type']; ?>">
        <?= $_SESSION['message_flash']['message']; ?>
    </div>
    
    <?php
        unset($_SESSION['message_flash']);
    }?>
    
    
    <!-- Page Content -->
    <div class="col-lg-12 text-center">
        <h2><?= $titleVue ?></h2>
        <?= $content ?>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.slim.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>