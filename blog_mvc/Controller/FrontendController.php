<?php
//namespace ??

class FrontendController{
    public function home(){
//        $model = new TestModel();
//        $data = $model->getHelloworld();
        $data = 'mes données'; //peut être utilisé directement car le require est fait au sein de  la méthode
        require 'view/home.php';   
        
    }
    public function test(){
        echo'Voici la page TEST';
    }
}
