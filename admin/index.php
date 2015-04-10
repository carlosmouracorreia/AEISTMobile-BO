<?php
if(isset($_COOKIE["admin"]) and md5("###########")==$_COOKIE["admin"]) {
	header("Location: eventos.php"); }
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AEIST Mobile - BackOffice</title>
</head>

<body><form id="form1" name="form1" method="post" action="index.php">
<table width="200" border="1" align="center">
  <tr>
    <td colspan="2"><p><img src="pics/logo.jpg" width="300" height="300" /></p>
    <div align="center"><p>AEIST Mobile - BOffice</p>
    <?php
	$user = $_POST["user"];
	$pass = $_POST["pass"];
	
	if($_POST["verif"] != "") {
		if($user == "#########" && $pass == "#########") {
			setcookie("admin", md5($pass), time()+3600);
			header("Location: eventos.php");
		}
		else { echo "<p><b>Utilizador ou password errados.</b></p>"; }
	}
	if($_GET["a"] == "logout") {
		echo "<p><b>Logout feito com sucesso.</b></p>";
	}
	?>
    </div></td>
  </tr>
  <tr>
    <td>Utilizador:</td>
    <td><label for="user"></label>
      <input type="text" name="user" id="user" /></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><label for="pass"></label>
      <input type="password" name="pass" id="pass" /></td>
  </tr>
  <tr>
    <td><input type="submit" name="button" id="button" value="Entrar" />
    </td>
    <td><input name="verif" type="hidden" id="verif" value="verif" /></td>
  </tr>
</table></form>
</body>
</html>