<?php

include __DIR__ . '/../includes/Project/Functions.php';
include __DIR__ . '/../includes/Project/Constants.php';
include_once __DIR__ . '/../includes/Ninja/DatabaseFunctions.php';

try {
    $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

    deleteById($pdo, 'recursos', 'id', $_POST['recursoId']);

    //O usuário é redirecionado para a lista de materiais
    header('Content-Type: text/html; charset=utf-8');
    header('Location: /lista.php');
} catch (PDOException $e) {
    $title = 'Um erro ocorreu.';
    $titleIcon = 'warning';
    $output = 'Database error: ' . $e->getMessage() .
        'in ' . $e->getFile() .
        ':' . $e->getLine();
}
