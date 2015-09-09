<?php
header('Content-type=application/json; charset=utf-8');

require_once("config.php");

$sql = "select * from eventos ORDER BY evento_id ASC"; 
mysql_query('SET CHARACTER SET utf8');
$result = mysql_query($sql);
$json = array();


if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}

mysql_query("INSERT INTO ip_data(ip) VALUES('".$ip."')");

 
if(mysql_num_rows($result)){
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
$lol['evento_id'] = $row['evento_id'];
$lol['evento_titulo'] = $row['evento_titulo'];
$lol['evento_desc'] = $row['evento_desc'];
$lol['evento_link'] = $row['evento_link'];
$lol['evento_foto'] = $row['evento_foto'];
$lol['data'] = $row['data'];
array_push($json,$lol);
}
}
mysql_close($con);

echo json_encode($json); 
?> 
