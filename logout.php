<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar a sessao
session_start();

// Apagar as variáveis de sessão
unset($_SESSION);

// Destruir a sessão
session_destroy();

// Voltar para a página inicial
header('Location: index.html');
die();


?>

