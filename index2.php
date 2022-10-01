<?php
include("connect.php");



$nome = (!empty($_POST['nome']))         ? $_POST['nome']     : '' ;
$idade = (!empty($_POST['idade']))       ? $_POST['idade']    : '' ;
$endereco = (!empty($_POST['endereco'])) ? $_POST['endereco'] : '' ;


?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Estudos</title>
  </head>
  <body>
    <h2>Usuário</h2>
    <form class="" action="index2.php" method="post">
      <p>Nome:</p>
      <br>
      <input type="text" name="nome" value="<?php echo((!empty($nome)) ? $nome : '') ?>">
      <br>
      <p>Idade</p>
      <br>
      <input type="number" name="idade" value= <?php echo((!empty($idade)) ? $idade : '') ?> min=0>
      <br>
      <p>Endereço:</p>
      <br>
      <input type="text" name="endereco" value="<?php echo((!empty($endereco)) ? $endereco : '') ?>">
      <br><br>
      <button type="submit" name="GO">GO</button>
      <br>

    </form>

  </body>
</html>
