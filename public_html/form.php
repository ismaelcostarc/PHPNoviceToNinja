

<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
<?php

$nome = $_GET['nome'];
echo 'Olá ' . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');

?>
    </body>
</html>
