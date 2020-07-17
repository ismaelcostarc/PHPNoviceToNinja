<?php

namespace Ninja;

class Authentication
{
    private $usersTable;
    private $usernameColumn;
    private $passwordColumn;


    public function __construct(DatabaseTable $usersTable, $usernameColumn, $passwordColumn)
    {
        //Inicia uma sessão
        session_start();
        $this->usersTable = $usersTable;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }

    public function login($username, $password)
    {
        //Mesmo se o usuário digitar o usuário em maiúsculo, será convertido para minúscula
        //para pesquisa no banco de dados
        $user = $this->usersTable->read($this->usernameColumn, strtolower($username));
        if (!empty($user) && password_verify($password, $user[$this->passwordColumn])) {
            //Prevenção contra o ataque Session Fixation
            session_regenerate_id();
            $_SESSION['username'] = $username;
            //A senha armazenada na variável de sessão não será a senha digitada pelo usuário,
            //mas a senha hasheada armazenada no banco de dados
            $_SESSION['password'] = $user[$this->passwordColumn];
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedIn()
    {
        //Se não existir sequer uma variável de sessão username
        //já sabe-se que não há usuário logado
        if (empty($_SESSION['username'])) {
            return false;
        }

        //É preciso autenticar novamete o usuário e verificar se o usuário que está na variável
        //de sessão consta no banco de dados, e se a senha hasheada que consta na variável de se-
        //são é a mesma do banco de dados.
        //Sempre garantir que antes de realizar a busca no Bando de Dados, o username presente na
        //variável de sessão seja convertido para minúsculas
        $user = $this->usersTable->read($this->usernameColumn, strtolower($_SESSION['username']));
        
        if (!empty($user) && $_SESSION['password'] === $user[$this->passwordColumn]) {
            return true;
        } else {
            return false;
        }
    }

    //Devolve um array com os dados do usuário logado
    public function getUser()
    {
        if ($this->isLoggedIn()) {
            //Sempre garantir que antes de realizar a busca no Bando de Dados, o username presente na
            //variável de sessão seja convertido para minúsculas
            return $this->usersTable->read($this->usernameColumn, strtolower($_SESSION['username']));
        } else {
            return false;
        }
    }
}
