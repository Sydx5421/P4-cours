<?php
session_start();
// Affichage des erreurs à retirer
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
//-------------
use App\Library\Autoloader;
use App\Library\RouterPOO;
use App\Library\Route;

require 'Library\Autoloader.php';
require 'Library\fonctions.php';
App\Library\Autoloader::register();
$router = new RouterPOO();

// ------------------ Route(URL, nomDuCOntroller, nomDeLaction)

$router->addRoute(new Route('/home', 'blog', 'home'));
$router->addRoute(new Route('/', 'blog', 'home'));
$router->addRoute(new Route('/posts', 'blog', 'posts'));
$router->addRoute(new Route('/posts/(\d+)', 'blog', 'posts'));
$router->addRoute(new Route('/post/(\d+)', 'blog', 'onePost'));
$router->addRoute(new Route('/connexion', 'blog', 'connexion'));
$router->addRoute(new Route('/reportComment', 'blog', 'reportComment'));

//pages réserver à l'admin
$router->addRoute(new Route('/dashboard', 'admin', 'dashboard'));
$router->addRoute(new Route('/deconnexion', 'admin', 'deconnexion'));
$router->addRoute(new Route('/postEdition', 'admin', 'postEdition'));    
$router->addRoute(new Route('/postEdition/(\d+)', 'admin', 'postEdition'));    
$router->addRoute(new Route('/deletePost/(\d+)', 'admin', 'deletePost'));    
$router->addRoute(new Route('/adminActionComment', 'admin', 'adminActionComment'));   


$router->run();
