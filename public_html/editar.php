<?php

include __DIR__ . '/../includes/Project/Functions.php';
include __DIR__ . '/../includes/Project/Constants.php';
include_once __DIR__ . '/../includes/Ninja/DatabaseFunctions.php';

try {
    //Ao contrário do script de adicionar, a edição necessita acessar o banco de dados
    //tanto se for exibir a página pela primeira vez quanto se for processar o envio do formulário
    $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

    //Se existir uma requisição POST será executado um update no banco de dados, caso não
    //haja, será exibido o formulário para editar o recurso
    if (isset($_POST['recurso'])) {
        $colunas = ['titulo', 'descricao', 'link', 'data', 'autor_id'];

        $valores = [
            $_POST['recurso']['titulo'],
            $_POST['recurso']['descricao'],
            $_POST['recurso']['link'],
            '20-06-01',
            1
        ];

        //O id do recurso a ser editado foi passado como em um input hidden no formulário
        updateById($pdo, DBTABLES[0], $colunas, $valores, 'id', $_POST['recurso']['id']);

        header('Content-Type: text/html; charset=utf-8');
        header('Location: /lista.php');
    } else {
        //Variáveis que serão utilizadas nos templates
        $title = 'Editar';
        //Quando $itemMenuAtivo for uma string vazia nenhum elemento da nav ficará em destaque
        $itemMenuAtivo = '';
        $titleIcon = 'edit';

        $recurso = readById($pdo, DBTABLES[0], 'id', $_GET['id']);
        //Leitura do buffer
        ob_start();
        include __DIR__ . '/../templates/editar.html.php';
        $output = ob_get_clean();
    }
} catch (PDOException $e) {
    $title = 'Um erro ocorreu.';
    $titleIcon = 'warning';
    $output = 'Database error: ' . $e->getMessage() .
        'in ' . $e->getFile() .
        ':' . $e->getLine();
}

header('Content-Type: text/html; charset=utf-8');
include __DIR__ . '/../templates/layout.html.php';
