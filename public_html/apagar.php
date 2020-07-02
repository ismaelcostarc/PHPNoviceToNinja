<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=recursoslivresdb;charset=utf8', 'recursoslivresuser', 'recursoslivrespassword');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Prevenção contra SQL Injection
    $sql = 'DELETE FROM `recursos` WHERE `id` = :recursoId;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':recursoId', $_POST['recursoId']);
    $stmt->execute();

    //O usuário é redirecionado para a lista de recursos
    header('Content-Type: text/html; charset=utf-8');
    header('Location: /lista.php');
} catch (PDOException $e) {
    $title = 'Um erro ocorreu.';
    $titleIcon = 'warning';
    $output = 'Database error: ' . $e->getMessage() .
        'in ' . $e->getFile() .
        ':' . $e->getLine();
}