<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=recursoslivresdb;charset=utf8', 'recursoslivresuser', 'recursoslivrespassword');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Variáveis que serão utilizadas nos templates
    $title = 'Lista';
    $itemMenuAtivo = 'lista';
    $titleIcon = 'list';

    $sql = 'SELECT * FROM `recursos`;';
    $result = $pdo->query($sql);
    
    //fetch() retorna sempre a próxima linha da tabela como um array
    //quando chegar ao final retorna false
    while($row = $result->fetch()) {
        $recursos[] = [
            'recursoId' => $row['id'],
            'recursoTexto' => $row['recursoTexto'],
            'recursoData' => $row['recursoData']
        ];
    }

    //Leitura do buffer
    ob_start();
    include __DIR__ . '/../templates/lista.html.php';
    $output = ob_get_clean();
}
catch(PDOException $e) {
    $title = 'Um erro ocorreu.';
    $titleIcon = 'warning';
    $output = 'Database error: ' . $e->getMessage() .
        'in ' .$e->getFile() .
        ':' . $e->getLine();
}

header('Content-Type: text/html; charset=utf-8');
include __DIR__ . '/../templates/layout.html.php';