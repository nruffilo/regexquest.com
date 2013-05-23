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
        <p>Face challenging code problems and emerge victorious, with <em>the power of regular expressions</em>.</p>
        <p class="main-cta"><a href="/signup.php" class="btn btn-large btn-primary">Create your hero profile</a></p>
        <p class="small">or just <a href="/tutorial.php">play the tutorial</a></p>
    </div>
</div>

<div id="content">
</div>

<?php
}

echo $footer;
?>