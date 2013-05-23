<?php
//error_reporting(E_ALL);
//ini_set("display_errors",true);
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

$header=<<<HEADER
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta charset="UTF-8" />
    <title>Regex Quest</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="index.js"></script>
    <link rel="stylesheet" href="bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="regexhero.css" type="text/css"/>
</head>
<body>


<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a href="/" class="brand">Regex Quest</a>
            <a href="/login.php" class="navbar-text pull-right">Login</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/tutorial.php">Get started</a></li>
                    <li><a href="/leaderboard.php">High Scores</a></li>
                    <li><a href="/about.php">About Regex Quest</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
HEADER;

$footer=<<<FOOTER
    <hr />
    <footer>
        <div class="container">
            <div class="btn-group">
                <a class="btn btn-small" href="/tutorial.php">Regex Quest Tutorial</a>
                <a class="btn btn-small" href="/leaderboard.php">Regex Quest Leaderboard</a>
                <a class="btn btn-small" href="http://en.wikipedia.org/wiki/Regular_expression" target="_blank">About Regular Expressions</a>
                <a class="btn btn-small" href="https://github.com/nruffilo/regexquest.com">Project GitHub</a>
            </div>
        </div>
    </footer>
</body>
</html>
FOOTER;

?>