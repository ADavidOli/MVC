<?php
    require_once __DIR__ . '/../Includes/app.php';

    use MVC\Router;
    use Controllers\PerfilController;

    $Router = new Router();

    $Router->get('/',[PerfilController::class, 'index']);

    $Router->comprobarRutas();