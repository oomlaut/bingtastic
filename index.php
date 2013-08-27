<?php

require_once("library/BingMe.class.php");

$bingMe = new BingMe("data/wordlist.csv");
$bingMe->setWordRange(2,4);

$bings = (isset($_GET["bings"]) && $_GET["bings"] > 0) ? $_GET["bings"] : 30

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
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="robots" content="noindex, nofollow">
		<link rel="author" href="humans.txt">
		<link rel="sitemap" href="sitemap.xml">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="icon" href="/icons/favicon.png">
		<link rel="apple-touch-icon" href="/icons/57.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/icons/72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/icons/114.png">
		<link rel="stylesheet" href="styles/main.css">
	</head>
	<body class="container">
		<div id="fb-root"></div>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->

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
				<p>We&rsquo;ll generate as many <?php echo $bingMe->minwords; ?>-<?php echo $bingMe->maxwords; ?> word phrases as you need, then open up a new tab next door to help you get those precious, precious points.</p>

				<h3>Search Daily</h3>
				<p>Earn from 15 to more than 30 points every day and <a href="http://www.bing.com/rewards/redeem/all">redeem them for one of many great offers</a>, or even donate them to a charity.</p>
			</div>

			<form id="automate" action="/#automate" method="get" class="form-horizontal span5 offset1 row">
				<h2 class="heading">Automate Searches</h2>
				<fieldset id="form-controls">
					<div class="control-group">
						<label for="bings" class="control-label" >Bings:</label>
						<div class="controls">
							<input name="bings" id="bings" class="input-mini" type="number" step="1" min="" data-default="<?php echo $bings; ?>" value="<?php echo $bings; ?>" title="Number of Bings to perform" data-require-redraw="true" required autofocus>
						</div>
					</div>

					<p class="heading toggle-control">Change delay interval</p>
					<div id="intervals" class="toggle">
						<div class="control-group">
							<label for="delay" class="control-label" >Delay:</label>
							<div class="controls">
								<div class="input-append">
									<input id="delay" class="input-mini" type="text" data-min="1" data-max="30" value="5 - 15" title="minimum delay" required readonly>
									<span class="add-on">seconds</span>
								</div>
							</div>
							<div class="controls">
								<div id="slider-range"></div>
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset id="modified" class="control-group">
					<div class="controls">
						<button id="update" class="btn btn-success btn-large" type="submit">update</button>
						<button id="reset" class="btn btn-danger btn-large" type="reset">reset</button>
					</div>
				</fieldset>

				<fieldset id="standard" class="control-group">
					<div class="controls">
						<button id="bingMe" class="btn btn-large btn-primary" type="button">bing me!</button>
						<button id="stop" class="btn btn-large" type="button">stop</button>
					</div>
				</fieldset>
			</form>

		</section>

		<section class="row">
			<h3 id="phrase-heading" class="span12 toggle-control">Phraselist (<?php echo $bings; ?>)</h3>
			<div id="phraselist" class="span12 toggle">
			<?php
				$counter = 0;
				while($counter < $bings){
					$counter += 1;
					echo $bingMe->parse('<a href="@link" target="_blank">@text</a>');
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

