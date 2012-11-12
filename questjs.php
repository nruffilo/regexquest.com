<?php
require("includes.php");

$quests = $db->query("SELECT * FROM quests WHERE status = 2");
if (count($quests) > 0) {
foreach ($quests as $quest) {
	$title = str_replace(array('"','\\'),array('\"','\\\\'),$quest['title']);
	$description = str_replace(array('"','\\'),array('\"','\\\\'),$quest['description']);
	$difficulty = $quest['difficulty'];
	echo <<<EOQUEST
	quests['{$quest['safe_name']}'] = {
		name: "$title - $description ($difficulty)",
questions: [
EOQUEST;
	
	$questions = $db->query("SELECT * FROM quest_questions WHERE quest_id = {$quest['quest_id']} ORDER BY question_number ASC");
	$q_text = array();
	foreach($questions as $q) {
		$hint = str_replace(array('"','\\'),array('\"','\\\\'),$q['hint']);
		$description = str_replace(array('"','\\'),array('\"','\\\\'),$q['description']);
		$answer = str_replace(array('"','\\'),array('\"','\\\\'),$q['answer']);
		
		$qtext[] = <<<EOQUESTION
		{	
			options:1, type: '{$q['type']}', answered:0,
			hint:"$hint",
			description:"$description",
			answer:"$answer"
		}
EOQUESTION;
	}	
	echo implode(",",$qtext);
	echo "]\n}\n";
}

}
?>