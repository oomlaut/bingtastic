//@codekit-prepend "social.js";

(function($){
	"use strict";


	var $phraselist = $("#phraselist").hide();
	$("#phrase-heading").on("click", function(){
		if($phraselist.hasClass("active")){
			$phraselist.removeClass("active").slideUp();
		} else {
			$phraselist.addClass("active").slideDown();
		}
	});

	$(window).on("load", function(){
		var timer;
		var $timer = $("#timer").hide();
		var $bings = $("a", $phraselist);
		var $count = $("#bings");
		var $minTime = $("#min");
		var $maxTime = $("#max");

		$("#bings, #min, #max").on("change", function(){
			console.log($(this).val());
			if($(this).val() < 0 ){
				$(this).val(0);
			}
		});

		// var status;
		// var $status = $("<div>", {
		//  id: "status"
		// }).bind("reset", function(){
		//  $(this).css({width: 0});
		//  window.clearInterval(status);
		// }).on("update", function(e, float){
		//  // console.log(float);
		//  float = float * 100;
		//  $(this).css({width: float + "%"});
		// }).hide().appendTo("body");

		function getRandom(int){
			return Math.ceil((Math.random() * int));
		}

		function getInt(str){
			return parseInt(str, 10) * 1;
		}

		function bingMe() {
			var count = getInt($count.val()) - 1;
			//refactor
			// window.clearInterval(status);
			// var progress = 0;
			// status = window.setInterval(function(){
			//  progress = progress + 50;
			//  $status.trigger("update", progress/time);
			// }, 50);


			window.open($bings.eq(count).addClass("visited").attr("href"), "_newtab");

			$count.val(count);

			if(count === 0){
				$timer.text("all done.");
				$stop.trigger("click");
			} else {
				var min = getInt($minTime.val());
				var max = getInt($maxTime.val());
				var seconds = ( getRandom(max - min)  + min );
				var time = ( seconds * 1000 );

				$timer.text(seconds + " seconds until the next Bing...");
				timer = window.setTimeout(bingMe, time);
			}
		}

		var $start = $("#bingMe").on("click", function(e){
			e.preventDefault();
			// $status.show();
			$timer.show();
			$(this).add('input[type="number"], #update').attr({disabled: "disabled"});
			bingMe();
		});

		var $stop = $("#stop").on("click", function(e){
			e.preventDefault();
			window.clearTimeout(timer);
			// $status.trigger("reset").hide();
			$timer.hide();
			$start.add('input[disabled], #update').removeAttr('disabled');
		});
	});
})(jQuery);
