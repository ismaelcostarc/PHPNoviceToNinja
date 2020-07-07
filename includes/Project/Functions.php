<?php

include __DIR__ . '/../Ninja/DatabaseFunctions.php';

//Procedimento para evitar o Ataque XSS
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF_8');
}

//Retorna todos os materiais de estudos
function listarTodosRecursos($pdo) {
    //É preciso inicializar a variável $recursos como um array vazio para o caso de
    //não existir nenhum recurso armazenado no banco de dados
    $recursos = [];

    //$resultadoBD contém o array com todas as linhas da tabela de recursos
    $resultadoBD = readAll($pdo, DBTABLES[0]);

    foreach($resultadoBD as $row) {
        //Encontrar o nome do autor
        $nomeAutor = readById($pdo, DBTABLES[1], 'id', $row['autor_id'])['nome'];

        $recursos[] = [
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'descricao' => $row['descricao'],
            'link' => $row['link'],
            'data' => $row['data'],
            'autorId' => $nomeAutor
        ];
    }

    return $recursos;
}