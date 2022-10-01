<?php
include_once("conexao.php");

/*
Exemplo da conexao sqlserver com php

Specify the server and connection string attributes.
 https://docs.microsoft.com/pt-br/sql/connect/php/how-to-connect-using-sql-server-authentication?view=sql-server-ver16

$dbhost   = "instancia_db ";
$db       = "database";
$user     = "new_user";
$password = "123456";

$connectionInfo = array("Database"=>$db,"UID"=>$user, "PWD"=>$password);
$conn = sqlsrv_connect($dbhost, $connectionInfo);

if( $conn === false ) {
    echo "Could not connect.\n <pre>";
    $message = "Erro ao conectar com sql server";
    if(isset(sqlsrv_errors()[0])){
        $message = sqlsrv_errors()[0];
    }
    die(print_r($message, true));
}
 * */

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="iso-8859-1">
    <title>OuroP - Contatos</title>
    <link rel=stylesheet href="ouroq.css">
    <link rel="stylesheet" href="framework/componentes/jquery_ui/jquery-ui.min.css">

	<!-- jquery -->
    <script src="framework/componentes/jquery/jquery-3.3.1.min.js"></script>
    <script src="framework/componentes/jquery_ui/jquery-ui.min.js"></script>
    <script src="funcoes/nfuncoes.js"></script>


<script type = "text/javascript" >
function preventBack(){window.history.forward();}
setTimeout("preventBack()", 0);
window.onunload=function(){null}

function IsEmail(email){
    var exclude=/[^@-.w]|^[_@.-]|[._-]{2}|[@.]{2}|(@)[^@]*1/;
    var check=/@[w-]+./;
    var checkend=/.[a-zA-Z]{2,3}$/;
    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
    else {return true;}
}
</script>
</head>
<body>
<div align="center">
<br>
<?php

$action = isset($_GET["action"]) ? strtolower($_GET["action"]) : '';
switch($action){
case "add":
	?>
	<form name=form1 method="post" action="<?php echo $prg?>?<?php echo $rqs3?>&action=addsave&<?php echo $rqs2?>" onSubmit="alert(IsEmail(document.getElementById('email').value))">
	<center>
	<p class = tit2> Inclusão de Contato</p>
	<hr width=70%><br>
	<table border = 1>
	<tr><td>Nome:<td><input name="nome" type=text size = 60 required></td></tr>
	<tr><td><label class=campo>Ativo?</label></td><td><input type=radio name=ativo value=S checked>Sim&nbsp;&nbsp;&nbsp;<input type=radio name=ativo value=N>Não</td></tr>
	<tr><td><label class=campo>Função:</label></td>
	<td><select name=id_funcao>
		<option value=0>Escolha</option>
		<?php
		$q = "select * from contatos_funcoes order by funcao";
		$resultado = sqlsrv_query($conn,$q, []) or die("Falha " .$q);
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
			?>
			<option value=<?php echo $row["id_funcao"]?>><?php echo $row["funcao"]?></option>
			<?php
		}
		?>
	</select></td></tr>
	<tr><td><label class=campo>Fone:</label></td><td><input maxlength="11" name="fone" type=text size=15 onkeypress="fone9(this);">&nbsp;</td></tr>
	<tr><td>Cliente:</td>
	<td><select name=id_cliente required>
		<option value=0>Escolha<option>
		<?php
		$q = "select * from clientes where ativo='S' order by nome";
		$resultado = sqlsrv_query($conn,$q, []) or die("Falha " .$q);
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
			?>
			<option value="<?php echo $row["id_cliente"]?>"><?php echo $row["nome"] ?></option>
		<?php
		}
		?>
	</select></td></tr>
	<tr>
	<td><label>E-mail:</td>
	<td><input name="email" id="email" type="text" size ="60"></label></td></tr>

	<tr><td>Obs:</td><td><textarea name="obs" cols="80" rows="2"></textarea></td></tr>
	</table>
	<br>
	<input class = "bt" type = "submit" value = "Incluir">
	</form>
	<hr width=70%>
	<br><br>
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=pesquisa&<?php echo $rqs4?>">Pesquisar</a>&nbsp;&nbsp;&nbsp;<br><br>
	<a href="ouro.php?<?php echo $rqs1?><?php echo $rqs4?>">Início</a>
	</center>
	<?php
