<?php

class RecursosController
{
    private $recursosTabela;
    private $autoresTabela;

    public function __construct(DatabaseTable $recursosTabela, DatabaseTable $autoresTabela)
    {
        $this->recursosTabela = $recursosTabela;
        $this->autoresTabela = $autoresTabela;
    }

    //Cada ação do controlador retornará o título de cada página,
    //o nome do template a ser utilizado,
    //qual elemento do navbar ficará em destaque,
    //o nome do ícone que ficará na aba do navegador,
    //e um array com as variáveis a serem utilizadas no template
    public function inicio()
    {
        return [
            'title' => 'Início',
            'template' => 'inicio',
            'isActive' => 'inicio',
            'titleIcon' => 'home',
        ];
    }

    public function lista()
    {
        $numeroRecursos = $this->recursosTabela->quantity();

        $recursos = listarTodosRecursos($this->recursosTabela, $this->autoresTabela);

        return [
            'title' => 'Lista',
            'template' => 'lista',
            'isActive' => 'lista',
            'titleIcon' => 'list',
            'variables' => [
                'numeroRecursos' => $numeroRecursos,
                'recursos' => $recursos
            ]
        ];
    }

    public function editar()
    {
        //Se existir uma requisição POST será executado um update no banco de dados, caso não
        //haja, será exibido o formulário para editar o recurso
        if (isset($_POST['recurso'])) {
            $recurso = $_POST['recurso'];
            //Será inserida uma nova data apenas se for para adicionar um recurso novo,
            //caso seja para atualizar será mantida a Data original
            if ($recurso['data'] == '') {
                $recurso['data'] = new DateTime();
            }
            $recurso['autor_id'] = 1;

            $this->recursosTabela->save($recurso);

            header('Content-Type: text/html; charset=utf-8');
            header('Location: ?action=lista');
        } else {
            //Caso seja para editar um material existente, será repassado o valor do id na query string
            if (isset($_GET['id'])) {
                //Variáveis que serão utilizadas nos templates
                $title = 'Editar';
                $isActive = '';
                $titleIcon = 'edit';
                $valorReset = 'Desfazer alterações';

                $recurso = $this->recursosTabela->readById($_GET['id']);
            } else {
                //Variáveis que serão utilizadas nos templates
                $title = 'Adicionar um Novo Material';
                $isActive = 'adicionar';
                $titleIcon = 'add';
                $valorReset = 'Apagar';
            }

            return [
                'title' => $title,
                'template' => 'editar',
                'isActive' => $isActive,
                'titleIcon' => $titleIcon,
                'variables' => [
                    'valorReset' => $valorReset,
                    'recurso' => $recurso ?? ''
                ]
            ];
        }
    }

    function apagar()
    {
        $this->recursosTabela->deleteById($_POST['recursoId']);

        //O usuário é redirecionado para a lista de materiais
        header('Content-Type: text/html; charset=utf-8');
        header('Location: ?action=lista');
    }
}
