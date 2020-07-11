<?php

//Retorna todos os materiais de estudos
function listarTodosRecursos(DatabaseTable $recursosTabela, DatabaseTable $autoresTabela)
{
    //É preciso inicializar a variável $recursos como um array vazio para o caso de
    //não existir nenhum recurso armazenado no banco de dados
    $recursos = [];

    //$resultadoBD contém o array com todas as linhas da tabela de recursos
    $resultadoBD = $recursosTabela->readAll();

    foreach ($resultadoBD as $row) {
        //Encontrar o nome do autor
        $nomeAutor = $autoresTabela->readById($row['autor_id'])['nome'];

        //Transformar a data vinda do banco de dados em um objeto DateTime
        $data = new DateTime($row['data']);

        $recursos[] = [
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'descricao' => $row['descricao'],
            'link' => $row['link'],
            'data' => $data->format('d/m/Y'),   //Formato da data a ser enviada para o HTML
            'autorId' => $nomeAutor
        ];
    }

    return $recursos;
}
