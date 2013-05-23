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

	
<?php

echo $header;

if ($user != null) {		
		?>
		<div id="content">
			<a href="regexhero.php" class="button">Play Regex Hero</a>
<?php

} else {
?>
<div class="hero-unit">
    <div class="container">
        <h1>Regex Quest</h1>
        <p>Face hard code problems and emerge victorious, with <em>the power of regular expressions</em>.</p>
        <p class="main-cta"><a href="/signup.php" class="btn btn-large btn-primary">Create your hero profile</a></p>
        <p class="small">or just <a href="">play the tutorial</a></p>
    </div>
</div>

<div id="content">



<div class="module login">
    <form method="post" id="login_form">
        <fieldset>
            <legend>Hero Login</legend>
            <dl>
                <dt>E-Mail:</dt>
                <dd><input type="text" name="email"/></dd>
                <dt>Password:</dt>
                <dd><input type="password" name="passwd"/></dd>
            </dl>
            <input type="submit" class="btn btn-small btn-primary" value="Begin Questing"/>
        </fieldset>
      
    </form>
</div><!-- .module.login -->
<hr />
<?php
}
?>			
			<a id="about" href="#about" name="about" class="button" onclick="$('#about_div').toggleClass('displayBlock');">Regex Hero Tutorial</a>
			
			<a id="leaderboard" href="leaderboard.php" name="leaderboard" class="button">Regex Quest Leaderboard</a>
		
			
			
			<a class="button" href="http://en.wikipedia.org/wiki/Regular_expression" target="_blank">About Regular Expressions</a>
		</div>
<?
echo $footer;
?>