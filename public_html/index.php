<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    //Se a rota não for especificada, a rota escolhida será o início
    $route = $_GET['route'] ?? 'recursos/inicio';
    $method = $_SERVER['REQUEST_METHOD'];
    $directoryLayout = __DIR__ . '/../templates/layout.html.php';
    
    $routes = new \Project\RecursosRoutes();
    $entryPoint = new \Ninja\EntryPoint($route, $method, $routes);

    $page = $entryPoint->run($directoryLayout, '/login/erro');
} catch (PDOException $e) {
    $title = 'Um erro ocorreu.';
    $titleIcon = 'warning';
    $output = 'Database error: ' . $e->getMessage() .
        'in ' . $e->getFile() .
        ':' . $e->getLine();

    //Mesmo se alguma exceção for lançada é adequado que o layout seja mostrado de forma normal
    header('Content-Type: text/html; charset=utf-8');
    include $directoryLayout;
}
