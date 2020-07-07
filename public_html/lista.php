<?php

include __DIR__ . '/../includes/Project/Functions.php';
include __DIR__ . '/../includes/Project/Constants.php';
include_once __DIR__ . '/../includes/Ninja/DatabaseFunctions.php';

try {
    //Variáveis que serão utilizadas nos templates
    $title = 'Lista';
    $itemMenuAtivo = 'lista';
    $titleIcon = 'list';

    //Conexão com o Banco de Dados
    $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

    $numeroRecursos = quantity($pdo, DBTABLES[1]);

    $recursos = listarTodosRecursos($pdo);

    //Leitura do buffer
    ob_start();
    include __DIR__ . '/../templates/lista.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Um erro ocorreu.';
    $titleIcon = 'warning';
    $output = 'Database error: ' . $e->getMessage() .
        'in ' . $e->getFile() .
        ':' . $e->getLine();
}

header('Content-Type: text/html; charset=utf-8');
include __DIR__ . '/../templates/layout.html.php';
