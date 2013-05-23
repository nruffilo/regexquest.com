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
		<?php echo $header; ?>
		<div id="content">
			<h1>Leaderboard</h1>
			<p><em>The top 50</em></p>
		
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
<?php 
echo $footer;
?>