break;
case "edit":
	$_SESSION["id_contato"] = isset($_GET["id_contato"])?$_GET["id_contato"]:0;
	$q = "
       SELECT id_contato,nome,id_cliente,email,ativo,co.id_funcao,
            case when fu.id_funcao Is Null then 0 else fu.id_funcao  end  as id_funcao,
            fu.funcao,fone,obs
	   FROM contatos co
            left join contatos_funcoes fu on co.id_funcao = fu.id_funcao
       WHERE id_contato = (?)";
	$resultado = sqlsrv_query($conn,$q, [$_SESSION["id_contato"]]) or die("Falha " .$q);
	$row= sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
	$qs_nome = $row["nome"];
	$qs_ativo = $row["ativo"];
	$qs_fone = $row["fone"];
	$qs_id_funcao = $row["id_funcao"];
	$qs_funcao = $row["funcao"];
	$qs_id_cliente = $row["id_cliente"];
	$qs_email = $row["email"];
	$qs_obs = $row["obs"];
	?>
	<p class = tit2> Atualização de dados do Contato</p>
	<hr width=70%>
	<br>
	<form method=post action="<?php echo $prg?>?<?php echo $rqs3?>&action=editsave&<?php echo $rqs2?>">
	<table width = 480 border=1>
	<tr><td><label class=campo>Nome:</label></td>
	<td>
	<?php
	if($qs_nome == null){
		?>
		<input name="nome" type=text size = 60></td>
		<?php
	}else{
		?>
		<input name="nome" type=text value="<?php echo $qs_nome ?>" size = 60>
		<?php
	}
	?>
	</td>
	</tr>
	<tr><td><label class=campo>Ativo?</label></td>
	<td>
	<?php
	if($qs_ativo <> "N" ){
		?>
		<input type=radio name=ativo value=S checked>Sim&nbsp;&nbsp;&nbsp;<input type=radio name=ativo value=N>Não
		<?php
	}else{
		?>
		<input type=radio name=ativo value=S>Sim&nbsp;&nbsp;&nbsp;<input type=radio name=ativo value=N checked>Não
		<?php
	}
	?>
	</td>
	</tr>
	<tr><td><label class=campo>Função:</label></td>
	<td>
	<select name=id_funcao>
		<option value=<?php echo $qs_id_funcao?>><?php echo $qs_funcao?></option>
		<?php
		$q = "select * from contatos_funcoes order by funcao";
		$resultado = sqlsrv_query($conn,$q, []) or die("Falha " .$q);
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
			?>
			<option value=<?php echo $row["id_funcao"]?>><?php echo $row["funcao"]?></option>
			<?php
		}
		?>
	</select>
	</td></tr>
	<tr><td><label class=campo>Cliente:</label></td>
	<td>
	<select name=id_cliente>
		<option value=0>Escolha<option>
		<?php
		$q = "select * from clientes where ativo='S' order by nome";
		$resultado = sqlsrv_query($conn,$q,[]) or die("Falha " .$q);
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
			if($row["id_cliente"] == $qs_id_cliente ){
				?>
				<option value="<?php echo $row["id_cliente"]?>" selected ><?php echo $row["nome"]?></option>
				<?php
			}else{
				?>
				<option value="<?php echo $row["id_cliente"]?>"><?php echo $row["nome"] ?></option>
				<?php
			}
		}
				?>
	</select>
	</td></tr>
	<tr><td><label class=campo>Fone:</label>
	<td>
	<?php
	if($qs_fone == null){
		?>
		<input maxlength="11" name="fone" type=text size=15 onkeypress="fone9(this);">&nbsp;
		<?php
	}else{
		?>
		<input maxlength="11" name="fone" type=text size=15 onkeypress="fone9(this);" value="<?php echo $qs_fone?>">&nbsp;
		<?php
	}
	?>
	</td></tr>
	<tr><td><label class=campo>E-mail:</label></td>
	<td>
	<?php
	if($qs_email == null){
		?>
		<input name="email" type="text" size = "60">
		<?php
	}else{
		?>
		<input name="email" type="text" value="<?php echo $qs_email ?>" size = "60">
		<?php
	}
	?>
	</td></tr>
	<tr><td><label class=campo>Observações:</label></td>
	<td>
	<?php
	if($qs_obs == null){
		?>
		<textarea name="obs" cols="80" rows="3"></textarea>
		<?php
	}else{
		?>
		<textarea name="obs" cols="80" rows="3"><?php echo $qs_obs ?></textarea>
		<?php
	}
	?>
	</td></tr>
	</table>
	<center>
	<br>
	<input class = "bt" type="submit" value = "Atualizar">
	</form>
	<br>
	<hr width=70%>
	<br>
	<a href="<?php echo $prg ?>?<?php echo $rqs1?>&action=add&<?php echo $rqs4?>">Incluir outro Contato</a>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=pesquisa&<?php echo $rqs4?>">Pesquisar</a>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=dele&<?php echo $rqs2?>"OnClick=javascript:excluir(this,"<?php echo $prg?>?<?php echo $rqs1?>&action=list<?php echo $rqs4?>");>Excluir Este</a><br><br>
	<a href="ouro.php?<?php echo $rqs3?><?php echo $rqs2?>">Início</a>
	<?php
