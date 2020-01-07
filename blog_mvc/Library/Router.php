<?php
 


class Router 
{
    private $routes = [];// tableau contenant toutes les routes de la forme [url => 'controller:action']
    
    public function add($page, $controller_action)
    {//permet d'ajouter les routes vers les pages de nos sites
        $this->routes[$page] = $controller_action;
    }
    
    public function run()
    {
        if (!isset ($_GET['page']) || !isset($this->routes[$_GET['page']])) {
            $controller_action = 'frontend:home';
        } else {
            $page= $_GET['page'];//=home
            $controller_action = $this->routes[$page];
        }
        echo '<pre>';
        var_dump($controller_action);
        $controller_action = explode(":", $controller_action);
        echo '<pre>';
        var_dump($controller_action);
        $controller_name = ucfirst($controller_action[0]) . 'Controller';
        $action = $controller_action[1];
        var_dump($controller_name);
        $controller = new $controller_name();// permet d'instancié de manière dynamique un controller
         echo '<pre>';
        var_dump($controller);
        $controller->$action();
    }
}