<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jean Forteroche - le blog</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <link rel="icon" href="<?=$this->basePath?>Public/img/ticket_favicon.ico">
        
    <!--Polices-->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap" rel="stylesheet"> 
    
    <!-- Mon Style -->
    <link href="<?=$this->basePath?>Public/myStyles.css" rel="stylesheet" />
    
    <script 
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector:'textarea.tinymce',
            style_formats: [ // Initialisation du tinyMCE sans h1
            {title: 'Heading 2', format: 'h2'},
            {title: 'Heading 3', format: 'h3'},
            {title: 'Heading 4', format: 'h4'},
            {title: 'Heading 5', format: 'h5'},
            {title: 'Heading 6', format: 'h6'},
            {title: 'Normal', block: 'p'},
        ]    
        });
        
    </script>
    
    <script src="https://kit.fontawesome.com/f35eb86e13.js" crossorigin="anonymous"></script>


</head>

<body class="<?=$pageClass?>">
    <!-- Navigation -->
    <?php require('menuInclude.php'); ?>
    <header>
        <h1 class="text-center"><?= $titleVue ?></h1>
    </header>
    <hr class="sub_header"/> 

    
    <!-- *********Gestion du message flash ***********-->        
    <?php if(isset($_SESSION['message_flash']) && isset($_SESSION['message_flash']['seen']) && $_SESSION['message_flash']['seen'] === true){
        unset($_SESSION['message_flash']);
    }elseif(isset($_SESSION['message_flash'])){ ?>
        <div class="alert <?= $_SESSION['message_flash']['type']; ?> alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $_SESSION['message_flash']['message']; ?>
        </div> 
        <?php if($_SESSION['message_flash']['redirect'] === false){
                unset($_SESSION['message_flash']);
            }else{
                $_SESSION['message_flash']['seen'] = true;
            }
        ?>    
    <?php }?>
    
    <!-- Page Content -->
    <main class="col-lg-12">
        <?= $content ?>
    </main>
    
    <footer>
        <div class="nwl_copyright">Copyright © 2020 Jean Forteroche</div>
        <div class="nwl_link_footer">
            <div>
                <p>blog</p>
                <ul>
                    <li class="active">
                        <a href="<?=$this->basePath?>home">Accueil
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li>
                         <a href="<?=$this->basePath?>posts">Articles</a>
                    </li>
                </ul>
            </div>
            <div>
                <p>administration</p>
                <ul>
                    <?php if($this->isAdmin===false):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>connexion">Connexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>postEdition">Edition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>deconnexion">Déconnexion</a>
                    </li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.slim.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script>
        $('.alert').alert()
    </script>

</body>

</html>