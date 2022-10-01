<?php

$texto = "hello world!";
$nome_idade = [];
$nome_idade['Marcio']   = 26;
$nome_idade['Lucas']    = 30;
$nome_idade['Fernando'] = 33;
$nome_idade['Marina']   = 25;
$nome_idade['Lucia']    = 22;
$nome_idade['Lemuel']   = 1;


$nome    = (!empty($_POST['nome']))    ? $_POST['nome']    : '' ;
$marcado = (!empty($_POST['marcado'])) ? $_POST['marcado'] : false;
$selecao = (!empty($_POST['selecao'])) ? $_POST['selecao'] : '' ;
 ?>
<!DOCTYPE html>
<html lang="pt-br"  dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Estudo WE</title>
  </head>
  <body>
    <?php if (true): ?>
      <form class="" action="index.php" method="post">
        <p>nome:</p>
        <input type="text" name="nome" value="<?php echo((!empty($nome)) ? $nome : '' )?>">
        <br>
        <p>imprimir:</p>
        <input type="checkbox"  name="marcado" value="true" <?php echo(($marcado) ?  'checked' : '' )?>>
        <br>
        <p>Selecione:</p>
        <select class="" name="selecao">
          <option value="1"> 1 </option>
          <option value="2" > 2 </option>
          <option value="3" <?php echo(($selecao == 3) ?  'selected' : '' )?>> 3 </option>
          <option value="4"> 4 </option>
          <option value="5"> 5 </option>
          <option value="6"> 6 </option>

        </select>
        <button type="submit" name="Vaicarai" value="true">GO</button>
      </form>

    <?php else: ?>
      <?php echo imprimeNome() ?>
      <br>
      <a href="index.php">Voltar</a>
    <?php endif; ?>
  </body>
</html>
<?php
// var_dump($nome);
function imprimeNome()
{
  global $nome, $selecao;
  return "O nome é: $nome e a selação é: $selecao";
}



 ?>
