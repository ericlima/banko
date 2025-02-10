<?php

// Ativar a visuaçização dos erros php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar a sessao
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
      die("Erro: Requisição inválida (CSRF detectado).");
      header('Location: index.html');
  }
}

// Parâmetros da ligação à base de dados MySQL
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "aluno123";
$db = "clientes";


// se não está logado, volta para a página de login
if ( empty($_SESSION['logado']) || $_SESSION['logado'] != true) {
  header('Location: index.html');
  die();
}

// se faltar algum parãmetro, volta para a página de transferência
if ( empty($_POST['nome']) || empty($_POST['conta']) || empty($_POST['valor'])) {
  header('Location: transferir.php');
  die();
}

$nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
$conta = htmlspecialchars($_POST['conta'], ENT_QUOTES, 'UTF-8');
$valor = htmlspecialchars($_POST['valor'], ENT_QUOTES, 'UTF-8');

// Ligar à base de dados
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db)
	or die("Ligacao a base de dados falhou: %s\n". $conn -> error);


// Construir a query
$sqlQuery="INSERT INTO clientes.transferencias (nome_destinatario,numero_conta,valor_transferir) VALUES ('$nome','$conta',$valor);";
	
// Fazer a query
$result = $conn->query($sqlQuery);


$conn -> close();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css">
<title>Boas vindas</title>
</head>

<!-- esta DIV serve para fazer o logout (btao de logout no canto superior direito) -->
<div class='wrap'>
  <form action="logout.php" method="get">
    <button type="submit" id="logout" class="red_background">Logout</button>
  </form>     
</div>

<h1>Transferência agendada com sucesso</h1>
<h1><a href="transferir.php">Voltar</a></h1>



</body>
</html>
