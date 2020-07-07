<?php

include __DIR__ . '/../includes/Project/Functions.php';
include __DIR__ . '/../includes/Project/Constants.php';
include_once __DIR__ . '/../includes/Ninja/DatabaseFunctions.php';

//Se existir uma requisição POST será executado uma inserção no banco de dados, caso não
//haja, será exibido o formulário para inserir um novo recurso
if (isset($_POST['recurso'])) {
    try {
        $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

        $colunas = ['titulo', 'descricao', 'link', 'data', 'autor_id'];

        $valores = [
            $_POST['recurso']['titulo'],
            $_POST['recurso']['descricao'],
            $_POST['recurso']['link'],
            '20-06-01',
            1
        ];

        create($pdo, DBTABLES[0], $colunas, $valores);

        header('Content-Type: text/html; charset=utf-8');
        header('Location: /lista.php');
    } catch (PDOException $e) {
        $title = 'Um erro ocorreu.';
        $titleIcon = 'warning';
        $output = 'Database error: ' . $e->getMessage() .
            'in ' . $e->getFile() .
            ':' . $e->getLine();
    }
} else {
    //Variáveis que serão utilizadas nos templates
    $title = 'Adicionar Novo';
    $itemMenuAtivo = 'adicionar';
    $titleIcon = 'add';

    //Leitura do buffer
    ob_start();
    include __DIR__ . '/../templates/adicionar.html.php';
    $output = ob_get_clean();
}

header('Content-Type: text/html; charset=utf-8');
include __DIR__ . '/../templates/layout.html.php';
