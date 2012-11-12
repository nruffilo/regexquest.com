<?php
$pattern = $_GET['find'];
$replace = $_GET['replace'];
$string = $_GET['string'];
if ($replace == "") {
	$final = explode("/",$pattern);
	if (stripos($final[count($final)-1],"g") !== false) {
		$pattern = str_replace(array("/ig","/g"),array("/i","/"),$pattern);
		preg_match_all($pattern,$string, $matches);
		//echo implode("",$matches[1]);
		echo implode(" ",($matches[0]));
	} else {
		preg_match($pattern,$string, $matches);
		//var_dump($matches);
		echo $matches[0];
		//echo implode("",$matches[1]);
		//echo implode("",($matches[0]));
	}
} else {
	//echo "- $pattern - $replace - $string";
	$result = preg_replace($pattern,$replace,$string);
	echo $result;
}
?>