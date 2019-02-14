<?php

$host = "localhost";
$username = "medim_library";
$password = "%&fs~u)WU.we";
$database = "medim_library";


$connect = mysql_connect($host, $username, $password);
mysql_select_db($database);
mysql_query("SET NAMES UTF8");
if(!$connect) {
	echo "Couldn't connect to the database.";
	exit();
}




?>