<?php
$host="";
$db_username="";  
$password="";
$database="";

$link = mysql_connect($host,$db_username,$password);
mysql_select_db($database)or die( "Unable to select database");
?>