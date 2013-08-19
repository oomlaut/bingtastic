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
	<head lang="en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>it's bingtastic!</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="noindex, nofollow">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="stylesheet" href="styles/main.css">
	</head>
	<body class="container">
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<hgroup class="row">
			<h1 class="span11 offset1">it's bingtastic!</h1>
		</hgroup>
		<form action="/" method="get" class="form-horizontal row">
			<fieldset>
				<div class="control-group">
					<label for="bings" class="control-label" >Bings:</label>
					<div class="controls">
						<input name="bings" id="bings" class="input-mini" type="number" value="<?php echo $bings; ?>" title="Number of Bings to perform" required autofocus>
						<button id="update" class="btn btn-danger" type="submit">update</button>
					</div>
				</div>
				<div class="control-group">
					<label for="min" class="control-label" >Minimum Delay:</label>
					<div class="controls">
						<input name="min" id="min" class="input-mini" type="number" value="<?php echo $min; ?>" title="minimum delay" required>
					</div>
				</div>
				<div class="control-group">
					<label for="max" class="control-label" >Maximum Delay:</label>
					<div class="controls">
						<input name="max" id="max" class="input-mini" type="number" value="<?php echo $max; ?>" title="maximum delay" required>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button id="bingMe" class="btn btn-large btn-primary" type="button">bing me!</button>
						<button id="stop" class="btn btn-large" type="button">stop</button>
					</div>
				</div>
			</fieldset>
		</form>

		<section class="row">
			<p id="timer" class="span4 offset4"></p>
			<h3 id="phrase-heading" class="span11 offset1">Phraselist</h3>
			<div id="phraselist" class="span10 offset1">
			<?php
				$counter = 0;
				while($counter < $bings){
					$counter += 1;
					$phrase = "";
					for ($i = 0; $i <= rand(1,5); $i++){
						if($i != 0){ $phrase .= "+"; }
						$phrase .= str_replace(array("\n", "\r"), '', $words[rand(0, $possibilities - 1)])	;
					}
					?>
					<a href="<?php echo $prefix.$phrase; ?>" data-index="<?php echo $counter; ?>" target="_blank"><?php echo preg_replace('/\+/', ' ', $phrase); ?></a>
					<?
				}
			?>
			</div>
		</section>

		<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script>window.jQuery || document.write('<script src="packages/jquery/jquery.min.js"><\/script>')</script>

		<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

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

					$("#bings, #min, #max").on("change", function(){
						console.log($(this).val());
						if($(this).val() < 0 ){
							$(this).val(0);
						}
					});

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

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-1575455-10', 'paulgueller.com');
		  ga('send', 'pageview');

		</script>
	</body>
</html>

