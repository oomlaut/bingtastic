<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head lang="en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>summits-vote</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="robots" content="noindex, nofollow">
		<link rel="author" href="humans.txt">
		<link rel="sitemap" href="sitemap.xml">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
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
			<h1 class="span8">summits vote!</h1>
			<div id="login" class="span3"></div>
		</hgroup>

		<section class="row">

			<div class="span12">
				<button id="summits-vote">Go</button>
			</div>

			

		</section>

		<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script>window.jQuery || document.write('<script src="packages/jquery/jquery.min.js"><\/script>')</script>

		<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

		<script type="text/javascript">
			
		var users = [
			{
				"id": "9326167",
				"name": "Ivan Eisenberg",
				"first_name": "Ivan",
				"last_name": "Eisenberg",
				"username": "ivan.eisenberg",
				"gender": "male",
				"locale": "en_GB"	
			},
			{
			   "id": "616320586",
			   "name": "Paul Gueller",
			   "first_name": "Paul",
			   "last_name": "Gueller",
			   "link": "http://www.facebook.com/paul.gueller",
			   "username": "paul.gueller",
			   "gender": "male",
			   "locale": "en_US"
			},
			{
			   "id": "1606980168",
			   "name": "Tori Hubertz",
			   "first_name": "Tori",
			   "last_name": "Hubertz",
			   "username": "vhubertz",
			   "gender": "female",
			   "locale": "en_US"
			},
			{
			   "id": "780783536",
			   "name": "Kristin Hinkel",
			   "first_name": "Kristin",
			   "last_name": "Hinkel",
			   "link": "http://www.facebook.com/kristin.hinkel.3",
			   "username": "kristin.hinkel.3",
			   "gender": "female",
			   "locale": "en_US"
			},
			{
			   "id": "219702612",
			   "name": "Lukas Sparks",
			   "first_name": "Lukas",
			   "last_name": "Sparks",
			   "username": "lukas.sparks",
			   "gender": "male",
			   "locale": "en_US"
			},
			{
			   "id": "26714391",
			   "name": "Kent Heberling",
			   "first_name": "Kent",
			   "last_name": "Heberling",
			   "link": "http://www.facebook.com/kentheberling",
			   "username": "kentheberling",
			   "gender": "male",
			   "locale": "en_US"
			},
			{
			   "id": "100001465038954",
			   "name": "Ellie Jerow",
			   "first_name": "Ellie",
			   "last_name": "Jerow",
			   "username": "elliejerow",
			   "gender": "female",
			   "locale": "en_US"
			}
		];
		$.JSONparse
		var summitsVote = function(){
			var delay = 1;
			$.each(users, function(i, data){

				delay = delay + (10 + Math.floor(Math.random() * 27)) * 1000;
				console.log(delay);

				setTimeout(function(){

					var id = data.id;
					var name = data.name.replace(' ', '+');

					console.log('https://fbui.publishtofanpage.com/contests/vote?media=24479&fbUserId='+id+'&fbUserName='+name+'&rating=5');
					window.open('https://fbui.publishtofanpage.com/contests/vote?media=24479&fbUserId='+id+'&fbUserName='+name+'&rating=5', "_newtab");

				}, delay);
				
			});
		};
		
		$('#summits-vote').click(function(){
			summitsVote();
		});

		</script>

		<!--
		<script>window.jQuery || document.write('<script src="scripts/jquery-validate.min.js"><\/script>')</script>
		-->

		<script>
		</script>
	</body>
</html>