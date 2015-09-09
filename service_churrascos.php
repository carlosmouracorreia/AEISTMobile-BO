 <?php
header('Content-type=application/json; charset=utf-8');

require_once("config.php");
 

$sql = "select * from churrascos ORDER BY churrasco_id DESC"; 
mysql_query('SET CHARACTER SET utf8');
$result = mysql_query($sql);
$json = array();
 
if(mysql_num_rows($result)){
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
$lol['churrasco_id'] = $row['churrasco_id'];
$lol['name'] = $row['name'];
$lol['desc'] = $row['desc'];
$lol['urlFoto'] = $row['urlFoto'];
$lol['dia'] = $row['dia'];
array_push($json,$lol);
}
}
mysql_close($con);

echo json_encode($json); 
?> 