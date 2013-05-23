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
		
		<script>
		
function openTester() {
	$("#regex_tester").css("display","block");
	$("#regex_tester").css("top",$(document).scrollTop()+25+"px");
}
function testQuery(find, replace, str) {
	$.ajax({
		url: "regex.php",
		data: {find: find, replace: replace, string: str}
	}).done(function(data) {
		parseTest(data);
	});
}

function parseTest(data) {
	//alert("The response was: " + data);
	$("#regex_tester_result").html(data);
}

		</script>
	</head>
	<body>
		<?php echo $header; 
		
if ($user == null) {		
		?>
		<script langauge="javascript">
		alert("You must be logged in");
		document.location.href="index.php";
		</script>
<?php
} else {
?>
<div id="regex_tester" style="display:none; position: absolute; background-color: #DDDDDD; height: 400px; width: 500px;">
	Start: <input type="text" id="regex_tester_start"><br/>
	Find: <input type="text" id="regex_tester_find"><br/>
	Replace*: <input type="text" id="regex_tester_replace"><br/>
	Result: <div id="regex_tester_result"></div><br/>
	<input type='button' value='Test Expression' onclick="testQuery($('#regex_tester_find').val(),$('#regex_tester_replace').val(),$('#regex_tester_start').val());"/><br/>
	*Leave replace blank if you want to simply do a find<br/>
	<input type='button' value='close' onclick="$('#regex_tester').css('display','none');">
	
</div>
<div id="content">



<?php

if (isset($_POST['create_quest'])) {
	$quest_id = $db->query("INSERT INTO quests (title, description, difficulty,creator_user_id) VALUES (x'".bin2hex($_POST['quest_title'])."',x'".bin2hex($_POST['description'])."','{$_POST['difficulty']}',".$user->getUserId().")");
	$db->query("UPDATE quests SET safe_name = 'quest{$quest_id}' WHERE quest_id = $quest_id");
}

if (isset($_POST['submit_review'])) {
	$db->query("UPDATE quests SET status = 1 WHERE quest_id = '{$_POST['submit_review']}'");
	echo "Your quest has been submitted for review.  Once approved, it will be avialable for all to play!";
}

if (isset($_GET['quest_id'])) {
	$quest_id = $_GET['quest_id'];
	$quest_info = $db->query_one("SELECT * FROM quests WHERE quest_id = '$quest_id'");
	if ($quest_info['creator_user_id'] != $user->getUserId()) {
		die("This is not your quest.  <a href='index.php'>Home</a>");
	}
	echo "<h1>Manage Quest: {$quest_info['title']}</h1>";
	echo "<a href='quest_creator.php'>Back to Quest Creator</a> <a href='regexhero.php'>Back to game</a><br/>";

	echo "<p>Description: {$quest_info['description']}</p>";
	echo "<p>Difficulty: {$quest_info['difficulty']}</p>";
	
	if (isset($_POST['new_question'])) {
		$qnum = $db->query_one("SELECT count(question_id) as cnt FROM quest_questions WHERE quest_id = '$quest_id'");
		$qnum = $qnum['cnt']+1;
		$db->query("INSERT INTO quest_questions (quest_id, question_number, type, hint, description, answer) VALUES ('$quest_id',$qnum,'{$_POST['type']}',x'".bin2hex($_POST['hint'])."',x'".bin2hex($_POST['description'])."',x'".bin2hex($_POST['answer'])."')");
	}
	
	if (isset($_POST['edit_question'])) {
		$db->query("UPDATE quest_questions SET type='{$_POST['qtype']}', hint=x'".bin2hex($_POST['hint'])."',description=x'".bin2hex($_POST['description'])."', answer=x'".bin2hex($_POST['answer'])."' WHERE question_id = {$_POST['edit_question']}");
	}
	
	
	$questions = $db->query("SELECT * FROM quest_questions WHERE quest_id = '$quest_id'");
	if (count($questions) > 0) {
		foreach ($questions as $question) {
			$type = ($question['type'] =='find') ? "<option selected>find</option><option>replace</option>" : "<option>find</option><option selected>replace</option>" ;
		
			echo <<<EOQUESTION
			<form method="post">
			<input type="hidden" name="edit_question" value="{$question['question_id']}">
			<div class='question_display'>
			<p>{$question['question_number']}) Type: <select name="qtype">$type</select><br/>
			Hint: <textarea name="hint" rows=0 cols=50>{$question['hint']}</textarea><br/>
			Start: <textarea id="q{$question['question_id']}start" name="description" rows=0 cols=50>{$question['description']}</textarea><br/>
			Answer: <textarea name="answer" rows=0 cols=50>{$question['answer']}</textarea></p>
			<input type='submit' value='Update Question'/> <input type='button' value='test' onclick='openTester();$("#regex_tester_start").val($("#q{$question['question_id']}start").val());'/>
			</div>
			</form>
			
EOQUESTION;
		}
	}
	
	?>
	<a name="new_question" id="new_question"/>
	<form method="post" action="#new_question">
		<input type="hidden" name="new_question" value="true"/>
		Type: <select name="type">
			<option>find</option>
			<option>replace</option>
		</select><br/>
		Hint (Displayed First):<br/>
		<input type="text" name="hint" style="width:400px;" maxchars="255"><br/>
		<br/>
		Start (This is the statement that the Regular Expression will be applied to:<br/>
		<input type="text" id="new_question_start" name="description" style="width:400px;" maxchars="255"><br/>
		<br/>
		Answer (Resulting Find and/or replace must result in this)**:<input type="text" name="answer" style="width:400px;" maxchars="255"><br/>
		**: For readability, multiple results will have a " " inserted between them.  So, if you're having the user find 4 words, then then answer will be those 4 words with spaces between.  
		<br/>
		<input type="submit" value="Add Question"/><input type='button' value='test' onclick='openTester();$("#regex_tester_start").val($("#new_question_start").val());'/>
	</form>

	<br/><br/>
	
	<h2>Done with your quest?</h2>
	<form method="post" action="quest_creator.php">
	
		<input type="hidden" name="submit_review" value="<?php echo $quest_id; ?>"/>
		<input type="submit" value="Submit quest for review"/>
	</form>
	
	<?php
		


} else {
echo "<h1>Create/Manage Quests</h1>";
echo "<a href='regexhero.php'>Back to game</a><br/>";

$quests = $db->query("SELECT quest_id, title, description, difficulty, status FROM quests WHERE creator_user_id = ".$user->getUserId());
if (count($quests) > 0) {
	echo "<h2>Your Existing Quests/Status:</h2>";
	foreach ($quests as $quest) {
		$status = "";
		switch ($quest['status']) {
			case 0:
				$status = "Creation";
				break;
			case 1:
				$status = "In Review";
				break;
			case 2: 
				$status = "Active";
		}
		echo "<a href='quest_creator.php?quest_id={$quest['quest_id']}'>{$quest['title']} - {$quest['description']} ({$quest['difficulty']}) [[{$status}]]</a><br/>";
	}
}
?>
	<form method="post">
		<input type="hidden" name="create_quest" value="true"/>
		<h2>Create New Quest:</h2>
		Quest Title:<input type='text' name='quest_title'/><br/>
		Description:<input type='text' name='description'/><br/>
		Difficulty:<select name="difficulty">
			<option>tutorial</option>
			<option>easy</option>
			<option>medium</option>
			<option>hard</option>
			<option>insane</option>
		</select>
		<Br/>
		<input type="submit" value="Create Quest"/>
	</form>
<?php
}
}
?>			
		</div>
	</body>
</html>