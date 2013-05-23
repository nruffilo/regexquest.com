<?php
error_reporting(E_ALL);
ini_set("display_errors",true);
require("config.php");
require("DatabaseUtil.php");
require("utilities.php");
require("user.php");
$db = new DatabaseUtil();
session_start();
$user = null;
if (isset($_SESSION['user'])) {
	$user = &$_SESSION['user'];
}

$header='<h1 id="head"><a href="/">Regex Hero</a></h1>';
?>