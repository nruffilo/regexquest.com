var difficulty = null;
var problems_solved = 0;
var points = 0;
var title = "Squire";
var question_number = 0;

$(document).ready(function() {
	$("#title_heading").fadeIn('slow');
	$("#title_subheading").delay(500).fadeIn('slow');
	
	$("#question_answer1_button").click(function() {
		runQuery($("#question_answer_find1").val(),$("#question_answer_replace1").val(),$("#question_statement").html());
	});

	$("#difficulty").html("<p>Select Your Quest:</p>");
	setScoreboard();
	for (var quest in quests) {
		var completed = "";
		var progress = 0;
		var total_questions = quests[quest].questions.length;
		console.log("testing "+quest); 
		if (typeof(questStatus[quest]) != "undefined") {
			if (questStatus[quest].completed == 1) {
				completed = " (Completed)";
			}
			progress = questStatus[quest].current_question + 1;
			console.log("progress "+progress+" total questions: "+total_questions);

		}
		var percent_completed = parseInt((progress/total_questions)*100)+"%";
		var qClass = (completed == "") ? "class='quest quest_title'" : "class='completed quest_title'";
		$("#difficulty").append("<div "+qClass+" type='"+quest+"'>"+quests[quest].name+completed+" "+percent_completed+"</div>");
	}
	
	$(".quest").click(function() {
		difficulty = $(this).attr("type");
		$("#question").css("display","block");
		$("#difficulty").css("display","none");
		question_number = 0;
		if (typeof(questStatus[difficulty]) != "undefined") {
			question_number = questStatus[difficulty].current_question+1;
			console.log("setting question number to "+question_number);

		}
		//alert("You have selected Easy difficulty");
		setUpQuestion();
		setScoreboard();
	});
	$("#difficulty_easy").click(function() {
		difficulty = "easy";
		$("#question").css("display","block");
		$("#difficulty").css("display","none");
		//alert("You have selected Easy difficulty");
		setUpQuestion();
		setScoreboard();
	});
	$("#difficulty_medium").click(function() {
		difficulty = "medium";
		$("#question").css("display","block");
		$("#difficulty").css("display","none");
		//alert("You have selected Medium difficulty");
		setUpQuestion();
		setScoreboard();
	});
	$("#difficulty_insane").click(function() {
		difficulty = "insane";
		$("#question").css("display","block");
		$("#difficulty").css("display","none");
		//alert("You have selected Insane difficulty");
		setUpQuestion();
		setScoreboard();
	});
	$("#question_answer1_button").click(function() {
		var startString = $("#question_statement").html();
		var results = startString.match($("#question_answer1").val());
		console.log(results);
		
	});
});

function setScoreboard() {
	$("#stats_problems_solved").html(problems_solved);
	$("#stats_points").html(points);
	$("#stats_title").html(title);
}

function setUpQuestion() {
	var prob = quests[difficulty].questions[question_number];
	$("#question_answer_find1").val("");
	$("#question_answer_find2").val("");
	$("#question_answer1_response").html("");
	$("#question_answer2_response").html("");
	$("#question_answer_replace1").val("");
	$("#question_answer_replace2").val("");
	$("#question_answer1_div").css("display","block");

	$("#feedback").html("");
	if (prob.options == 2) {
		$("#question_answer2_div").css("display","block");
	} else {
		$("#question_answer2_div").css("display","none");
	}
	if (prob.type == 'replace') {
		$(".replace").css("display","block");
	} else {
		$(".replace").css("display","none");
	}
	$("#question_hint").html(prob.hint);
	$("#question_statement").html(prob.description);
	$("#next_question_button").css("display","none");
	if ((prob.description=="") && (prob.answer =="")) {
		alert("Congratulations!  You completed the quest.");
		$.ajax({
			url: "datapass.php",
			data: {quest_completed: difficulty}
			});
	}	
}

function loadNextQuestion() {
	question_number++;
	setUpQuestion();
}

function runQuery(find, replace, str) {
	$.ajax({
		url: "regex.php",
		data: {find: find, replace: replace, string: str}
	}).done(function(data) {
		parseQuestion(data);
	});
}

function parseQuestion(data) {
	//alert("The response was: " + data);
	$("#question_answer1_response").html(data);
	if (quests[difficulty].questions[question_number].answer==data) {
		$("#feedback").html("You were correct!");
		$("#next_question_button").css("display","block");
		if (quests[difficulty].questions[question_number].answered == 0) {
			quests[difficulty].questions[question_number].answered = 1;
			problems_solved++;
			points += 100;
		$.ajax({
			url: "datapass.php",
			data: {quest: difficulty, question_passed: question_number, points:100}
			});
			setScoreboard();
		}
	} else {
		$("#feedback").html("Your regex magic was not quite enough");
	}
}






