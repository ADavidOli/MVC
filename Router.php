<?php
// archivo de configuracion router.

namespace MVC;

class Router{
    // cachamos las rutas get y post en un arreglo vacio.
    public $rutaGet = [];
    public $rutaPost =[];

    // definimos funciones callback de estas rutas.

    public function get($url, $fn){
        $this->rutasGet[$url] = $fn;
    }
    public function post($url, $fn){
        $this->rutasPost[$url] = $fn;
    }

    public function comprobarRutas(){
        // comprobacion de sesion con el helper creado en login
        session_start();
        // leemos la variable global de session.
        $auth = $_SESSION['login'] ?? null;
        // arreglo de rutas protegidas.
        // $rutasProtegidas = ['/admin', '/propiedades/crear', '/propiedaes/actualizar', '/propiedades/eliminar',
        // '/vendedores/actualizar', '/vendedores/crear','/vendedores/eliminar'];


        // de esta forma leemos lo que el usuario escribe en la url
        $urlActual = $_SERVER['PATH_INFO']?? '/';
        $urlActual = explode('?', $_SERVER['REQUEST_URI'])[0]; //limpiar los parametros
        $metodo = $_SERVER['REQUEST_METHOD'];
        // forma de validar metodos.
        if($metodo === 'GET'){
            // este codigo filtra la funcion, de acuerdo a cada ruta
            // si no existe una funcion la coloca como null
            $fn = $this->rutasGet[$urlActual] ?? null;
        }else{
            $fn = $this->rutasPost[$urlActual] ?? null;
        }
        // // checa si el valor existe en el arreglo 1
        // if(in_array($urlActual, $rutasProtegidas)&& !$auth){
        //     header('Location: /');
        // }
        // si es null, o en este caso, no existe, lo manda a pagina no encontrada
        if($fn){
            // funcion que permite llamar a una funcion de forma dinamica cuando no sabemos como llamar a esa funcion
            call_user_func($fn, $this);
        }else{
            header('Location: /');
        }
    }

    // mostrar una vista.
    public function render($view, $content = []){

        foreach ($content as $key => $value){
            // este foreach enlace el nombre de la variable con su valor, ya que no se conoce como tal el nombre del indice
            $$key = $value;
        }
        ob_start();//este codigo hace que la siguiente linea lo almacene el memoria
        include __DIR__ . "/Views/$view.php";
        $contenido = ob_get_clean(); //limpia la memmoria y almacena.
        // le inlcuimos nuestro layout
        include __DIR__ . "/Views/layout.php";
    }

}