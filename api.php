<?php

header("Content-type: application/json");

require_once("library/BingMe.class.php");

// define api functions
foreach($_GET as $key => $value){
	$$key = $value;
}

$bings = (isset($bings) && $bings > 0) ? $bings : 30;
$minwords = (isset($minwords) && $minwords > 0) ? $minwords : 2;
$maxwords = (isset($maxwords) && $maxwords > 0) ? $maxwords : 4;

$bingMe = new BingMe;
$bingMe->dataSource("data/wordlist.csv");
$bingMe->setWordRange($minwords,$maxwords);

echo json_encode($bingMe->generate($bings));
