<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

<!--        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        -->
        <script src="words.php"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->

        <script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
        <script>window.jQuery || document.write('<script src="bower_components/jquery/jquery.min.js"><\/script>')</script>
        <script>
        "use strict";
        (function($){
        	var prefix = "http://www.bing.com/search?setmkt=en-US&q=";
        	var listLength = app.words.length;
        	var maxWords = 10;
        	var max = 90;
        	var count = 0;
        	var timer;

        	var $start = $("<button>", {
        		text: "bingMe",
        		click: function(e){
        			e.preventDefault;
        			bingMe(getRandom(maxWords));
        			$(this).attr({disabled: "disabled"});
        		}
        	}).appendTo("body");
        	var $stop = $("<button>", {
        		text: "stop",
        		click: function(e){
        			e.preventDefault();
        			window.clearTimeout(timer);
        			$start.removeAttr('disabled');
        		}
        	}).appendTo("body");

        	var $bingLink = $("<a>", {
        		text: "Search!",
        		target: "_blank"
        	}).hide().appendTo("body");

        	var $count = $("<p>", {id: "count", text: 0}).appendTo("body");
        	var $timer = $("<p>", {id: "timer"}).appendTo("body");

        	function getRandom(int){
        		return Math.ceil((Math.random() * int))
        	}

        	function bingMe(int) {
        		var time = (getRandom(15) * 1000);
        		$timer.text(time);
        		timer = window.setTimeout(function(){
        			$timer.text(0);
        			var str = "";

	        		for(var i = 0; i < getRandom(int); i++){
	        			if(i !== 0 ) { str += "+"; }
	        			str += app.words[getRandom(listLength)];
	        		}

	        		console.log(count, ": ", str);

	        		window.open(prefix + str, "_blank");
	        		window.focus();

	        		count++;
	        		if(count >= max){
	        			$timer.text("all done.");
	        		} else {
	        			bingMe(getRandom(maxWords));
	        			$count.text(count);
	        		}
        		}, time );
        	}


        })(jQuery);</script>
    </body>
</html>

