<?php
require("includes.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>Regex Quest - Game</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="regexhero.js"></script>
		<script src="questjs.php" language="javascript"></script>
		<script>
			questStatus = {};
		<?php
			if ($user == null) {
				echo "document.location.href='index.php';";
			} else {
				$questStatus = $user->getQuestStatus();
				if (count($questStatus)>0) { 
					foreach ($questStatus as $quest) {
						echo "	questStatus['{$quest['quest_name']}'] = {};\n";
						echo "	questStatus['{$quest['quest_name']}'].current_question = {$quest['current_question']};\n";
						echo "	questStatus['{$quest['quest_name']}'].completed = {$quest['completed']};\n";
					}
				}
				$solved = $user->getProblemsSolved();
				$pts = $user->getPoints();
				$title = $user->getTitle();
				echo "	points = {$pts};\n";
				echo "	title = '{$title}';\n";
				echo "	problems_solved = {$solved};\n";
			}
		?>
		</script>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="regexhero.css" type="text/css"/>
		
	</head>
	<body>
		
		<?php echo $header; ?>
		
		<div id="stats">
			<div class="stat_label">Problems Solved:</div> <div class="stat_value" id="stats_problems_solved"></div>
			<div style="clear:both;"></div>
			<div class="stat_label">Points:</div> <div class="stat_value" id="stats_points"></div>
			<div style="clear:both;"></div>
			<div class="stat_label">Title:</div> <div class="stat_value" id="stats_title"></div>
			<div style="clear:both;"></div>
			<hr/>
			<p>Notes:</p>
			<div id="notes">
			<span class="note">All searches need to start and end with "/"</span>
			<span class="note">Progress is auto-saved.  You can always come back and pick up where you left off.</span>
			<span class="note">Want to create a quest?  Click <a href='quest_creator.php' target="_blank">Here</a></span>
			<span class="note">How do you rank?  Check out the <a href='leaderboard.php' target="_blank">leaderboard</a></span>
			</div>
		</div>
		<div id="content">
			<div id="difficulty">
			</div>

			<div id="question">
				<div id="question_hint"></div>
				<div id="question_statement"></div>
				<div id="question_answer1_div">
					<div id="find_label">Search For:</div><input type="text" class="find" id="question_answer_find1"/>
					<div id="replace_label" class="replace">Replace With:</div><input type="text" class="replace" id="question_answer_replace1"/>

					<input type="button" id="question_answer1_button" value="Wave Your Regex Wand">
				</div>
				<div id="question_answer1_response"></div>
				
				<div id="question_answer2_div">
					<input type="text" id="question_answer2"/>
					<input type="text" class="replace" id="question_answer_replace2"/>
					<input type="button" id="question_answer2_button" value="Refocus Your Powers">
				</div>
				<div id="question_answer2_response"></div>
				
				<div id="feedback"></div>
				<input type="button" id="next_question_button" onclick="loadNextQuestion()" value="Onwards!"/>
			</div>		
		</div>
	</body>
</html>