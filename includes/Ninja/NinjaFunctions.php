<?php

//Procedimento para evitar o Ataque XSS
function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}