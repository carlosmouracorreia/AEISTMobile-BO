<?php
header('Content-type=application/json; charset=utf-8');
require_once("config.php");


$sql = "select * from eventos_misc ORDER BY evento_id ASC"; 
mysql_query('SET CHARACTER SET utf8');
$result = mysql_query($sql);
$json = array();
 
if(mysql_num_rows($result)){
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
$lol['evento_id'] = $row['evento_id'];
$lol['texto_add'] = $row['texto_add'];
array_push($json,$lol);
}
}
mysql_close($con);

echo json_encode($json); 
?> 