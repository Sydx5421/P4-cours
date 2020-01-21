<?php
session_start();

use App\Library\Autoloader;
use App\Library\RouterPOO;
use App\Library\Route;
use App\Model\UserManager;

require 'Library\Autoloader.php';
require 'Library\fonctions.php';
App\Library\Autoloader::register();
 

$router = new RouterPOO();

// ------------------------- Route(URL, nomDuCOntroller, nomDeLaction)
$router->addRoute(new Route('/home', 'blog', 'home'));
$router->addRoute(new Route('/', 'blog', 'home'));
$router->addRoute(new Route('/posts', 'blog', 'posts'));
//$router->addRoute(new Route('/post', 'blog', 'onePost'));
$router->addRoute(new Route('/post/(\d+)', 'blog', 'onePost'));
$router->addRoute(new Route('/post/(\d+)/addComment', 'blog', 'addComment'));
$router->addRoute(new Route('/connection', 'blog', 'connection'));

//pages réserver à l'admin
//if(isset($_SESSION['adminConnected']) && $_SESSION['adminConnected'] === true ){
    $router->addRoute(new Route('/deconnection', 'blog', 'deconnection'));
    $router->addRoute(new Route('/postEdition', 'blog', 'postEdition'));    
//}


//$router->addRoute(new Route('/article/(\d+)', 'article', 'article'));

$router->run();
