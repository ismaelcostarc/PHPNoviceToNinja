<?php

namespace Ninja;

class EntryPoint
{
    //String contendo a rota vinda da URL
    private $route;
    //Verbo HTTP
    private $method;
    //Objeto que contém o método que decide a ação e o controlador
    //de acordo com a rota especificada
    private $routes;

    public function __construct($route, $method, Routes $routes)
    {
        $this->route = $route;
        $this->method = $method;
        $this->routes = $routes;
        $this->checkUrl();
    }

    //Não é adequado extrair o array de Variáveis de Templates no mesmo escopo
    //dos elementos já extraídos, pois podem ter o mesmo nome.
    //Para isso existe a função loadTemplates(), que realizará o processo de extrair
    //as variáveis e processar o template em um escopo separado.
    private function loadTemplates($template, $variables = [])
    {
        extract($variables);

        //Include a função h() para ser utilizada nos templates
        include_once __DIR__ . '/../../includes/Ninja/NinjaFunctions.php';

        //Leitura do buffer
        //inclusão do conteúdo do template
        ob_start();

        include __DIR__ . '/../../templates/' . $template . '.html.php';

        return ob_get_clean();
    }

    private function checkUrl()
    {
        //Verifica se a rota especificada pela URL está em minúsculo,
        //caso não esteja será feito um redirecionamento para a mesma URL,
        //porém toda minúscula
        if ($this->route == strtolower($this->route)) {
        } else {
            //Define o código de resposta HTTP como 301 Moved Permanently,
            //por motivos de SEO
            http_response_code(301);
            header('Content-Type: text/html; charset=utf-8');
            //Realiza o redirecionamento para a URL minúscula
            header('location: /' . $this->route);
        }
    }

    //Contém todas as outras ações para escolher o Controller e a Action
    //$directoryLayout contém o caminho absoluto para o template de layout
    public function run($directoryLayout, $loginErrorRoute)
    {
        //executa a Action do Controlador correto e retorna as variáveis de template
        $routes = $this->routes->getRoutes();
        $authentication = $this->routes->getAuthentication();
        
        $isLoggedIn = $authentication->isLoggedIn();
        
        //Se a action do controller necessitar que o usuário esteja logado,
        //é exibida uma página de erro
        if (
            isset($routes[$this->route]['login']) &&
            !$isLoggedIn
        ) {
            header('Content-Type: text/html; charset=utf-8');
            //$loginErrorRoute contém a rota da página de erro de login
            header('Location: ' . $loginErrorRoute);
            //É preciso que mesmo que haja um redirecionamento, jamais a action do controller
            //seja chamada, por isso deve-se utilizar o else
        } else {
            //Caso o usuário esteja logado a página é exibida normalmente
            //Com o botão de Sair
            //Caso ele não esteja logado será exibido os botões de cadastrar e entrar

            //Com a rota e o método enviados pelo index.php podemos descobrir o
            //controller e a action no array multidimensional $routes
            $controller = $routes[$this->route][$this->method]['controller'];
            $action = $routes[$this->route][$this->method]['action'];

            $page = $controller->$action();

            //Transforma cada elemento do array associativo em uma variável separada
            extract($page);

            //Não é adequado extrair o array de Variáveis de Templates no mesmo escopo
            //dos elementos já extraídos, pois podem ter o mesmo nome.
            //Para isso existe a função loadTemplates(), que realizará o processo de extrair
            //as variáveis e processar o template em um escopo separado.
            if (isset($variables)) {
                $output = $this->loadTemplates($template, $variables);
            } else {
                $output = $this->loadTemplates($template);
            }

            header('Content-Type: text/html; charset=utf-8');
            include $directoryLayout;
        }
    }
}
