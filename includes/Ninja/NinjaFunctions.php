<?php

//Procedimento para evitar o Ataque XSS
function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF_8');
}

//Não é adequado extrair o array de Variáveis de Templates no mesmo escopo
//dos elementos já extraídos, pois podem ter o mesmo nome.
//Para isso existe a função loadTemplates(), que realizará o processo de extrair
//as variáveis e processar o template em um escopo separado.
function loadTemplates($template, $variables = [])
{
    extract($variables);

    //Leitura do buffer
    //inclusão do conteúdo do template
    ob_start();

    include __DIR__ . '/../../templates/' . $template . '.html.php';

    return ob_get_clean();
}
