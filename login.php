<?php

// Ativar a visuaçização dos erros php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar a sessao
session_start();


// Parâmetros da ligação à base de dados MySQL
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "aluno123";
$db = "clientes";


// se não foi enviado o parametro senha, ou a sessão não tem o email, volta para a página de login
if ( empty($_POST['senha']) || empty($_SESSION['email']) ) {
  header('Location: index.html');
  die();
}


// Ligar à base de dados
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db)
	or die("Ligacao a base de dados falhou: %s\n". $conn -> error);


// Extrair a senha dos parâmetros que foram enviados para o script

$senha = mysqli_real_escape_string($conn, $_POST['senha']);

// Extrair o email da sessão
$email = $_SESSION['email'];

$senha = htmlspecialchars($senha,ENT_QUOTES,'UTF-8');
$email = htmlspecialchars($email,ENT_QUOTES,'UTF-8');

// Construir a query
$stmt = $conn->prepare('SELECT senha FROM clientes.utilizadores WHERE email= ? ;');
$stmt->bind_param('s', $email);

$stmt->execute();

$result = $stmt->get_result();

// obtem a hash da senha do utilizador
if ($result->num_rows == 0) {
  $conn -> close();
  header('Location: index.html');
  die();  
}

$row = $result->fetch_assoc();
$senhaBd = $row['senha'];
$senhaHash = hash('sha256', $senha);

// Se a senha do utilizador não está correta, volta para a página de login
if ($senhaBd != $senhaHash) {
  $conn -> close();
  echo "Senha incorreta" . $senhaBd . " " . $senhaHash;
  //header('Location: index.html');
  die();  
}

$conn -> close();

// Está logado
$_SESSION['logado'] = true;

// Transferir o utilizador para a página de transferências bancárias
header('Location: transferir.php');
die();

?>
