<?php

header("Content-type:text/javascript");
$filename = "wordlist.csv";

?>
"use strict";
var app = app || {};
app.words = [<?php

if(file_exists($filename)){
	$words = explode("\n", file_get_contents($filename, true));
	foreach ($words as $index => $word){
		if ($index != 0 ){
			echo ",";
		}
		$word = str_replace(array("\n", "\r"), '', $word);
		echo "\"$word\"";
	}
}
?>];
