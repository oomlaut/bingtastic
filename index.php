<?php
$filename = "wordlist.csv";
if(file_exists($filename)){
	$words = explode("\n", file_get_contents($filename, true));
	$possibilities = count($words);
}

$bings = (isset($_GET["bings"])) ? $_GET["bings"] : 30 ;
$min = (isset($_GET["min"])) ? $_GET["min"] : 5 ;
$max = (isset($_GET["max"])) ? $_GET["max"] : 15 ;
$prefix = "http://www.bing.com/search?setmkt=en-US&q=";

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>it's bingtastic!</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

<!--        <link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
		<script src="js/vendor/modernizr-2.6.2.min.js"></script>
		-->
		<style type="text/css">
			#phrase-heading{
				margin:1em 0 .5em;
			}
			#phrase-heading:hover{
				cursor:pointer;
				text-decoration:underline;
			}
			#phraselist a{
				display:inline-block;
				padding:.25em .5em;
				margin-left:.25em;
				margin-bottom:.25em;
				border:1px solid #efefef;
				text-decoration:none;
			}
			#phraselist a:hover{
				background-color:#efefef;
			}
			#phraselist a.visited{
				border-color:hsl(0,75%, 50%);
				backround-color:hsl(0,75%,85%);
			}
		</style>
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<form action="/" method="get">
			<fieldset>
				<p><label for="bings">Bings:</label><input name="bings" id="bings" type="number" value="<?php echo $bings; ?>" title="Number of Bings to perform" required autofocus> <button id="update" type="submit">update</button></p>
				<p><label for="min">Minimum Delay:</label><input name="min" id="min" type="number" value="<?php echo $min; ?>" title="minimum delay" required></p>
				<p><label for="max">Maximum Delay:</label><input name="max" id="max" type="number" value="<?php echo $max; ?>" title="maximum delay" required></p>
				<p><button id="bingMe" type="button">bingMe</button> <button id="stop" type="button">stop</button></p>
			</fieldset>
		</form>

		<p id="timer"></p>

		<h3 id="phrase-heading">Phraselist</h3>
		<section id="phraselist">
		<?php
			$counter = 0;
			while($counter < $bings){
				$counter += 1;
				$phrase = "";
				for ($i = 0; $i <= rand(1,6); $i++){
					if($i != 0){ $phrase .= "+"; }
					$phrase .= str_replace(array("\n", "\r"), '', $words[rand(0, $possibilities - 1)])	;
				}
				?>
				<a href="<?php echo $prefix.$phrase; ?>" data-index="<?php echo $counter; ?>"><?php echo preg_replace('/\+/', ' ', $phrase); ?></a>
				<?
			}
		?>
		</section

		<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script>window.jQuery || document.write('<script src="bower_components/jquery/jquery.min.js"><\/script>')</script>

		<script>
			(function($){
				"use strict";

				var $phraselist = $("#phraselist").hide();
				$("#phrase-heading").on("click", function(){
					if($phraselist.hasClass("active")){
						$phraselist.removeClass("active").slideUp();
					} else {
						$phraselist.addClass("active").slideDown();
					}
				});

				$(window).on("load", function(){
					var timer;
					var $timer = $("#timer").hide();
					var $bings = $("a", $phraselist);
					var $count = $("#bings");
					var $minTime = $("#min");
					var $maxTime = $("#max");

					// var status;
					// var $status = $("<div>", {
					//  id: "status"
					// }).bind("reset", function(){
					//  $(this).css({width: 0});
					//  window.clearInterval(status);
					// }).on("update", function(e, float){
					//  // console.log(float);
					//  float = float * 100;
					//  $(this).css({width: float + "%"});
					// }).hide().appendTo("body");

					function getRandom(int){
						return Math.ceil((Math.random() * int));
					}

					function getInt(str){
						return parseInt(str, 10) * 1;
					}

					function bingMe() {
						var count = getInt($count.val()) - 1;
						//refactor
						// window.clearInterval(status);
						// var progress = 0;
						// status = window.setInterval(function(){
						//  progress = progress + 50;
						//  $status.trigger("update", progress/time);
						// }, 50);


						window.open($bings.eq(count).addClass("visited").attr("href"), "_newtab");

						$count.val(count);

						if(count === 0){
							$timer.text("all done.");
							$stop.trigger("click");
						} else {
							var min = getInt($minTime.val());
							var max = getInt($maxTime.val());
							var seconds = ( getRandom(max - min)  + min );
							var time = ( seconds * 1000 );

							$timer.text(seconds + " seconds until the next Bing...");
							timer = window.setTimeout(bingMe, time);
						}
					}

					var $start = $("#bingMe").on("click", function(e){
						e.preventDefault();
						// $status.show();
						$timer.show();
						$(this).add('input[type="number"], #update').attr({disabled: "disabled"});
						bingMe();
					});

					var $stop = $("#stop").on("click", function(e){
						e.preventDefault();
						window.clearTimeout(timer);
						// $status.trigger("reset").hide();
						$timer.hide();
						$start.add('input[disabled], #update').removeAttr('disabled');
					});
				});
			})(jQuery);
		</script>
	</body>
</html>