break;
case "addsave":
	$q = "INSERT INTO contatos(nome,ativo,id_funcao,id_cliente,fone,email,obs) VALUES (?,?,?,?,?,?,?)";
	$params = [
	    $_POST["nome"],
	    $_POST["ativo"],
	    $_POST["id_funcao"],
	    $_POST["id_cliente"],
	    $_POST["fone"],
	    $_POST["email"],
	    $_POST["obs"]
	];
	$resultado = sqlsrv_query($conn,$q, $params) or die("Falha " .$q);
	echo "<p class = tit2>Contato Incluido</p><hr width=70%><br>";
	?>
	<center>
	<a href="<?php echo $prg ?>?<?php echo $rqs1?>&action=add&<?php echo $rqs4?>">Incluir outro Contato</a>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=pesquisa&<?php echo $rqs4?>">Pesquisar</a>&nbsp;&nbsp;&nbsp;<br><br>
	<a href="ouro.php?<?php echo $rqs3?><?php echo $rqs2?>">Início</a>
	</center>
	<?php
break;
case "editsave":
    $nome = !empty($_POST["nome"]) ? $_POST["nome"] : null;
    $ativo = isset($_POST["ativo"]) ? $_POST["ativo"] : null;
    $id_funcao = isset($_POST["id_funcao"]) ? $_POST["id_funcao"] : null;
    $id_cliente = !empty($_POST["id_cliente"]) ? $_POST["id_cliente"] : null;
    $fone = !empty($_POST["fone"]) ? $_POST["fone"] : null;
    $email = !empty($_POST["email"]) ? $_POST["email"] : null;
    $obs = !empty($_POST["obs"]) ? $_POST["obs"] : null;

	$q = "UPDATE contatos SET nome = ?,  id_funcao = ?, id_cliente = ?, fone = ?, email = ?, obs = ?
	      WHERE id_contato = (?)";
	$params = [$nome, $ativo, $id_cliente, $fone, $email, $obs, $_SESSION["id_contato"]];
	$resultado = sqlsrv_query($conn,$q, $params) or die("Falha " .$q);
	echo "<center><font color = red><p>Dados alterados com sucesso</p>";
	?>
	<br>
	<hr width=70%>
	<br>
	<a href="<?php echo $prg ?>?<?php echo $rqs1?>&action=edit&id_contato=<?php echo $_SESSION["id_contato"]?>&<?php echo $rqs4?>">Voltar aos Dados</a>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=add&<?php echo $rqs2?>">Incluir outro Contato</a><br> <br>
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=pesquisa&<?php echo $rqs4?>">Pesquisar</a>&nbsp;&nbsp;&nbsp;<br><br>
	<a href="ouro.php?<?php echo $rqs1?><?php echo $rqs4?>">Início</a>
	</center>
	<?php
break;
case "dele":
	$q = "DELETE FROM contatos WHERE id_contato = (?)" ;
	$resultado = sqlsrv_query($conn,$q, [$_SESSION["id_contato"]]) or die("Falha " .$q);
	echo "Contato excluido com sucesso<br><br>";
	?>
	<hr width=70%>
	<br>
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=add&<?php echo $rqs2?>">Incluir outro Contato</a>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=pesquisa&<?php echo $rqs4?>">Pesquisar</a>&nbsp;&nbsp;&nbsp;<br><br>
	<a href="ouro.php?<?php echo $rqs1?><?php echo $rqs4?>">Início</a>
	<?php
