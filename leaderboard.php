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
		<?php echo $header; ?>
		<div id="content">
			<h1>Leaderboard</h1>
			<p>(Displays only the top 50)</p>
		
			<a href="index.php" class="button">Home</a>

			<table id="leaderboard">
				<thead>
					<tr>
						<td>Rank</td>
						<td>Hero</td>
						<td>Quests Completed</td>
						<td>Total Points</td>
					</tr>
				</thead>
				<?php
				
				$ranks = $db->query("SELECT display_name, points, user_id FROM users WHERE 1 ORDER BY points DESC LIMIT 10");
				$i=0;
				foreach ($ranks as $rank) {
					$i++;
					$completed_quests = $db->query_one("SELECT count(quest_name) as cnt FROM user_quest_status WHERE user_id = {$rank['user_id']} AND completed = 1");
					$comp_quest = $completed_quests['cnt'];
					echo <<<EOROW
						<tr>
						<td>$i</td>
						<td>{$rank['display_name']}</td>
						<td>{$comp_quest}</td>
						<td>{$rank['points']}</td>
						</tr>
EOROW;
				}
				?>
			</table>			
			
		</div>
	</body>
</html>