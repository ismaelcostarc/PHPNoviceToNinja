<?php

//Realiza a conexão com o banco de dados local, se necessário mudar o banco de dados e o host
function databaseConnection($dbname, $user, $password) {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $pdo;
}

//A função query realiza o tratamento adequado para evitar o ataque SQL Injection,
//executa o sql e retorna a resposta do banco de dados
function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);

    foreach($parameters as $chave => $valor) {
        $query->bindValue($chave, $valor);
    }

    $query->execute();

    return $query;
}

//Retorna a quantidade de recursos na tabela
function quantity($pdo, $tabela) {
    $sql = "SELECT COUNT(*) FROM `$tabela`;";
    $numero = query($pdo, $sql)->fetch()[0];

    return $numero;
}

//--------------------------------------CRUD---------------------------------------------
//Create

function create($pdo, $table, $columns, $values) {
    $sql = "INSERT INTO `$table` (";
    //$parameters é um array associativo que informa qual será o valor de cada variável
    //no comando SQL
    $parameters = [];
    //$columns contém o nomes das colunas, $values contém os valores de cada coluna.
    //O foreach está percorrendo $columns, logo é utilizado um índice incrementado para percorrer
    //$values também
    $i = 0;

    foreach($columns as $column) {
        $sql .= "`$column`,";
    }

    //Após uma lista com os nomes das colunas sobra uma vírgula no final,
    //que deve ser retirada com rtrim()
    $sql = rtrim($sql, ',');

    $sql .= ') VALUES (';

    foreach($columns as $column) {
        $sql .= ':' . $column . ',';

        $parameters[':' . $column] = $values[$i++];
    }

    //Após uma lista com os nomes das variáveis sobra uma vírgula no final,
    //que deve ser retirada com rtrim()
    $sql = rtrim($sql, ',');

    $sql .= ');';

    //Após isso, o SQL gerado será, por exemplo:
    //INSERT INTO `alunos` (`nome`, `nota`) VALUES (:nome, :nota);
    //
    //Array $parameters:
    //[
    //  ':nome' => 'João da Silva',
    //  ':nota' => 9    
    //]

    //O comando SQL já pode ser executado com segurança
    query($pdo, $sql, $parameters);
}

//Read

//Retorna um array com todos os recursos da tabela
function readAll($pdo, $table) {
    $sql = "SELECT * FROM `$table`;";
    $result = query($pdo, $sql);

    return $result->fetchAll();
}

//Retorna um recurso específico por seu ID
//$primaryKey é o nome da coluna que contém a chave primária
//que pode ser 'id', 'cpf', 'matricula', etc
function readById($pdo, $table, $primaryKey, $id) {
    $sql = "SELECT * FROM `$table` WHERE `$primaryKey` = $id;";
    $result = query($pdo, $sql);

    return $result->fetch();
}

//Update

function updateById($pdo, $table, $columns, $values, $primaryKey, $id) {
    $sql = "UPDATE `$table` SET ";
    //$parameters é um array associativo que informa qual será o valor de cada variável
    //no comando SQL
    $parameters = [];
    //$columns contém o nomes das colunas, $values contém os valores de cada coluna.
    //O foreach está percorrendo $columns, logo é utilizado um índice incrementado para percorrer
    //$values também
    $i = 0;

    foreach($columns as $column) {
        $sql .= "`$column` = :$column,";

        $parameters[':' . $column] = $values[$i++];
    }

    //Após uma lista com os nomes das variáveis sobra uma vírgula no final,
    //que deve ser retirada com rtrim()
    $sql = rtrim($sql, ',');

    $sql .= " WHERE `$primaryKey` = $id;";

    /*
    echo $sql . '<hr>';
    var_dump($parameters);
    exit();
    */

    //Após isso, o SQL gerado será, por exemplo:
    //UPDATE `alunos` SET `nome` = :nome, `nota` = :nota WHERE `matricula` = 345;
    //
    //Array $parameters:
    //[
    //  ':nome' => 'João da Silva',
    //  ':nota' => 7    
    //]

    //O comando SQL já pode ser executado com segurança

    query($pdo, $sql, $parameters);
}

//Delete

//Apaga um recurso específico por seu ID
//$primaryKey é o nome da coluna que contém a chave primária
//que pode ser 'id', 'cpf', 'matricula', etc
function deleteById($pdo, $table, $primaryKey, $id) {
    $sql = "DELETE FROM `$table` WHERE `$primaryKey` = $id";
    query($pdo, $sql);
}