<?php
header('Content-type=application/json; charset=utf-8');
$host="localhost"; //replace with database hostname 
$username="######"; //replace with database username 
$password="######"; //replace with database password 
$db_name="#######"; //replace with database name
 
$con=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
$sql = "select * from eventos ORDER BY evento_id ASC"; 
mysql_query('SET CHARACTER SET utf8');
$result = mysql_query($sql);
$json = array();
 
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