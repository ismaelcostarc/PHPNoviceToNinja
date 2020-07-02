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
    //É preciso inicializar a variável $recursos como um array vazio para o caso de
    //não existir nenhum recurso armazenado no banco de dados
    $recursos = [];
    
    //fetch() retorna sempre a próxima linha da tabela como um array
    //quando chegar ao final retorna false
    while($row = $result->fetch()) {
        $recursos[] = [
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'descricao' => $row['descricao'],
            'link' => $row['link'],
            'data' => $row['data']
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