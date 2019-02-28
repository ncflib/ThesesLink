<?php

$dsn = 'mysql:dbname=;host=localhost';
$user = '';
$password = '';

try 
{
    $db = new PDO($dsn, $user, $password);
    $db -> exec("SET CHARACTER SET utf8");


}
catch( PDOException $Exception ) 
{   
     echo "Unable to connect to database.";
     exit;
}

?>