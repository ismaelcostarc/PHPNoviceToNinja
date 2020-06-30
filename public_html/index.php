<?php
$title = 'Início';
$itemMenuAtivo = 'inicio';
$titleIcon = 'home';

ob_start();

include __DIR__ . '/../templates/inicio.html.php';

$output = ob_get_clean();

include __DIR__ . '/../templates/layout.html.php';