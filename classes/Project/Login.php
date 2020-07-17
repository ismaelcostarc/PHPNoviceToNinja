<?php

namespace Project;

use Ninja\DatabaseTable;

class Login
{
    private $autoresTabela;
    private $authentication;

    public function __construct(\Ninja\DatabaseTable $autoresTabela, \Ninja\Authentication $authentication)
    {
        $this->autoresTabela = $autoresTabela;
        $this->authentication = $authentication;
    }

    public function form()
    {
        return [
            'title' => 'Login',
            'template' => 'login',
            'isActive' => '',
            'titleIcon' => 'login',
        ];
    }

    public function sair() {
        //Apenas redireciona para o início
        session_destroy();
        header('Content-Type: text/html; charset=utf-8');
        header('Location: /');
    }

    function erro()
    {
        return [
            'title' => 'Erro de Login',
            'template' => 'loginerro',
            'isActive' => '',
            'titleIcon' => 'warning',
            'sizeSection' => 'is-medium'
        ];
    }

    function sucesso()
    {
        return [
            'title' => 'Bem Vindo',
            'template' => 'sucessologin',
            'isActive' => '',
            'titleIcon' => 'success',
            'sizeSection' => 'is-medium'
        ];
    }

    public function processLogin()
    {
        //Validação de Dados
        $notifications = [];
        $autor = $_POST['autor'];

        if (empty($autor['email'])) {
            $notifications[] = 'emailVazio';
        }
        if (empty($autor['senha'])) {
            $notifications[] = 'senhaVazia';
        }

        if (
            isset($autor['email']) &&
            isset($autor['senha'])
        ) {
            if ($this->authentication->login($autor['email'], $autor['senha'])) {
                //A partir do email é possível descobrir o nome do usuário e exibi-lo
                $nome = $this->autoresTabela->read('email', $autor['email'])['nome'];

                header('Content-Type: text/html; charset=utf-8');
                header('Location: /login/sucesso?usuario=' . $nome);
            } else {
                $notifications[] = 'emailOuSenhaErrada';
            }
        }   

        return [
            'title' => 'Login',
            'template' => 'login',
            'isActive' => '',
            'titleIcon' => 'login',
            'variables' => [
                'email' => $autor['email'],
                'notifications' => $notifications
            ]
        ];
    }
}
