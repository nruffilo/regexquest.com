<?php
class User {
	private $user_id;
	private $email;
	private $display_name;
	private $problems_solved;
	private $points;
	private $title;
	private $titles;
	
	public function __construct($user_id) {
		global $db;
		$user_info = $db->query_one("SELECT * FROM users WHERE user_id = {$user_id}");
		$this->user_id = $user_id;
		$this->email = $user_info['email'];
		$this->display_name = $user_info['display_name'];
		$this->problems_solved = $user_info['problems_solved'];
		$this->points = $user_info['points'];
		$this->title = $user_info['title'];
	}
	
	public static function createNewUser($email, $password, $display_name) {
		global $db;
		//check to see if the email is registered already
		$chk = $db->query_one("SELECT user_id FROM users WHERE email = x'".bin2hex($email)."'");
		if (isset($chk['user_id'])) {
			return false;
		} else {
			$password = md5($_POST['passwd']."_reghero");
			$user_id = $db->query("INSERT INTO users (email, password, display_name) VALUES (x'".bin2hex($_POST['email'])."','{$password}',x'".bin2hex($display_name)."')");
			$db->query("INSERT INTO user_titles (user_id, title) VALUES($user_id,'Apprentice')");
			return new User($user_id);
		}
	}
	
	public static function login($email, $password) {
		global $db;
		$password = md5($password."_reghero");
		$user_id = $db->query_one("SELECT user_id FROM users WHERE email = x'". bin2hex($email)."' AND password = '{$password}'");
		if (isset($user_id['user_id'])) {
			return new User($user_id['user_id']);
		} else {
			return false;
		}
	}
	
	public function getQuestStatus() {
		global $db;
		$quest_status = $db->query("SELECT * FROM user_quest_status WHERE user_id = {$this->user_id}");
		return $quest_status;
	}
	
	public function getPoints() {
		return $this->points;
	}
	
	public function addPoints($points) {
		global $db;
		$this->points += $points;
		$db->query("UPDATE users SET points = {$this->points} WHERE user_id = {$this->user_id}");
	}

	public function addProblemSolved($num_of_problems) {
		global $db;
		$this->problems_solved += $num_of_problems;
		$db->query("UPDATE users SET problems_solved = {$this->problems_solved} WHERE user_id = {$this->user_id}");
	}
	
	public function getProblemsSolved() {
		return $this->problems_solved;
	}
	
	public function setTitle($title) {
		global $db;
		$this->title = $title;
		$db->query("UPDATE users SET title = {$this->title} WHERE user_id = {$this->user_id}");
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getUserId() {
		return $this->user_id;
	}
	
	public function updateQuestStatus($quest,$question_number) {
		global $db;
		$db->query("INSERT INTO user_quest_status (user_id, quest_name, current_question) VALUES({$this->user_id}, '$quest',{$question_number}) ON DUPLICATE KEY UPDATE current_question = {$question_number}");
		$this->addProblemSolved(1);
	}
	
	public function completeQuest($quest) {
		global $db;
		$db->query("UPDATE user_quest_status SET current_question = current_question + 1, completed = 1 WHERE user_id = {$this->user_id} AND quest_name = '$quest'");
		$this->addProblemSolved(1);
	}

}
?>