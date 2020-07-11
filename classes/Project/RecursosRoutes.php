<?php

namespace Project;

class RecursosRoutes
{
    public function callAction($route)
    {
        include_once __DIR__ . '/../../includes/Ninja/DatabaseConnection.php';
        include_once __DIR__ . '/../../includes/Project/ProjectConstants.php';

        //Conexão com o Banco de Dados
        $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

        $recursosTabela = new \Ninja\DatabaseTable($pdo, DBTABLES[0], 'id');
        $autoresTabela = new \Ninja\DatabaseTable($pdo, DBTABLES[1], 'id');

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
            $autoresController = new AutoresController($autoresTabela);
            $page = $autoresController->adicionar();
        }

        return $page;
    }
}
