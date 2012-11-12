<?php
require("includes.php");

if (isset($_GET['question_passed'])) {
	$question_passed = $_GET['question_passed'];
	$quest = $_GET['quest'];
	$points = $_GET['points'];
	$user->updateQuestStatus($quest,$question_passed);
	$user->addPoints(100);
} else if (isset($_GET['quest_completed'])) {
	$quest = $_GET['quest_completed'];
	$user->completeQuest($quest);
}

?>