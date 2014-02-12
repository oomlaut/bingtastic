<?php
require_once(__DIR__ . "/../config.php");
require_once("BingMe.class.php");

$bingMe = new BingMe;
$bingMe->dataSource(DATA_FILE);
$bingMe->setWordRange(2,4);

$bings = (isset($_GET["bings"]) && $_GET["bings"] > 0) ? $_GET["bings"] : $bingMe->q;

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head lang="en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="robots" content="noindex, nofollow">

		<title>it&rsquo;s bingtastic!</title>
		<meta name="description" content="Automation of daily searches to earn the maximum Bing Rewards points">

		<link rel="author" href="/humans.txt">
		<link rel="sitemap" href="/sitemap.xml">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/icons/favicon.png">
		<link rel="apple-touch-icon" href="/icons/57.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/icons/72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/icons/114.png">
		<link rel="stylesheet" href="/styles/main.css">
	</head>

	<body class="container">
		<div id="fb-root"></div>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<header class="row hgroup">
			<h1 class="col-sm-9"><span class="their-name">bing</span>tastic!</h1>
			<div id="login" class="col-sm-3 text-right"></div>
		</header>

		<section class="row">

			<form role="form" id="automate" action="/#automate" method="get" class="form-horizontal col-sm-6">
				<h2 class="heading">Automate Searches</h2>
				<fieldset id="search-phrases">
					<h4 id="phrase-heading" class="group-label toggle-control">Phraselist (<?php echo $bings; ?>)</h4>

					<div id="phraselist" class="toggle">

						<div class="control-group">
							<div class="controls input-group">
								<label for="bings" class="control-label input-group-addon"><span class="their-name">bing</span>s:</label>
								<input name="bings" id="bings" class="input-sm form-control" type="number" step="1" min="1" data-default="<?php echo $bings; ?>" value="<?php echo $bings; ?>" title="Number of Bings to perform" data-require-redraw="true" required autofocus>
							</div>
						</div>
						<div id="phrases">
							<?php
								$counter = 0;
								while($counter < $bings){
									$counter += 1;
									echo $bingMe->parse('<a href="{{url}}" target="_blank">{{text}}</a>');
								}
							?>
						</div>
					</div>
				</fieldset>

				<fieldset id="form-controls">

					<h4 class="group-label toggle-control">Delay interval</h4>

					<div id="intervals" class="control-group toggle">
						<div class="controls">
							<div id="slider-range"></div>
						</div>
						<div class="controls input-group">
							<label for="delay" class="control-label input-group-addon" >Delay:</label>
							<input id="delay" class="input-sm form-control" type="text" data-min="1" data-max="30" value="5 - 15" title="minimum delay" required readonly>
							<span class="input-group-addon">seconds</span>
						</div>
					</div>

				</fieldset>

				<fieldset id="modified" class="control-group">
					<div class="btn-row controls">
						<button id="update" class="btn btn-lg btn-success" type="button">update</button>
						<button id="reset" class="btn btn-lg btn-danger" type="reset">reset</button>
					</div>
				</fieldset>

				<fieldset id="standard" class="control-group">
					<div class="btn-row controls">
						<button id="bingMe" class="btn btn-lg btn-primary" type="button">bing me!</button>
						<button id="stop" class="btn btn-lg btn-default" type="button">stop</button>
					</div>
				</fieldset>

			</form>

			<div class="col-sm-6">
				<h3>Get Rewarded for &ldquo;Using&rdquo; <a class="their-name" href="//go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5" rel="external" target="_blank">bing</a></h3>
				<p><a href="//go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5" rel="external" target="_blank">Sign up</a> and start earning points that you can turn into contest entries, Amazon or Starbucks gift cards, Hulu Plus subscription, or Redbox rentals. </p>

				<h4>&ldquo;But, I Like <abbr title='Does it rhyme with "Moogle"?'>[Other Search Engine]</abbr> Better&hellip;&rdquo;</abbr></h4>
				<p>That&rsquo;s where this service comes in. Make sure you are logged in to Facebook or MSN/Hotmail, then use the fields provided to automate your <span class="their-name">bing</span> queries.</p>
				<p>We&rsquo;ll generate as many <?php echo $bingMe->minwords; ?>-<?php echo $bingMe->maxwords; ?> word phrases as you need, then open up a new tab next door to help you get those precious, precious points.</p>

				<h4>Search Daily</h4>
				<p>Earn from 15 to more than 30 points every day and <a href="//www.bing.com/rewards/redeem/all" rel="external" target="_blank">redeem them for one of many great offers</a>, or even donate them to a charity.</p>

				<h4><abbr title="Application Programming Interface">API</abbr></h4>
				<p>We have exposed a data endpoint for using the functions that were created for automating these searches. Feel free to use this site to generate <b>your</b> <span class="their-name">bing</span>s, too!</p>
				<p>Documentation provided on <a href="http://docs.bingtastic.apiary.io/" rel="external" target="_blank">apiary.io</a></p>

				<h4>We&rsquo;re Open Source</h4>
				<p><a href="https://github.com/oomlaut/bingtastic" rel="external" target="_blank"><i class="fa fa-github-square"></i> Follow this project on GitHub</a></p>
			</div>

		</section>

		<footer class="row">
			<p class="col-sm-12 text-right"><a href="//creativecommons.org/licenses/by-nc-sa/3.0" rel="external" target="_blank"><img src="//i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" alt="Attribution-NonCommercial-ShareAlike" title="CC BY-NC-SA"></a></small></p>
		</footer>

		<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
		<script>window.jQuery || document.write('<script src="packages/jquery/jquery.min.js"><\/script>')</script>

		<!--
		<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<script>window.jQuery || document.write('<script src="scripts/jquery-validate.min.js"><\/script>')</script>
		-->

		<script src="scripts/main.min.js"></script>

	</body>
</html>

