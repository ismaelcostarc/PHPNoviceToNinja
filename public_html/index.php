<?php

//Variáveis que serão utilizadas nos templates
$title = 'Início';
$itemMenuAtivo = 'inicio';
$titleIcon = 'home';

//Ínicio da da leitura do buffer
ob_start();
include __DIR__ . '/../templates/inicio.html.php';
$output = ob_get_clean();

header('Content-Type: text/html; charset=utf-8');
include __DIR__ . '/../templates/layout.html.php';