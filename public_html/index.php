<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    //Se a rota não for especificada, a rota escolhida será o início
    $route = $_GET['route'] ?? 'recursos/inicio';
    $directoryLayout = __DIR__ . '/../templates/layout.html.php';

    $entryPoint = new Ninja\EntryPoint($route, new Project\RecursosRoutes());
    $page = $entryPoint->run($directoryLayout);
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
