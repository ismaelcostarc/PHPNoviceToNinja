<?php

namespace Ninja;

interface Routes
{
    public function __construct();
    //public function __contruct() {
        //Includes para conexões com o banco de dados e constantes para a conexão

        //Conexão com o Banco de Dados

        //Objetos da classe DatabaseTable representando as tabelas
    //}

    //Retorna um array multidimensional com todas as rotas da aplicação
    public function getRoutes(): array;

    //public funtion getRoutes {
        //Objetos Controllers

        //Array multimensional contendo as Rotas

        //return $routes;
    //}

    public function getAuthentication(): Authentication;
    //public function getAuthentication() {
        //retorna o objeto Authentication
    //}

}
