<?php

require_once('../vendor/autoload.php');

require_once(__DIR__ . "/../config.php");
require_once("BingMe.class.php");

$bingMe = new BingMe(DATA_FILE);
$bingMe->setWordRange(2,4);

$bings = (isset($_GET["bings"]) && $_GET["bings"] > 0) ? $_GET["bings"] : $bingMe->q;


function version($urlString, $release = '4.1.12'){
	$separator = (strpos($urlString, '?')) ? '&' : '?';
	echo $urlString . $separator . 'v=' . $release;
	return false;
}

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

		<link rel="author" href="<?php version('/humans.txt'); ?>">
		<link rel="sitemap" href="<?php version('/sitemap.xml'); ?>">
		<link rel="icon" href="<?php version('/favicon.ico'); ?>" type="image/x-icon">
		<link rel="icon" href="<?php version('/icons/favicon.png'); ?>">
		<link rel="apple-touch-icon" href="<?php version('/icons/57.png'); ?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php version('/icons/72.png'); ?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php version('/icons/114.png'); ?>">
		<link rel="stylesheet" href="<?php version('/styles/main.min.css'); ?>">

		<!-- facebook opengraph -->
		<meta name="og:type" content="website">
		<meta name="og:url" content="http://bingtastic.herokuapp.com">
		<meta name="og:site_name" content="it's bingtastic!">
		<meta name="og:title" content="Bingtastic Helps Earn Rewards">
		<meta name="og:description" content="Use Bing Rewards search and earn points redeemable for popular gift cards, Hulu+ subscriptions or sweepstakes entries!">
		<meta name="og:image" content="http://bingtastic.herokuapp.com/icons/fb.png">
	</head>

	<body>
		<div id="fb-root"></div>

		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->

		<noscript>
			<p>JavaScript is required to perform the services that bingtastic provides.</p>
		</noscript>

		<div id="container">

			<header class="hgroup">
				<h1 class="h1"><span class="their-name">bing</span>tastic!</h1>
				<div id="standard" class="control-group">
					<div class="btn-row controls">
						<button id="bingMe" class="btn btn-lg btn-primary" type="button">bing me!</button>
						<button id="stop" class="btn btn-lg btn-default" type="button">stop</button>
						<?php  /* label id="lbl-mobile" class="lbl checkbox" for="mobile-friendly"><input id="mobile-friendly" type="checkbox" name="mobile-friendly" class="cbx input" value="1" autosave="1" /> Mobile friendly</label */ ?>
					</div>
				</div>
			</header>

			<article id="pane">

				<section id="hs1" class="hotspot">
					<div class="content">
						<h3 class="h3">Get rewarded for &ldquo;using&rdquo; <a class="their-name" href="//go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5" rel="external">bing</a></h3>
						<p><a href="//go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5" rel="external">Sign up</a> and start earning points with every search that you can turn into contest entries, Amazon or Starbucks gift cards, Hulu Plus subscription, or Redbox rentals. </p>

						<h4>&ldquo;But, I like <abbr title='Does it rhyme with "Moogle"?'>[other search engine]</abbr> better&hellip;&rdquo;</abbr></h4>
						<p>That&rsquo;s where this service comes in. Make sure you are logged in to Facebook or MSN/Hotmail, then use the fields provided to automate your <span class="their-name">bing</span> queries.</p>
						<p>We&rsquo;ll generate as many <?php echo $bingMe->minwords; ?>-<?php echo $bingMe->maxwords; ?> word phrases as you need, then open up a new tab next door to help you get those precious, precious points.</p>
					</div>
					<i class="icon"></i>
				</section>

				<section id="hs2" class="hotspot">
					<div class="content">
						<h4>Search daily</h4>
						<p>Earn from 15 to more than 30 points every day and <a href="//www.bing.com/rewards/redeem/all" rel="external">redeem them for one of many great offers</a>, or even donate them to a charity.</p>
					</div>
					<i class="icon"></i>
				</section>

				<section id="hs3" class="hotspot">
					<div class="content">
						<h4>Spread the word </h4>
						<p>Help others earn free rewards too! Share or recommend this site if you find it valuable.</p>
						<div class="fb-like" data-href="http://bingtastic.herokuapp.com/" data-layout="standard" data-action="recommend" data-show-faces="true" data-share="true" data-width="280"></div>
					</div>
					<i class="icon"></i>
				</section>

				<section id="hs4" class="hotspot">
					<div class="content">
						<h4><abbr title="Application Programming Interface">API</abbr></h4>
						<p>We have exposed a data endpoint for using the functions that were created for automating these searches. Feel free to use this site to generate <b>your</b> <span class="their-name">bing</span>s, too!</p>
						<p>Documentation provided on <a href="http://docs.bingtastic.apiary.io/" rel="external">apiary.io</a></p>
					</div>
					<i class="icon"></i>
				</section>

			</article>

			<nav class="otb">
				<?php
				/*
					! Bing has removed facebook login functionality
					! TODO: Remove for next release.

					<div id="login"></div>
				*/
				?>
				<ul>
					<li><a href="#search-phrases" title="View or change the phrases to be searched"><i class="fa fa-plus-square-o"></i>Phraselist</a></li>
					<li><a href="#delay-interval" title="View or change the script interval"><i class="fa fa-plus-square-o"></i>Delay Interval</a></li>
					<li><a href="//www.bing.com/rewards/dashboard" title="Check the dashboard daily for Bing bonus points">Rewards Dashboard</a></li>
					<li><a href="//go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5" rel="external">Sign up for Bing Rewards</a></li>
				</ul>

			</nav>

			<footer class="otb">
				<?php /* <a href="//creativecommons.org/licenses/by-nc-sa/3.0" rel="external creative_commons" class="license"><img src="//i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" alt="Attribution-NonCommercial-ShareAlike" title="CC BY-NC-SA"></a> */ ?>
				<a href="//github.com/oomlaut/bingtastic" rel="external github" title="We're open source! Follow this project on GitHub"><i class="fa fa-github-square"></i></a>
				<?php /* <a href="//apps.facebook.com/1404888123068033/" rel="external facebook" class="btn fb-btn btn-primary"><i class="fa fa-facebook-square"></i> Bingtastic Facebook App</a> */ ?>
			</footer>

			<form id="overlay" role="form" action="/#postback" method="get">

				<fieldset id="search-phrases" class="form-panel">
					<h4 class="group-label h4 heading">Phraselist</h4>

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
								echo $bingMe->parse('<a href="{{url}}">{{text}}</a>');
							}
						?>
					</div>
				</fieldset>

				<fieldset id="delay-interval" class="form-panel">

					<h4 class="group-label h4 heading">Delay Interval</h4>

					<div id="intervals" class="control-group">
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

				<fieldset id="buttons" class="control-group">
					<div class="btn-row controls">
						<button id="update" class="btn btn-success" type="submit">update</button>
						<button id="reset" class="btn btn-danger" type="reset">reset</button>
					</div>
				</fieldset>

			</form>
		</div>

		<script src="<?php version('scripts/main.min.js'); ?>"></script>

	</body>
</html>
