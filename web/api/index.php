<?php
require_once(__DIR__ . "/../../config.php");
require_once("BingMe.class.php");

$bingMe = new BingMe(DATA_FILE);

foreach($_GET as $key => $value){
	$$key = $value;
}

$response = (isset($response)) ? $response : "jsonp" ;
$request = (isset($request)) ? $request : null ;
$categories = (isset($categories)) ? $categories : null ;
$content = null;

switch($request){
	case "categories":
		$content = $bingMe->keys;
		break;
	case "words":
		$content = $bingMe->words;
		break;
	case "responsetypes":
		$content = array('jsonp', 'json', 'javascript');
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

		$content = $bingMe->generate( ($bings * 1) );

		break;
}

if(!headers_sent()){
	$prefix  = '';
	$postfix = '';

	switch($response){
		case "javascript":
			header("Content-type: text/javascript");
			$prefix = ";var BingMe = ";
			$postfix = ";";
			break;
		case "json":
			header("Content-type: application/json");
			break;
		case "jsonp":
		default:
			header("Content-type: text/javascript");
			$prefix = ";callback(";
			$postfix = ");";
	}

	echo $prefix . json_encode($content) . $postfix;
}
