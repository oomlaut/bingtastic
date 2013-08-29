<?php ?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head lang="en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>api | it's bingtastic!</title>
		<meta name="description" content="">
		<?php include("includes/head.php"); ?>
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
			<div class="span12">
				<h2><abbr title="Application Programming Interface">api</abbr></h2>
				<p>Lorem ipsum.</p>
				<div class="hgroup row">
					<h3 class="span2">request types</h3>
					<div class="hidden-phone">
					<p class="span1">parameters</p>
					<p class="span2">accepts</p>
					<p class="span3">description</p>
					<p class="span1">returns</p>
					<p class="span3">example</p>
					</div>
				</div>


				<dl class="api row">

					<dt class="span2">categories</dt>
					<dd class="row span10">
						<div class="row">
							<p class="span1"><i>n/a</i></p>
							<p class="span2"><i>n/a</i></p>
							<p class="span3">retrieve list of available categories</p>
							<p class="span1"><code>array</code></p>
							<p class="span3"><a href="/api/?request=categories" target="_blank">/api/?request=categories</a></p>
						</div>
					</dd>

					<dt class="span2">word</dt>
					<dd class="row span10">
						<div class="row">
							<p class="span1"><i>n/a</i></p>
							<p class="span2"><i>n/a</i></p>
							<p class="span3">retrieve list of available categories</p>
							<p class="span1"><code>array</code></p>
							<p class="span3"><a href="/api/?request=words" target="_blank">/api/?request=words</a></p>
						</div>
					</dd>

					<dt class="span2"><em>default</em></dt>
					<dd class="row span10">
						<div class="row">
							<div class="span1"><i>null</i></div>
							<div class="span2"><i>n/a</i></div>
							<div class="span3">...</div>
							<div class="span1"><code>object</code> </div>
							<div class="span3"><a href="/api/" target="_blank">/api/</a></div>
						</div>

						<div class="row">
							<div class="span1">bings</div>
							<div class="span2">integer</div>
							<div class="span3">default: 30</div>
							<div class="span1"><code>object</code> </div>
							<div class="span3"><a href="/api/?bings=60" target="_blank">/api/?bings=60</a></div>
						</div>

						<div class="row">
							<div class="span1">minwords</div>
							<div class="span2">integer</div>
							<div class="span3">default: 2</div>
							<div class="span1"><code>object</code> </div>
							<div class="span3"><a href="/api/?minwords=1" target="_blank">/api/?minwords=1</a></div>
						</div>

						<div class="row">
							<div class="span1">maxwords</div>
							<div class="span2">integer</div>
							<div class="span3">default: 4</div>
							<div class="span1"><code>object</code> </div>
							<div class="span3"><a href="/api/?maxwords=6" target="_blank">/api/?maxwords=6</a></div>
						</div>

						<div class="row">
							<div class="span1">categories</div>
							<div class="span2">comma-separated-list</div>
							<div class="span3">default: all</div>
							<div class="span1"><code>object</code> </div>
							<div class="span3"><a href="/api/?categories=images,videos" target="_blank">/api/?categories=images,videos</a></div>
						</div>
					</dd>
				</ul>
			</div>
		</section>

		<?php include("includes/footer.php"); ?>
	</body>
</html>

