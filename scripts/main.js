//@codekit-prepend "social.js";
//@codekit-prepend "../packages/jquery-ui/ui/minified/jquery.ui.core.min.js"
//@codekit-prepend "../packages/jquery-ui/ui/minified/jquery.ui.widget.min.js"
//@codekit-prepend "../packages/jquery-ui/ui/minified/jquery.ui.progressbar.min.js"
//
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

	var $statusbar = $("#statusbar").progressbar({ max: 100 });

	$(window).on("load", function(){
		var timer;
		var status;
		var $timer = $("#timer").hide();
		var $statusbar = $("#statusbar");
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

		function getRandom(int){
			return Math.ceil((Math.random() * int));
		}

		function getInt(str){
			return parseInt(str, 10) * 1;
		}

		function bingMe() {
			console.log("bingme");
			var count = getInt($count.val()) - 1;
			//refactor
			// window.clearInterval(status);
			// var progress = 0;
			// status = window.setInterval(function(){
			//  progress = progress + 50;
			//  $status.trigger("update", progress/time);
			// }, 50);

			window.clearInterval(status);
			$statusbar.progressbar({ value: 0 });
			//window.open($bings.eq(count).addClass("visited").attr("href"), "_newtab");

			$count.val(count);

			if(count === 0){
				$timer.text("all done.");
				$stop.trigger("click");
			} else {
				var min = getInt($minTime.val());
				var max = getInt($maxTime.val());
				var seconds = ( getRandom(max - min)  + min );
				var time = ( seconds * 1000 );
				// console.log(time);
				timer = 0;
				$(".progress-label", $statusbar).text(seconds + " seconds until the next Bing...");
				status = window.setInterval(function(){
					timer += 10;
					$statusbar.progressbar({ value: Math.floor((timer/(time*.85)) * 100) });
				}, 10);
				timer = window.setTimeout(bingMe, time);
			}
		}

		var $start = $("#bingMe").on("click", function(e){
			e.preventDefault();
			$timer.show();
			$(this).add('input[type="number"], #update').attr({disabled: "disabled"});
			bingMe();
		});

		var $stop = $("#stop").on("click", function(e){
			e.preventDefault();
			window.clearTimeout(timer);
			$timer.hide();
			$start.add('input[disabled], #update').removeAttr('disabled');
		});
	});
})(jQuery);
