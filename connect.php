<?php
/**
 * Created by Fernalia.
 * Contact : fernalia.h@gmail.com
 * User: Ferna
 * Date: 10/05/2017
 * Time: 10:44
 */

$db_host 	 = "localhost";
$db_username = "root";
$db_password = "";
$db_name   	 = "employees";

$conn = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error());

if($conn){
	mysql_select_db($db_name) or die(mysql_error());
} 