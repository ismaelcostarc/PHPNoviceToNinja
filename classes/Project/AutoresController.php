<?php

namespace Project;

class AutoresController
{
    private $autoresTabela;

    public function __construct(\Ninja\DatabaseTable $autoresTabela)
    {
        $this->autoresTabela = $autoresTabela;
    }

    public function formularioRegistro()
    {
        return [
            'title' => 'Registro',
            'template' => 'registro',
            'isActive' => 'registro',
            'titleIcon' => 'login'
        ];
    }

    public function sucessoRegistro()
    {
        return [
            'title' => 'Registro feito com sucesso',
            'template' => 'sucesso',
            'isActive' => '',
            'titleIcon' => 'success'
        ];
    }

    public function registrarUsuario()
    {
        $autor = $_POST['autor'];
        $notifications = [];

        //Validação do lado do servidor
        //Verifica se o email já existe no banco de dados
        if ($this->autoresTabela->read('email', '\'' . $autor['email'] . '\'')) {
            $notifications[] = 'emailExistente';
        }
        //Verifica se o email está no formato correto
        if (filter_var('\'' . $autor['email'] . '\'', FILTER_VALIDATE_EMAIL)) {
            $notifications[] = 'emailFormatoIncorreto';
        }
        //Para validar campos vazios é mais seguro utilizar empty($campo)
        //invés de $campo == ''
        //Pois usuários maliciosos poderão tentar enviar requisições POST sem preencher o campo
        //o que faria com que a variável não exista. Utilizando $campo == '' estamos verificando
        //apenas se a variável possui uma string vazia. Com empty($campo) verificamos se a variável
        //existe de fato
        if (empty($autor['email'])) {
            $notifications[] = 'emailVazio';
        }
        if (empty($autor['nome'])) {
            $notifications[] = 'nomeVazio';
        }
        if (empty($autor['senha'])) {
            $notifications[] = 'senhaVazia';
        }
        if (strlen($autor['senha']) < 8) {
            $notifications[] = 'senhaPequena';
        }
        if ($notifications == []) {
            $autor['senha'] = password_hash($autor['senha'], PASSWORD_DEFAULT);

            //Caso as entradas passem por todas as avaliações,
            //o autor é salvo no banco de dados
            //$this->autoresTabela->save($autor);
            
            header('Content-Type: text/html; charset=utf-8');
            header('Location: /autores/sucesso?usuario=' . $autor['nome']);
        }

        return [
            'title' => 'Registro',
            'template' => 'registro',
            'isActive' => 'registro',
            'titleIcon' => 'login',
            'variables' => [
                'nome' => $autor['nome'],
                'email' => $autor['email'],
                'notifications' => $notifications
            ]
        ];
    }
}
