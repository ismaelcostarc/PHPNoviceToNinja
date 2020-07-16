<?php

namespace Project;

class RecursosRoutes implements \Ninja\Routes
{
    //Retorna um array multidimensional com todas as rotas da aplicação
    public function getRoutes()
    {
        include_once __DIR__ . '/../../includes/Ninja/DatabaseConnection.php';
        include_once __DIR__ . '/../../includes/Project/ProjectConstants.php';

        //Conexão com o Banco de Dados
        $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

        //--------------    TABELAS     -----------------------------
        $recursosTabela = new \Ninja\DatabaseTable($pdo, DBTABLES[0], 'id');
        $autoresTabela = new \Ninja\DatabaseTable($pdo, DBTABLES[1], 'id');

        //--------------    CONTROLLERS    -----------------------------
        $recursosController = new RecursosController($recursosTabela, $autoresTabela);
        $autoresController = new AutoresController($autoresTabela);

        //--------------LISTA       DE      ROTAS---------------------------

        $routes = [
            'recursos/lista' => [
                'GET' => [
                    'controller' => $recursosController,
                    'action' => 'lista'
                ]
            ],
            'recursos/editar' => [
                'GET' => [
                    'controller' => $recursosController,
                    'action' => 'editar'
                ],
                'POST' => [
                    'controller' => $recursosController,
                    'action' => 'salvar'
                ]
            ],
            'recursos/apagar' => [
                'POST' => [
                    'controller' => $recursosController,
                    'action' => 'apagar'
                ]
            ],
            'recursos/inicio' => [
                'GET' => [
                    'controller' => $recursosController,
                    'action' => 'inicio'
                ]
            ],
            'autores/registrar' => [
                'GET' => [
                    'controller' => $autoresController,
                    'action' => 'formularioRegistro'
                ],
                'POST' => [
                    'controller' => $autoresController,
                    'action' => 'registrarUsuario'
                ]
            ],
            'autores/sucesso' => [
                'GET' => [
                    'controller' => $autoresController,
                    'action' => 'sucessoRegistro'
                ]
            ]
        ];

        return $routes;
    }
}
