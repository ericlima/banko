<?php

// Ativar a visuaçização dos erros php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// se não foi enviado o parametro email, volta para a página de login
if ( empty($_GET['email'] ) ) {
  header('Location: index.html');
  die();
}

// Parâmetros da ligação à base de dados MySQL
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "aluno123";
$db = "clientes";


// Ligar à base de dados
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db)
	or die("Ligacao a base de dados falhou: %s\n". $conn -> error);


// Extrair o email dos parâmetros que foram enviados para o script
$email = $_GET['email'];

$stmt = $conn->prepare('SELECT * FROM clientes.utilizadores WHERE email= ? ;');
$stmt->bind_param('s', $email);

$stmt->execute();

// Construir a query
//$sqlQuery="SELECT * FROM clientes.utilizadores WHERE email='$email';";
	
// Fazer a query
//$result = $conn->query($sqlQuery);
$result = $stmt->get_result();

// Se não há nenhum utilizador com aquele email, volta para a página de login
if ($result->num_rows == 0) {
  $conn -> close();
  header('Location: index.html');
  die();  
}

$row = $result->fetch_assoc();
$nome_do_utilizador = $row['nome'];

$conn -> close();

// Iniciar uma nova sessao vazia
session_start();
$_SESSION = array();

// Guardar o email e o nome do utilizador na sessão
$_SESSION['email'] = $email;
$_SESSION['nome_do_utilizador'] = $nome_do_utilizador;

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css">
<title>Autenticação</title>
</head>

<h1>Caro(a) <?php echo($nome_do_utilizador); ?> </h1>
<h1>Agora introduza a sua senha</h1>

<div class="auth_div" id='conteudo'>
    
    <form action="login.php" method="get" enctype="multipart/form-data">
   
      <p><label class="big_text">Senha</label></p>
      <input class="box big_text font_black" type="password" id="senha" name="senha">
        
      <p><div id="div_botao"><input class="big_text" id="submit_button" type="submit" value="Login" name="submit"></div>

    </form>


</div>


</body>
</html>
