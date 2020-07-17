<?php

//Retorna todos os materiais de estudos
function listarTodosRecursos(\Ninja\DatabaseTable $recursosTabela, \Ninja\DatabaseTable $autoresTabela)
{
    //É preciso inicializar a variável $recursos como um array vazio para o caso de
    //não existir nenhum recurso armazenado no banco de dados
    $recursos = [];

    //$resultadoBD contém o array com todas as linhas da tabela de recursos
    $resultadoBD = $recursosTabela->readAll();

    foreach ($resultadoBD as $row) {
        //Encontrar o nome do autor
        $autor = $autoresTabela->read('id', $row['autor_id']);

        //Transformar a data vinda do banco de dados em um objeto DateTime
        $data = new DateTime($row['data']);

        $recursos[] = [
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'descricao' => $row['descricao'],
            'link' => $row['link'],
            'data' => $data->format('d/m/Y h:i'),   //Formato da data a ser enviada para o HTML
            'nomeAutor' => $autor['nome'] ?? '',
            'idAutor' => $autor['id'] ?? null
        ];
    }

    return $recursos;
}
