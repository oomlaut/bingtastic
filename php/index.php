<?php
require_once("config.php");
require_once("BingMe.class.php");

$bingMe = new BingMe;
$bingMe->dataSource(PATH . "/data/wordlist.csv");
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

		<title>it's bingtastic!</title>
		<meta name="description" content="">

		<link rel="author" href="/humans.txt">
		<link rel="sitemap" href="/sitemap.xml">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/icons/favicon.png">
		<link rel="apple-touch-icon" href="/icons/57.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/icons/72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/icons/114.png">
		<link rel="stylesheet" href="/styles/main.css">

		<!-- highlight.js syntax highlighting -->
		<script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
	</head>
	<body class="container">
		<div id="fb-root"></div>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<header class="row hgroup">
			<h1 class="span8">bingtastic!</h1>
			<div id="login" class="span3"></div>
		</header>

		<section class="row">

			<form id="automate" action="/#automate" method="get" class="form-horizontal span5 row">
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


				<h3 id="phrase-heading" class="heading toggle-control">Phraselist (<?php echo $bings; ?>)</h3>
				<div id="phraselist" class="toggle">
				<?php
					$counter = 0;
					while($counter < $bings){
						$counter += 1;
						echo $bingMe->parse('<a href="{{url}}" target="_blank">{{text}}</a>');
					}
				  ?>
				</div>
			</form>

			<div class="span6 offset1">
				<h2>Get Rewarded for &ldquo;Using&rdquo; <a href="http://go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5">bing</a></h2>
				<p><a href="http://go.microsoft.com/?linkid=9778718&rrid=_ad8ea4a6-b009-6b60-1c54-667a72de00e5">Sign up</a> and start earning points that you can turn into contest entries, Amazon or Starbucks gift cards, Hulu Plus subscription, or Redbox rentals. </p>

				<h3>&ldquo;But, I Like <abbr title='Does it rhyme with "Moogle"?'>[Other Search Engine]</abbr> Better&hellip;&rdquo;</abbr></h3>
				<p>That&rsquo;s where <em>bingtastic</em> comes in. Make sure you are logged in to Facebook, then use the fields provided to automate your bing queries.</p>
				<p>We&rsquo;ll generate as many <?php echo $bingMe->minwords; ?>-<?php echo $bingMe->maxwords; ?> word phrases as you need, then open up a new tab next door to help you get those precious, precious points.</p>

				<h3>Search Daily</h3>
				<p>Earn from 15 to more than 30 points every day and <a href="http://www.bing.com/rewards/redeem/all">redeem them for one of many great offers</a>, or even donate them to a charity.</p>

			</div>

		</section>

		<section class="row api">
			<div class="span12">
				<h2><abbr title="Application Programming Interface">API</abbr></h2>
				<p>We have exposed a data endpoint for using the functions that were created for automating these bing searches. Feel free to use this site to generate <b>your</b> bings, too!</p>

				<h3>usage</h3>
				<p>A sample of how to use <a href="http://stackoverflow.com/questions/2067472/what-is-jsonp-all-about">jsonp</a>:</p>
<pre>
<code class="html">
    &lt;script&gt;
        'use strict';
        BingMe = function(data){
            /* &hellip; do something with the data returned &hellip; */
        };
    &lt;/script&gt;

    &lt;script src="//bingtastic.projects.paulgueller.com/api/?bings=60&amp;categories=images,videos"&gt;&lt;/script&gt;
