"use strict";

(function($){
	var prefix = "http://www.bing.com/search?setmkt=en-US&q=";
	var windowoptions = "width=450,height=300,resizable=no,scrollbars=no,toolbar=no,location=no,status=no,menubar=no,copyhistory=no";
	var listLength = app.words.length;
	var maxWords = 6;
	var timer;
	var status;

	var $count = $("<input>", {
		id: "count",
		type: "number",
		value: 45,
		placeholder: 0,
		title: "remaining bings"
	}).appendTo("body");

	var $minTime = $("<input>", {
		id: "minTime",
		type:"number",
		value: 5,
		placeholder:0,
		title: "minimum seconds"
	}).appendTo("body");

	var $maxTime = $("<input>", {
		id: "maxTime",
		type:"number",
		value: 10,
		placeholder:0,
		title: "maximum seconds"
	}).appendTo("body");

	var $start = $("<button>", {
		text: "bingMe",
		click: function(e){
			e.preventDefault;
			// $status.show();
			bingMe();
			$(this).add('input[type="number"]').attr({disabled: "disabled"});
			// TODO: countdown function
		}
	}).appendTo("body");

	var $stop = $("<button>", {
		text: "stop",
		click: function(e){
			e.preventDefault();
			window.clearTimeout(timer);
			// $status.trigger("reset").hide();
			$start.add('input[disabled]').removeAttr('disabled');
		}
	}).appendTo("body");

	// var $status = $("<div>", {
	// 	id: "status"
	// }).bind("reset", function(){
	// 	$(this).css({width: 0});
	// 	window.clearInterval(status);
	// }).on("update", function(e, float){
	// 	// console.log(float);
	// 	float = float * 100;
	// 	$(this).css({width: float + "%"});
	// }).hide().appendTo("body");

	var $timer = $("<p>", {id: "timer"}).appendTo("body");

	function getRandom(int){
		return Math.ceil((Math.random() * int))
	}

	function bingMe() {
		// refactor
		var min = parseInt($minTime.val()) * 1;
		var max = parseInt($maxTime.val()) * 1;
		var seconds = ( getRandom(max - min)  + min );
		var time = ( seconds * 1000 );
		var count = parseInt($count.val()) * 1;

		//refactor
		// window.clearInterval(status);
		// var progress = 0;
		// status = window.setInterval(function(){
		// 	progress = progress + 50;
		// 	$status.trigger("update", progress/time);
		// }, 50);

		$timer.text(seconds);
		timer = window.setTimeout(function(){
			var str = "";

			for(var i = 0; i < getRandom(maxWords); i++){
				if(i !== 0 ) { str += "+"; }
				str += app.words[getRandom(listLength)];
			}
			$("<a>", {
				"class": "bingLink",
				href: prefix + str,
				text: str.replace(/\+/g, " "),
				target: "_blank"
			}).on("bing", function(){
				window.setTimeout(function(){
					window.open(prefix + str, '_newtab');
				}, 50);
			}).appendTo("body").trigger("bing");

			count--;

			if(count ===0){
				$timer.text("all done.");
				$stop.trigger("click");
			} else {
				$count.val(count);
				bingMe();
			}
		}, time );
	}

})(jQuery);
