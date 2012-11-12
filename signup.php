<?php
require("includes.php");

if (isset($_POST['email'])) {
	$user = User::createNewUser($_POST['email'], $_POST['passwd'], $_POST['display_name']);
	if ($user !== false) {
		$_SESSION['user'] = &$user;
		echo "Your account has been created and you are signed in.  Click <a href='index.php'>Here to continue</a>";
	} else {
		echo "The email is already in use.";
	}
} else {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>Regex Hero - Game</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="login.js"></script>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="regexhero.css" type="text/css"/>
	</head>
<body>
<h1>Hero Registration</h1>

<form method="post" id="signup_form" onsubmit="return checkSignupForm(this);">
E-Mail*:<br/>
<input type="text" name="email"/><br/>
Password:<br/>
<input type="password" name="passwd"/><br/>
Confirm Password:<br/>
<input type="password" name="cpasswd"/><br/>
Display Name: (what is shown on the scoreboard)<br/>
<input type="text" name="display_name"/>
<br/>
<input type="submit" value="Begin Questing" onclick="checkSignupForm();"/>
</form>
<br/><br/>
* Your email will only be used for password recovery and to login.  It will never be sold or given to any other party.  In the future, if a newsletter is set up, you will receive one email with a notification and an option to opt-in.  Basically, your e-mail is being used as a convenience and not a way to spam you.
</body>
<?php
}
?>