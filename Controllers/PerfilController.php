<?php 
namespace Controllers;
use MVC\Router;

class PerfilController{
    // definimos nuestras funciones de controller.
    public static function index(Router $Router){
        
        $Router->render('/perfil/index',[
            'titulo' => 'MVC',
        ]);
    }
}