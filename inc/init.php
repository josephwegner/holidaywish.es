<?php
require_once("config.php");

session_start();

mysql_connect($db_loc, $db_user, $db_password);
mysql_select_db($db_db);

require_once($path . "inc/functions.php");

if(!isset($_SESSION['user'])) {
	//Do login function here
	echo "logging in";
	$_SESSION['user'] = new StdClass();
	$_SESSION['user']->id = 1;
	$_SESSION['user'] = 1; 
} else {
	 loadStuff();
}

class GLBL {
	public static $controllers;
	public static $models;
	public static $views;
}
?>
