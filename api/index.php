<?php

/** API Functions
 */

header("Content-type: application/json");

require_once("../library/BingMe.class.php");

$bingMe = new BingMe;
$bingMe->dataSource("../data/wordlist.csv");

foreach($_GET as $key => $value){
	$$key = $value;
}

$request = (isset($request)) ? $request : null ;
$categories = (isset($categories)) ? $categories : null ;
$response = null;


switch($request){
	case "categories":
		$response = $bingMe->keys;
		break;
	case "words":
		$response = $bingMe->words;
		break;
	case "default":
	default:

		$bings = (isset($bings) && $bings >= 0) ? $bings : 30;

		$minwords = (isset($minwords)) ? $minwords * 1 : 2;
		$maxwords = (isset($maxwords)) ? $maxwords * 1 : 4;
		if($minwords ==0 || $maxwords == 0 || $minwords > $maxwords){
			break;
		}
		$bingMe->setWordRange($minwords,$maxwords);

		if(!is_null($categories) && $categories != "all"){
			$bingMe->setPrefixKeys(explode(",", $categories));
		}

		$response = $bingMe->generate( ($bings * 1) );

		if($bings == 1){
			$response = $response[0];
		}

		break;
}

echo json_encode($response);
