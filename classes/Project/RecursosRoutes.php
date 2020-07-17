<?php

namespace Project;

class RecursosRoutes implements \Ninja\Routes
{
    private $recursosTabela;
    private $autoresTabela;
    private $authentication;

    public function __construct()
    {
        include_once __DIR__ . '/../../includes/Ninja/DatabaseConnection.php';
        include_once __DIR__ . '/../../includes/Project/ProjectConstants.php';

        //Conexão com o Banco de Dados
        $pdo = databaseConnection(DBNAME, DBUSER, DBPASSWORD);

        //--------------    TABELAS     -----------------------------
        $this->recursosTabela = new \Ninja\DatabaseTable($pdo, DBTABLES[0], 'id');
        $this->autoresTabela = new \Ninja\DatabaseTable($pdo, DBTABLES[1], 'id');

        //-------------- Objeto de Autenticação
        $this->authentication = new \Ninja\Authentication($this->autoresTabela, 'email', 'senha');
    }

    //Retorna um array multidimensional com todas as rotas da aplicação
    public function getRoutes(): array
    {
        //--------------    CONTROLLERS    -----------------------------
        $recursosController = new Recursos($this->recursosTabela, $this->autoresTabela, $this->authentication);
        $autoresController = new Autores($this->autoresTabela);
        $loginController = new Login($this->autoresTabela, $this->authentication);

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
                ],
                //login = true serve para indicar que essa action necessita de login
                'login' => 'true'
            ],
            'recursos/apagar' => [
                'POST' => [
                    'controller' => $recursosController,
                    'action' => 'apagar'
                ],
                //login = true serve para indicar que essa action necessita de login
                'login' => 'true'
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
            ],
            'login/erro' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'erro'
                ]
            ],
            'login/form' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'form'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            'login/sucesso' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'sucesso'
                ]
            ],
            'login/sair' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'sair'
                ]
            ]
        ];

        return $routes;
    }

    public function getAuthentication(): \Ninja\Authentication
    {
        //Retorna um objeto Authentication para o par email/senha
        return $this->authentication;
    }
}