</code>
</pre>
				<p>Or use <a href="http://api.jquery.com/jQuery.ajax/">jQuery.ajax()</a>.</p>
				<div class="hgroup row">
					<h3 class="span2">parameters</h3>
					<div class="hidden-phone">
						<p class="span1">returns</p>
						<p class="span2">value</p>
						<p class="span1">default</p>
						<p class="span3">description</p>
						<p class="span3">example</p>
					</div>
				</div>

				<dl class="row">

					<dt class="span2">request</dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1">object</div>
							<div class="span2">"default" or <i>null</i></div>
							<div class="span1"></div>
							<div class="span3">Generates a jsonp response for a BingMe function evaluation, using the defaults below unless otherwise provided.</div>
							<div class="span3"><a href="/api/" target="_blank">/api/</a></div>
						</div>
					</dd>

					<dd class="row span10 offset2">
						<div class="row">
							<div class="span1">array</div>
							<div class="span2">"categories"</div>
							<div class="span1"></div>
							<div class="span3">Retrieves a list of available categories.</div>
							<div class="span3"><a href="/api/?request=categories" target="_blank">/api/?request=categories</a></div>
						</div>
					</dd>

					<dd class="row span10 offset2">
						<div class="row">
							<div class="span1">array</div>
							<div class="span2">"words"</div>
							<div class="span1"></div>
							<div class="span3">Retrieve the full list of potential words that the service has to choose from.</div>
							<div class="span3"><a href="/api/?request=words" target="_blank">/api/?request=words</a></div>
						</div>
					</dd>

					<dt class="span2">bings</dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1">object</div>
							<div class="span2">integer</div>
							<div class="span1"><?php echo $bingMe->q; ?></div>
							<div class="span3">Provide the service with the number of nodes on the object to generate. Only applies to request type: default.</div>
							<div class="span3"><a href="/api/?bings=60" target="_blank">/api/?bings=60</a></div>
						</div>
					</dd>

					<dt class="span2">minwords</dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1">object</div>
							<div class="span2">integer</div>
							<div class="span1"><?php echo $bingMe->minwords; ?></div>
							<div class="span3">Specify the minimum number of words in any given phrase. Minimum: 1</div>
							<div class="span3"><a href="/api/?minwords=1" target="_blank">/api/?minwords=1</a></div>
						</div>
					</dd>

					<dt class="span2">maxwords</dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1">object</div>
							<div class="span2">integer</span></div>
							<div class="span1"><?php echo $bingMe->maxwords; ?></div>
							<div class="span3">Specify the maximum number of words in any given phrase. Must be greater than ?minwords</div>
							<div class="span3"><a href="/api/?maxwords=6" target="_blank">/api/?maxwords=6</a></div>
						</div>
					</dd>

					<dt class="span2">categories</dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1">object</div>
							<div class="span2">comma-separated strings</div>
							<div class="span1">all</div>
							<div class="span3">
								Generate prefixes only from categories provided. Options include:
								<span class="argument">all</span>
								<?php
									foreach($bingMe->keys as $key){
										echo "<span class=\"argument\">$key</span>";
									}
								?>
							</div>
							<div class="span3"><a href="/api/?categories=images,videos" target="_blank">/api/?categories=images,videos</a></div>
						</div>
					</dd>

					<dt class="span2">response</dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1">array</div>
							<div class="span2">string</div>
							<div class="span1">jsonp</div>
							<div class="span3">Tell the service which format you would like to receive your data in:
								<span class="argument default">jsonp</span>
								<span class="argument">javascript</span>
								<span class="argument">json</span>
							</div>
							<div class="span3"><a href="/api/?response=javascript" target="_blank">/api/?response=javascript</a></div>
						</div>
					</dd>
				</ul>
			</div>
		</section>

		<footer class="row">
			<p class="span12 text-right"><a href="http://creativecommons.org/licenses/by-nc-sa/3.0" class="pull-right"><img src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" alt="Attribution-NonCommercial-ShareAlike" title="CC BY-NC-SA"></a></small></p>
		</footer>

		<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script>window.jQuery || document.write('<script src="packages/jquery/jquery.min.js"><\/script>')</script>

		<!--
		<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<script>window.jQuery || document.write('<script src="scripts/jquery-validate.min.js"><\/script>')</script>
		-->

		<script src="scripts/main.min.js"></script>

	</body>
</html>

