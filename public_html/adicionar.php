<?php

//Se existir uma requisição POST será executado uma inserção no banco de dados, caso não
//haja, será exibido o formulário para inserir um novo recurso
if (isset($_POST['recurso'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=recursoslivresdb;charset=utf8', 'recursoslivresuser', 'recursoslivrespassword');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'INSERT INTO `recursos` SET
            `titulo` = :titulo,
            `descricao` = :descricao,
            `link` = :link,
            `data` = CURDATE(),
            `autor_id` = 1;';

        //Procedimento para evitar o SQL Injection
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':titulo', $_POST['recurso']['titulo']);
        $stmt->bindValue(':descricao', $_POST['recurso']['descricao']);
        $stmt->bindValue(':link', $_POST['recurso']['link']);

        $stmt->execute();

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
