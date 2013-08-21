<?php
$filename = "wordlist.csv";
if(file_exists($filename)){
	$words = explode("\n", file_get_contents($filename, true));
	$possibilities = count($words);
} else {
	die("$filename does not exist.");
}

$bings = (isset($_GET["bings"])) ? $_GET["bings"] : 30 ;
$min = (isset($_GET["min"])) ? $_GET["min"] : 5 ;
$max = (isset($_GET["max"])) ? $_GET["max"] : 15 ;
$minwords = 2;
$maxwords = 4;
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
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="robots" content="noindex, nofollow">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="icon" href="/icons/favicon.png" />
		<link rel="apple-touch-icon" href="/icons/57.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="/icons/72.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="/icons/114.png" />
		<link rel="stylesheet" href="styles/main.css">
	</head>
	<body class="container">
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<div id="fb-root"></div>
		<hgroup class="row">
			<h1 class="span8">bingtastic!</h1>
			<div id="login" class="span3"></div>
		</hgroup>
		<section class="row">

		<div class="span6">
			<h2>Get Rewarded for &ldquo;Using&rdquo; <a href="http://go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5">bing</a></h2>
			<p><a href="http://go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5">Sign up</a> and start earning points that you can turn into contest entries, Amazon or Starbucks gift cards, Hulu Plus subscription, or Redbox rentals. </p>
			<h3>&ldquo;But, I Like <abbr title='Does it rhyme with "Moogle"?'>[Other Search Engine]</abbr> Better&hellip;&rdquo;</abbr></h3>
			<p>That&rsquo;s where <em>bingtastic</em> comes in. Make sure you are logged in to Facebook, then use the fields provided to automate your bing queries.</p>
			<p>We&rsquo;ll generate as many <?php echo $minwords; ?>-<?php echo $maxwords; ?> word phrases as you need, then open up a new tab next door to help you get those precious, precious points.</p>
			<h3>Search Daily</h3>
			<p>Earn from 15 to more than 30 points every day and <a href="http://www.bing.com/rewards/redeem/all">redeem them for one of many great offers</a>, or even donate them to a charity.</p>
		</div>

		<form action="/" method="get" class="form-horizontal span5 offset1 row">
			<h2>Automate Searches</h2>
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

			<div id="timer" >
				<div id="statusbar" class="ui-progressbar"><div class="progress-label"></div></div>
			</div>
		</form>

		</section>

		<section class="row">
			<h3 id="phrase-heading" class="span12">Phraselist (<?php echo $bings; ?>)</h3>
			<div id="phraselist" class="span12">
			<?php
				$counter = 0;
				while($counter < $bings){
					$counter += 1;
					$phrase = "";
					for ($i = 0; $i < rand($minwords,$maxwords); $i++){
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

		<!--
		<script>window.jQuery || document.write('<script src="scripts/jquery-validate.min.js"><\/script>')</script>
		-->

		<script src="scripts/main.min.js"></script>

		<script>
		</script>
	</body>
</html>