var quests = {
	tutorial: {
		name:'Tutorial - Learn how to play Regex Quest and the basics of Regular Expressions',
		questions: [
		{	
			options:1, type: 'find', answered:0,
			hint:"Regular Expressions are a powerful way to both search and replace a string.  They must start and end with a delimiter - for this game (and in most cases) we will use /.  Lets start very simple.  Find 'dog' in the sentence below.  You can do so by typing: /dog/",
			description:"The quick brown fox has jumped over the lazy dog",
			answer:"dog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Regular expressions are case sensitive, so capital letters make a difference.  Try to find the dog this time.",
			description:"The quick brown fox has jumped over the lazy Dog",
			answer:"Dog"
		},	
		{
			options:1, type: 'find', answered:0,
			hint:"You can tell your regular expression to be case insensitive (ignore case) by adding <i>i</i> to the end of the statement.  Try: /dog/i",
			description:"The quick brown fox has jumped over the lazy Dog",
			answer:"Dog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Regular expressions will match the first instance of the string, and then stop.  You can tell it to match all by adding <i>g</i> to the end.  Try to find all the dogs.",
			description:"dog dog cat mouse dog bird cow dog",
			answer:"dog dog dog dog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"You can combine the use of <i>g</i> and <i>i</i> at the end to do a <i>g</i>lobal and case-<i>i</i>nsensitive search.  Find all the dogs this time",
			description:"dog Dog cat mouse Dog bird cow dog",
			answer:"dog Dog Dog dog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Regular expressions also let you group items.  You do that using the [ and ] characters.  Anything between them are treated as <b>1</b> character.  To find the hog, dog, and log try: /[hdl]og/g",
			description:"I went to the farm and saw a hog, dog, cat, and log",
			answer:"hog dog log"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"characters in [ and ] can also use ranges.  For example a-z, 0-9.  Find all the 3 letter words ending in 'og' below:",
			description:"hog cat dog rabbit bog fog jog",
			answer:"hog dog bog fog jog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Regular expressions have tons of special characters - such as [ and ], so if you wish to search for them you need to <i>escape</i> them by adding a \ in front of them.  Find all of the ['s",
			description:"!@#${[]$#!@^%$#[$%#@$[))#",
			answer:"[ [ ["
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Sometimes, you only know what you don't want.  That is where the ^ comes in.  It means <i>not</i> something.  To find all the *og words that aren't dog, try /[^d]og/gi",
			description:"hog dog bog fog jog",
			answer:"hog bog fog jog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"What about finding the \\ character?  Well, same rules apply, simply <i>escape</i> it:  \\\\.  Try to find all the slashes:",
			description:"\\\\home\\is\\where\\the\\heart\\is",
			answer:"\\ \\ \\ \\ \\ \\ \\"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"There are a few special searching that Regular Expressions can do: \\d, \\w, and \\s which match digits (numbers), words (groups of letters), and whitespace (spaces, tabs, line breaks).  Try to find the phone number below using \\d",
			description:"My friend Jenny's number is 867-5309 but I don't know her area code",
			answer:"8 6 7 5 3 0 9"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"So far, our expressions have been frugal, but regular expressions can also be <i>greedy</i>.  This is done using the * character. * matches any number of matches.  To find all words that end in 'og' (not just three letter words) try: [a-zA-Z]*og",
			description:"bog log frog grog puppy duck pog",
			answer:"bog log frog grog pog"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Lets say you want to get REALLY greedy and match everything.  The '.' is used to match any character.  Use /go:.*/ to match everything after go:",
			description:"Are you ready to go: Yes I am!",
			answer:"go: Yes I am!"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"The | (pipe) character represents the logical <i>or</i> operator and lets you search for this <i>or</i> that.  Try /answer(ing|ed|s)/g to match all versions of the word answer.  We are also using () instead of [] because we want to match all of the pattern.",
			description:"I was thinking of the next answer while answering the first question.  Finally, I answered them all.  How many answers are there?",
			answer:"answering answered answers"
		},
		{
			options:1, type: 'replace', answered:0,
			hint:"Finding things is great, but the power is in replacement.  Lets say you misspelled receive as 'recieve'.  Use /recieve/ as your search and 'receive' (no quotes).",
			description:"I waited to recieve my package.",
			answer:"I waited to receive my package."
		},
		{
			options:1, type: 'replace', answered:0,
			hint:"The previous question could be done with a simple find/replace, but lets say you've misspelled receive a bunch of ways.  Try /rec(ie|ee)ve/ as your search and 'receive' as your replace.  Again, we use ( and ) to match multiple characters.",
			description:"To receeve is good, to give is better.  But, I always like to recieve.",
			answer:"To receive is good, to give is better.  But, I always like to receive."
		},
		{
			options:1, type: 'replace', answered:0,
			hint:"Regular expressions also give you the ability to re-arrange your searches.  This is done using ( and ).  They are used like [ and ] and can be used in conjunction with [ and ].  In the replace, you can use $1, $2, ... $n as your ( and ) groups.  Try: /([\\w]*) ([\\w]*)/ and replace: '$2 $1' ",
			description:"Jumbo Shrimp",
			answer:"Shrimp Jumbo"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Regular expressions also allow you to define a character, or subset, to be optional.  This is done using the '?'.  Anything directly before a '?' is optional.  Try to find all instances of answer",
			description:"I was thinking of the next answer while answering the first question.  Finally, I answered them all.  How many answers are there?",
			answer:"answer answering answered answers"
		},
		{
			options:1, type: 'replace', answered:0,
			hint:"You can also specify how many times to loop.  This is done using {#}.  If you easily want to add commas (or periods) to a long string of numbers, try: /(\\d{3})/ replace: $1,",
			description:"123456789",
			answer:"123,456,789,"
		},
		{
			options:1, type: 'find', answered:0,
			hint:"Congrats, you have completed the Regex Quest tutorial.  But there is more to learn and more quests to complete!",
			description:"",
			answer:""
		}

		]
	}
}
//{hint:"",description:"",options:1, answer:""},	