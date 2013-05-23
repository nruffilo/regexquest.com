<?php
require("includes.php");
if (isset($_POST['email'])) {
	$user_check = User::login($_POST['email'],$_POST['passwd']);
	if ($user_check !== false) {
		$user = $user_check;
		$_SESSION['user'] = &$user;
	} else {
		echo "Email/password combination failed\n<br/>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Regex Hero</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="index.js"></script>
		<link rel="stylesheet" href="regexhero.css" type="text/css"/>
	</head>
	<body>
	
<?php

echo $header;

if ($user != null) {		
		?>
		<div id="content">
			<a href="regexhero.php" class="button">Play Regex Hero</a>
<?php

} else {
?>
<div id="content">

<div class="module login">
    <h1>Hero Login</h1>
    <form method="post" id="login_form">
        <fieldset>
            <legend>Hero Login</legend>
            <dl>
                <dt>E-Mail:</dt>
                <dd><input type="text" name="email"/></dd>
                <dt>Password:</dt>
                <dd><input type="password" name="passwd"/></dd>
            </dl>
        </fieldset>
        <input type="submit" value="Begin Questing"/>
    </form>
    <br/>
    OR<br/>
    <p><a class="button" href='signup.php'>Create a New Hero</a></p>
    <p>Forgot your password?  (Functionality coming soon!)</p>
</div><!-- .module.login -->

<?php
}
?>			
			<a id="about" href="#about" name="about" class="button" onclick="$('#about_div').toggleClass('displayBlock');">Regex Hero Tutorial</a>
			<a id="leaderboard" href="leaderboard.php" name="leaderboard" class="button">Regex Quest Leaderboard</a>
			<div id="about_div">
				<p>Regex Quest is a game that teaches regular expressions by asking players to solve problems using only the wonderful tool that is Regular Expressions.  </p>
				<p>Some questions are very straight forward, but some require thought.  Additionally, some questions are multi-part, so you'll need to translate the text once, then use another expression to translate it once again.</p>
				<p>Three different modes - easy, medium, insane - are here to train users and give a reasonable judge what level master you are!</p>
			</div>			
			
			
			<a class="button" href="http://en.wikipedia.org/wiki/Regular_expression" target="_blank">About Regular Expressions</a>
		</div>
	</body>
</html>