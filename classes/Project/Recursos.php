<?php

namespace Project;

class Recursos
{
    private $recursosTabela;
    private $autoresTabela;
    private $authentication;

    public function __construct(
        \Ninja\DatabaseTable $recursosTabela,
        \Ninja\DatabaseTable $autoresTabela,
        \Ninja\Authentication $authentication
    ) {
        $this->recursosTabela = $recursosTabela;
        $this->autoresTabela = $autoresTabela;
        $this->authentication = $authentication;
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
            'sizeSection' => 'is-medium'
        ];
    }

    public function lista()
    {
        $numeroRecursos = $this->recursosTabela->quantity();

        include_once __DIR__ . '/../../includes/Project/ProjectFunctions.php';
        
        $recursos = listarTodosRecursos($this->recursosTabela, $this->autoresTabela);
        
        $autor = $this->authentication->getUser();

        return [
            'title' => 'Lista',
            'template' => 'lista',
            'isActive' => 'lista',
            'titleIcon' => 'list',
            'variables' => [
                'numeroRecursos' => $numeroRecursos,
                'recursos' => $recursos,
                'usuarioLogado' => $autor['id'] ?? null
            ]
        ];
    }

    //A action salvar é chamada quando o verbo HTTP for POST
    public function salvar()
    {
        $recurso = $_POST['recurso'];
        $notifications = [];

        //Validações do lado do servidor
        //Verifica se o link já existe no banco de dados
        if ($this->recursosTabela->read('link', $recurso['link'])) {
            $notifications[] = 'linkExistente';
        }

        //Para validar campos vazios é mais seguro utilizar empty($campo)
        //invés de $campo == ''
        //Pois usuários maliciosos poderão tentar enviar requisições POST sem preencher o campo
        //o que faria com que a variável não exista. Utilizando $campo == '' estamos verificando
        //apenas se a variável possui uma string vazia. Com empty($campo) verificamos se a variável
        //existe de fato
        if (empty($recurso['titulo'])) {
            $notifications[] = 'tituloVazio';
        }
        if (empty($recurso['link'])) {
            $notifications[] = 'linkVazio';
        }
        if (empty($recurso['descricao'])) {
            $notifications[] = 'descricaoVazio';
        }

        //Caso todos os dados estejam corretos já é possível inserir o recurso
        if ($notifications == []) {
            //Será inserida uma nova data apenas se for para adicionar um recurso novo,
            //caso seja para atualizar será mantida a Data original
            if ($recurso['data'] == '') {
                //Configura o fuso horário a ser inserida no banco de dados.
                //O padrão é UTC
                $timeZone = new \DateTimeZone('America/Sao_Paulo');
                $dateTime = new \DateTime();
                $dateTime->setTimezone($timeZone);
                $recurso['data'] = $dateTime;
            }

            //O usuário logado constará como autor do recurso
            //O script irá verificar o email do usuário logado,
            //buscar o autor na tabela de autores do banco de dados,
            //e inserir o id do autor no novo recurso.
            $autor = $this->authentication->getUser();
            $recurso['autor_id'] = $autor['id'] ?? '';

            $this->recursosTabela->save($recurso);

            header('Content-Type: text/html; charset=utf-8');
            header('Location: /recursos/lista');
        }

        //Para verificar se a ação executada era de editar ou adicionar é só verificar se
        //havia uma data já existente. Se já existe a variável $recurso['data'] logo estava sendo editado
        //um recurso. Caso seja uma string vazia, estava sendo adicionado. Logo sabemos quais variáveis
        //utilizar para os templates
        if ($recurso['data'] == '') {
            $title = 'Adicionar um Novo Material';
            $isActive = 'adicionar';
            $titleIcon = 'add';
            $valorReset = 'Apagar';
        } else {
            //Variáveis que serão utilizadas nos templates
            $title = 'Editar';
            $isActive = '';
            $titleIcon = 'edit';
            $valorReset = 'Desfazer alterações';
        }

        return [
            'title' => $title,
            'template' => 'editar',
            'isActive' => $isActive,
            'titleIcon' => $titleIcon,
            'variables' => [
                'valorReset' => $valorReset,
                'recurso' => $recurso,
                'notifications' => $notifications
            ]
        ];
    }

    //A action editar é chamada quando o verbo HTTP for GET
    public function editar()
    {
        //Caso seja para editar um material existente, será repassado o valor do id na query string
        if (isset($_GET['id'])) {
            //Variáveis que serão utilizadas nos templates
            $title = 'Editar';
            $isActive = '';
            $titleIcon = 'edit';
            $valorReset = 'Desfazer alterações';

            $recurso = $this->recursosTabela->read('id', $_GET['id']);
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

    function apagar()
    {
        $this->recursosTabela->deleteById($_POST['recursoId']);

        //O usuário é redirecionado para a lista de materiais
        header('Content-Type: text/html; charset=utf-8');
        header('Location: /recursos/lista');
    }
}
