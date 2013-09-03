<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head lang="en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>summits-vote</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="noindex, nofollow">
		<link rel="stylesheet" href="styles/main.css">

		<style type="text/css" media="screen">
			@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
			@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
			@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
			#spinner{
				-webkit-animation:spin 1s linear infinite;
				-moz-animation:spin 1s linear infinite;
				animation:spin 1s linear infinite;position:absolute;
				top:50%;
				left:50%;
				height:1em;
				line-height:1em;
				width:1em;
				margin-top:-.5em;
				margin-left:-.5em;
			}
			#container a{
				color:#666;
				float:left;
				margin-right:1em;
				margin-bottom:1em;
				padding:.25em .5em;
			}
			#container a.visited{
				color:#999;
				background-color:#eee;
			}
		</style>
	</head>
	<body class="container">
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->

		<hgroup class="row">
			<h1 class="span8">summits vote!</h1>
		</hgroup>

		<section class="row">

			<div class="span12">
				<button id="summits-vote">Batch</button>
				<p><a href="http://t.co/w5Yg2GhnCy">Or Vote here:</a></p>
				<h1 class="text-center"><i id="spinner" class="icon icon-spinner"></i></h1>
			</div>

			<div class="span12" id="container"></div>

		</section>

		<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script>window.jQuery || document.write('<script src="packages/jquery/jquery.min.js"><\/script>')</script>

		<script type="text/javascript">
		(function($){
			'use strict';

			var timer = null;
			function batch($set, node){

				if(arguments.length === 1){
					node = 0;
				}

				if(node === $set.length){
					$spinner.hide();
					console.log("all done!");
				} else {

					var delay = 24 + Math.floor(Math.random() * 60);
					var $el = $set.eq(node);
					$el.trigger("click");
					console.log("... voted for " + $el.text());
					console.log(delay + " seconds until the next vote ...");
					window.clearTimeout(timer)

					timer= window.setTimeout(function(){
						batch($set, node + 1);
					}, delay * 1000);
				}

			}

			var $spinner = $("#spinner").hide();

			var $btn = $("#summits-vote").attr("disabled", "disabled")
				.data("pending", 0)
				.bind("schedule", function(){
					$(this).data("pending", $(this).data("pending") + 1 );
				})
				.bind("complete", function(){
					var $this = $(this);
					$this.data("pending", $this.data("pending") - 1 ).trigger("check");
				})
				.bind("check", function(){
					var $this = $(this);
					if($this.data("pending") === 0){
						$this.removeAttr("disabled");
					}
				}).on("click", function(e){
					e.preventDefault();
					$spinner.show();

					batch($("#container a"));

					return false;

				});

			var userIDs = (function(array){
				// randomizes array
				var currentIndex = array.length
					, temporaryValue
					, randomIndex
					;

				// While there remain elements to shuffle...
				while (0 !== currentIndex) {
					// Pick a remaining element...
					randomIndex = Math.floor(Math.random() * currentIndex);
					currentIndex -= 1;

					// And swap it with the current element.
					temporaryValue = array[currentIndex];
					array[currentIndex] = array[randomIndex];
					array[randomIndex] = temporaryValue;
				}

				return array;
			})([
				"aaron.walker1",
				"AdamUI96",
				"akcober",
				"amy.balza",
				"andre.malske",
				"bas.kuis",
				"bill.oneil.79",
				// "brad.hollander.33",
				"brian.d.poulsen",
				"brian.molstad",
				"brian.welter",
				"chaning.ogden",
				"courtney.coxpoulsen",
				// "CullenOB",
				"daniil",
				"davidowalsh",
				"elliejerow",
				"gail.petersondunlap",
				"garret.starke",
				"ivan.eisenberg",
				"james.davidson1",
				"james.ketola.98",
				// "jasonkobs",
				// "jennifer.andersonpulvermacher",
				"jill.marie.lg",
				// "jim.blixt",
				"jim.graf.144181",
				// "jim.palzewicz",
				"jonbalza",
				"julia.malske",
				"karilynn.oneil",
				"kathleen.c.omalley",
				"kelly.basten.1",
				"kelsey.dins",
				"kentheberling",
				"kieran.hennessey",
				"kim.welter.9",
				// "KristenEDavis",
				"kristin.hinkel.3",
				"linda.kaminski.14",
				"lukas.sparks",
				"maggie.cain",
				"marilyn.gueller",
				// "marissa.gallus",
				// "michael.schwobe",
				// "michelle.hickstobias",
				"paul.gueller",
				// "paul.stillmank",
				// "rj.reimers",
				// "robert.hogervorst",
				// "robertemmet.murray",
				"sa.kaminski",
				"sally.kaminski.5",
				"shannon.gburzynski",
				// "stactum", // andre
				"todd.nilson",
				"veloracer",
				"vhubertz"
			]);

			$.each(userIDs, function(i,v){
				$btn.trigger("schedule");
				$.ajax({
					dataType: "json",
					cache:false,
					url: "//graph.facebook.com/" + v,
					complete: function(){
						$btn.trigger("complete");
					},
					success: function(data){
						// graph.push(data);
						$("<a>", {
							href: 'https://fbui.publishtofanpage.com/contests/vote?media=24479&fbUserId=' + data.id + '&fbUserName=' + data.name.replace(' ', '+') + '&rating=5',
							text: data.name,
							target: "_blank",
							click: function(){
								var $this = $(this);
								window.open($this.attr("href"), "batch");
								$this.addClass("visited");
							}
						}).appendTo("#container");
					}
				});
			});

		})(jQuery);

		</script>
	</body>
</html>
