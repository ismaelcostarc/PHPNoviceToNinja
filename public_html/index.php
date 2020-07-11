<?php

include_once __DIR__ . '/../includes/Project/ProjectFunctions.php';
include_once __DIR__ . '/../includes/Project/ProjectConstants.php';
include_once __DIR__ . '/../includes/Ninja/DatabaseConnection.php';
include_once __DIR__ . '/../includes/Ninja/NinjaFunctions.php';
include_once __DIR__ . '/../classes/Ninja/DatabaseTable.php';

//ENTRY POINT ou FRONT CONTROLLER
try {
    //Conexão com o Banco de Dados
    $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

    $recursosTabela = new DatabaseTable($pdo, DBTABLES[0], 'id');
    $autoresTabela = new DatabaseTable($pdo, DBTABLES[1], 'id');

    //Se a rota não for especificada, a rota escolhida será o início
    $route = $_GET['route'] ?? 'recursos/inicio';

    //Verifica se a rota especificada pela URL está em minúsculo,
    //caso não esteja será feito um redirecionamento para a mesma URL,
    //porém toda minúscula
    if ($route == strtolower($route)) {

        //--------------INJEÇÃO     DE      DEPENDÊNCIAS--------------------
        if ($route === 'recursos/lista') {
            include_once __DIR__ . '/../classes/Project/RecursosController.php';
            $recursosController = new RecursosController($recursosTabela, $autoresTabela);
            $page = $recursosController->lista();
        } elseif ($route === 'recursos/editar') {
            include_once __DIR__ . '/../classes/Project/RecursosController.php';
            $recursosController = new RecursosController($recursosTabela, $autoresTabela);
            $page = $recursosController->editar();
        }
        elseif ($route === 'recursos/apagar') {
            include_once __DIR__ . '/../classes/Project/RecursosController.php';
            $recursosController = new RecursosController($recursosTabela, $autoresTabela);
            $page = $recursosController->apagar();
        }
        elseif ($route === 'recursos/inicio') {
            include_once __DIR__ . '/../classes/Project/RecursosController.php';
            $recursosController = new RecursosController($recursosTabela, $autoresTabela);
            $page = $recursosController->inicio();
        }
        elseif ($route === 'autores/adicionar') {
            include_once __DIR__ . '/../classes/Project/AutoresController.php';
            $autoresController = new RecursosController($autoresTabela);
            $page = $autoresController->adicionar();
        }

    } else {
        //Define o código de resposta HTTP como 301 Moved Permanently,
        //por motivos de SEO
        http_response_code(301);
        //Realiza o redirecionamento para a URL minúscula
        header('location: /' . $route);
    }

    //Transforma cada elemento do array associativo em uma variável separada
    extract($page);

    //Não é adequado extrair o array de Variáveis de Templates no mesmo escopo
    //dos elementos já extraídos, pois podem ter o mesmo nome.
    //Para isso existe a função loadTemplates(), que realizará o processo de extrair
    //as variáveis e processar o template em um escopo separado.
    if (isset($variables)) {
        $output = loadTemplates($template, $variables);
    } else {
        $output = loadTemplates($template);
    }
} catch (PDOException $e) {
    $page['title'] = 'Um erro ocorreu.';
    $page['titleIcon'] = 'warning';
    $page['output'] = 'Database error: ' . $e->getMessage() .
        'in ' . $e->getFile() .
        ':' . $e->getLine();
}

header('Content-Type: text/html; charset=utf-8');
include __DIR__ . '/../templates/layout.html.php';
