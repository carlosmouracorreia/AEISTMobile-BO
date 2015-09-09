<?php
$pass = "########";

//this is for android notifications
require_once("curlRequest.php");
require_once("../config.php");

if(isset($_COOKIE["admin"]) and md5($pass)==$_COOKIE["admin"]) {

 
$uppath = '../pics/';      // directory to store the uploaded files
$max_size = 2000;          // maximum file size, in KiloBytes
$alwidth = 301;            // maximum allowed width, in pixels
$alheight = 301;           // maximum allowed height, in pixels
$allowtype = array('bmp', 'gif', 'jpg', 'jpeg', 'png');        // allowed extensions

$sql = "select * from churrascos ORDER by churrasco_id DESC"; 
mysql_query('SET CHARACTER SET utf8');
$result = mysql_query($sql);
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AEIST Mobile BO - Churrascos Manager </title>
</head>

<body>
<form action="churrascos.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="354" height="209" border="1" align="center">
  <tr>
    <th colspan="2" scope="row"><a href="eventos.php">Adicionar Evento</a> | Adicionar Churrasco | <a href="churrascos.php?a=logout">Logout</a></th>
  </tr>
  <tr>
    <th width="154" scope="row">Titulo:</th>
    <td width="46">
    <input type="text" name="titulo" id="textfield" /></td>
  </tr>
  <tr>
    <th scope="row">Descrição:</th>
    <td>
    <textarea rows="4" cols="50" name="desc" id="textfield2"> </textarea>
	</td>
  </tr>
  <tr>
    <th scope="row">Dia:</th>
    <td><input type="text" name="dia" id="textfield2" /></td>
  </tr>
  <tr>
    <th scope="row">Fotografia:</th>
    <td><input type="file" name="fileup" id="fileField" /></td>
  </tr>
   <tr>
    <th colspan="2" scope="row"><p><input name="verif" type="hidden" value="verif" /><input type="hidden" name="MAX_FILE_SIZE" value="512000" /><input type="submit" name="button" id="button" value="Inserir" /></p>
    <p><?php
	if($_POST["verif"] != "") {
		if(isset($_FILES['fileup']) && strlen($_FILES['fileup']['name']) > 1) {
	$temp = explode(".",$_FILES["fileup"]["name"]);
	$newfilename = md5(rand(1,99999)) . '.' .end($temp);
	$uploadpath = $uppath . $newfilename;     
	while(file_exists ( $uploadpath	)) {
		$newfilename = md5(rand(1,99999)) . '.' .end($temp);
		$uploadpath = $uppath . $newfilename; 
	}
  // gets the file name
  $sepext = explode('.', strtolower($_FILES['fileup']['name']));
  $type = end($sepext);       // gets extension
  list($width, $height) = getimagesize($_FILES['fileup']['tmp_name']);     // gets image width and height
  $err = '';         // to store the errors

  // Checks if the file has allowed type, size, width and height (for images)
  if(!in_array($type, $allowtype)) $err .= 'O Ficheiro: <b>'. $_FILES['fileup']['name']. '</b> não tem extensão de tipo permitido.';
  if($_FILES['fileup']['size'] > $max_size*1000) $err .= '<br/>O Tamanho maximo do ficheiro dever ser: '. $max_size. ' KB.';
  if(isset($width) && isset($height) && ($width >= $alwidth || $height >= $alheight)) $err .= '<br/>A maxima largura X altura deve ser: 300x300px';

  // If no errors, upload the image, else, output the errors
  if($err == '') {
    if(move_uploaded_file($_FILES['fileup']['tmp_name'], $uploadpath)) { 
	  $linkfoto = 'http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['REQUEST_URI']), '\\/').'/'.$uploadpath.'';
	  //envia dados para base de dados
	  mysql_query("INSERT INTO `churrascos`(`churrasco_id`, `name`, `desc`, `urlFoto`, `dia`) VALUES (NULL,'".filter_var($_POST["titulo"], FILTER_SANITIZE_STRING)."','".filter_var($_POST["desc"], FILTER_SANITIZE_STRING)."','".$linkfoto."','".filter_var($_POST["dia"], FILTER_SANITIZE_STRING)."')");
    $message = array("message" => "Novo Churrasco Adicionado!",
            "type" => "bbq");  
    sendPushNotificationToGCM($message);
    header("Location: churrascos.php?a=ok");
	  
    }
    else echo '<b>Não foi possivel enviar o ficheiro.</b>';
  }
  else echo $err;
}

	}
	
	if($_GET["a"] == "ok") { echo "<p><b>Churrasco adicionado!</b></p>"; } 
	if($_GET["a"] == "del") { echo "<p><b>Churrasco apagado!</b></p>"; } 
	if($_GET["a"] == "logout") {
		setcookie("admin", md5($pass), time()-3600);
		header("Location: index.php?a=logout");
		} 
	if($_GET["del"] != "") {
		mysql_query("delete from churrascos where churrasco_id='".$_GET["del"]."'");
		header("Location: churrascos.php?a=del");
	}
	?></p></th>
  </tr>
</table>
</form>
<p>&nbsp;</p>
<table width="800" border="1" align="center">
<tr>
	<td><b>Titulo</b></td>
    <td width="350"><b>Descrição</b></td>
	<td><b>Data</b></td>
	<td><b>Fotografia</b></td>
    <td></td>
</tr>
<?php 
if(mysql_num_rows($result)){
while($row=mysql_fetch_array($result)){
	?>
 <tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['desc']; ?></td>
    <td><?php echo $row['dia']; ?></td>
    <td><img src="<?php echo $row['urlFoto']; ?>" /></td>
    <td><a href="churrascos.php?del=<?php echo $row['churrasco_id']; ?>">Apagar</a></td>
  </tr>
<?php
}
}
mysql_close($con);
?>
</table>
</body>
</html>
<?php
}else {
	header("Location: index.php");
}
?>