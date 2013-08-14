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

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<link rel="stylesheet/less" type="text/css" href="packages/twitter/less/bootstrap.less" />
		<link rel="stylesheet/less" type="text/css" href="packages/twitter/less/responsive.less" />
		<script src="packages/twitter/assets/js/html5shiv.js"></script>
		<script src="packages/less/dist/less-1.4.2.min.js"></script>
		<style type="text/css">
			#phrase-heading{
				margin-top:1em;
				margin-bottom:.5em;
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
					<a href="<?php echo $prefix.$phrase; ?>" data-index="<?php echo $counter; ?>"><?php echo preg_replace('/\+/', ' ', $phrase); ?></a>
					<?
				}
			?>
			</div>
		</section>

		<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script>window.jQuery || document.write('<script src="packages/jquery/jquery.min.js"><\/script>')</script>

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

