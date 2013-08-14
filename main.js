"use strict";

(function($){
	var prefix = "http://www.bing.com/search?setmkt=en-US&q=";
	var windowoptions = "width=450,height=300,resizable=no,scrollbars=no,toolbar=no,location=no,status=no,menubar=no,copyhistory=no";
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
			// TODO: countdown function
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
		click: function(e){
			e.preventDefault();
			window.open($(this).attr("href"), "_newTab", windowoptions);
		}
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

			$bingLink.attr({href: prefix + str}).trigger("click");

			count++;
			if(count >= max){
				$timer.text("all done.");
			} else {
				bingMe(getRandom(maxWords));
				$count.text(count);
			}
		}, time );
	}

})(jQuery);
