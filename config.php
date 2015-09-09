<?php

$host="localhost"; //replace with database hostname 
$username="########"; //replace with database username 
$password="########"; //replace with database password 
$db_name="##########"; 

$con=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

?>