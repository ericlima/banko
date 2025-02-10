<?php

// Ativar a visuaçização dos erros php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar a sessao
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Gera um token seguro
}

// se não está logado, volta para a página de login
if ( empty($_SESSION['logado']) || $_SESSION['logado'] != true) {
  header('Location: index.html');
  die();
}


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



<h1>Bem-vindo(a) <?php echo($_SESSION['nome_do_utilizador']); ?> </h1>
<h1>Indique os dados para transferência bancária</h1>

<div class="center" id='conteudo'>
    <form action="processar_transferencia.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      
      <p><label2 class="medium_text">Nome do destinatário: </label2> <input class="campo medium_text" type="text" id="nome" name="nome"> 
       
      <p><label2 class="medium_text">Número de conta bancária: </label2> <input class="campo medium_text" type="text" id="conta" name="conta"> 
    
      <p><label2 class="medium_text">Valor a transferir: </label2> <input class="campo medium_text" type="text" id="valor" name="valor">
    
      <p><div id="div_botao"><input class="big_text" id="submit_button" type="submit" value="Transferir" name="submit"></div>

    </form>


</div>


</body>
</html>
