<?php
require_once("config.php");

session_start();

mysql_connect($db_loc, $db_user, $db_password);
mysql_select_db($db_db);

require_once($path . "inc/functions.php");

loadStuff();

if(!isset($_SESSION['user'])) {
	GLBL::$controllers->Login->index();
	die();	
}

class GLBL {
	public static $controllers;
	public static $models;
	public static $views;
	public static $helpers;
}
?>
