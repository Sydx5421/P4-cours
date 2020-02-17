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
$router->addRoute(new Route('/connection', 'blog', 'connection'));
$router->addRoute(new Route('/reportComment', 'blog', 'reportComment'));

//pages réserver à l'admin
//if($this->isAdmin === true){
    $router->addRoute(new Route('/dashboard', 'admin', 'dashboard'));
    $router->addRoute(new Route('/deconnection', 'admin', 'deconnection'));
    $router->addRoute(new Route('/postEdition', 'admin', 'postEdition'));    
    $router->addRoute(new Route('/postEdition/(\d+)', 'admin', 'postEdition'));    
    $router->addRoute(new Route('/adminActionComment', 'admin', 'adminActionComment'));    
//    $router->addRoute(new Route('/commentAction', 'admin', 'commentAction'));    
//    $router->addRoute(new Route('/postEdition?post_id=(\d+)', 'blog', 'postEdition'));    
//}


//$router->addRoute(new Route('/article/(\d+)', 'article', 'article'));

$router->run();
