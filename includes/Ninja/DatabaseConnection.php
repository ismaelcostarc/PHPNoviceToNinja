<?php
include_once __DIR__ . '/../Project/ProjectConstants.php';

//Realiza a conexão com o banco de dados local, se necessário mudar o banco de dados e o host
function databaseConnection($dbname, $user, $password) {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $pdo;
}