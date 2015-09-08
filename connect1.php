<?php
$conn_error = "Could not connect.<br>";
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_db = 'Website_Change';
if (!@mysql_connect($mysql_host, $mysql_user, $mysql_pass) || !@mysql_select_db($mysql_db))
{
	die($conn_error);	
}