break;
case "list":
	$flag = 1;
	if(!empty($_POST["id_cliente"]) and $_POST["id_cliente"]>1){
		$midcliente=" and co.id_cliente = ".$_POST["id_cliente"];
		$flag = 1;
	}else{
		$midcliente='';
	}
	if(!empty($_POST["contato"])){
		$mcontato=" and co.nome like '%" . $_POST["contato"] . "%' ";
		$flag = 1;
	}else{
		$mcontato='';
	}
	if(!empty($_POST["email"])){
		$memail=" and co.email like '%".$_POST["email"]."%' ";
		$flag = 1;
	}else{
		$memail='';
	}
	$q = "select co.id_contato,co.nome as contato,co.fone,cl.nome as cliente, email,fu.funcao, co.obs from contatos_funcoes as fu right join(contatos as co left join clientes as cl on co.id_cliente = cl.id_cliente) on fu.id_funcao = co.id_funcao where 1 = 1 ".$midcliente.$mcontato.$memail;
	// para limitar visualização;
	if($flag == 0)
		$q .=   " and co.id_contato < 10 ";

	$q .=   " order by co.id_contato desc ";
	$resultado = sqlsrv_query($conn,$q) or die("Falha " .$q);
	?>
	<center><h5>Relação de Contatos</h5>
	<hr width=70%>
	<br>
	<table border=1>
	<tr><th>Ord</th><th>Contato</th><th>Cliente</th><th>Função</th><th>Fone</th><th>E-mail</th><th>Obs</th></tr>
	<tr>
	<?php
	$L=0;
	$cor = "lightcyan";
	while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
		$L += 1;
		if($cor == "lightcyan")
			$cor = "bisque";
		else
			$cor = "lightcyan";
		?>
		<tr bgcolor=<?php echo $cor?>>
		<td><a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=edit&id_contato=<?php echo $row["id_contato"]?>&<?php echo $rqs4?>"> <?php echo $L?></a></td>
		<td><a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=edit&id_contato=<?php echo $row["id_contato"]?>&<?php echo $rqs2?>"> <?php echo pessoa($row["contato"])?></a></td>
		<td><?php echo pessoa($row["cliente"])?>&nbsp;</td>
		<td><?php echo pessoa($row["funcao"])?>&nbsp;</td>
		<td><?php echo pessoa($row["fone"])?>&nbsp;</td>
		<td><?php echo $row["email"]?>&nbsp;</td>
		<td><?php echo $row["obs"]?>&nbsp;</td>
		</tr>
		<?php
	}
	?>
	</table>
	<br>
	<hr width=70%>
	<br>
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=add&<?php echo $rqs4?>">Incluir outro Contato</a>
	<br><br>
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=pesquisa&<?php echo $rqs4?>">Pesquisar</a>&nbsp;&nbsp;&nbsp;<br><br>
	<a href="ouro.php?<?php echo $rqs3?><?php echo $rqs4?>">Início</a>
	<br><br>
	</center>
	<?php
break;
case "pesquisa";
	?>
	<br>
	<h5>Pesquisar Contatos</h5>
	<hr width=70%>
	<br>
	<form name=form1 method=post action=<?php echo $prg?>?action=list>
	<table border=1>
	<tr><td>Nome:</td><td><input type=text name=contato size=50>Pode usar pedaços contínuos</td></tr>
	<tr><td>E-mail:</td><td><input type=text name=email size=50>Pode usar pedaços contínuos</td></tr>
	<tr><td>Cliente</td>
	<td>
	<select name=id_cliente>
		<option value=0>Escolha<option>
		<?php
		$q = "select * from clientes where ativo='S' order by nome";
		$resultado = sqlsrv_query($conn,$q) or die("Falha " .$q);
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
			?>
			<option value="<?php echo $row["id_cliente"]?>"><?php echo $row["nome"] ?></option>
			<?php
		}
		?>
	</select>
	</table>
	<br>
	<input type =submit class=bt Value=Pesquisar>
	</form>
	<br>
	<hr width=70%>
	<br>
	<a href="<?php echo $prg ?>?<?php echo $rqs3?>&action=add&<?php echo $rqs4?>">Incluir outro Contato</a><br><br>
	<a href="ouro.php?<?php echo $rqs3?>&<?php echo $rqs4?>">Início</a>
	<br><br>
	</center>
	<?php
}
?>
</div>
</body>
</html>
