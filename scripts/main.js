//@codekit-prepend "social.js";
//@codekit-prepend "../packages/jquery-ui/ui/minified/jquery.ui.core.min.js"
//@codekit-prepend "../packages/jquery-ui/ui/minified/jquery.ui.widget.min.js"
//@codekit-prepend "../packages/jquery-ui/ui/minified/jquery.ui.progressbar.min.js"
//
(function($){
	"use strict";

	$(".toggle, #modified").hide();

	$(".toggle-control").on("click", function(){
		$(this).toggleClass("active").next().toggleClass("active").slideToggle();
		$("i.icon", $(this)).toggleClass("icon icon-expand-alt").toggleClass("icon icon-collapse-alt");
	}).prepend($("<i>", {"class": "icon icon-expand-alt"}));


	var status = false;
	var $container = $("#automate");
	var $timer = $("<div>", {id: "timer"}).appendTo($container).hide();
	var $statusbar = $("<div>", {id: "statusbar"})
		.append($("<div>", {"class": "progress-label"}))
		.on("update", function(e, data){
			var elapsed = 0;
			var interval = 50;
			$(".progress-label", $(this)).text((data.time / 1000) + " seconds until the next Bing. " + data.count + " remaining.");
			status = window.setInterval(function(){
				elapsed += interval;
				$statusbar.progressbar({ value: Math.floor(((elapsed/(data.time*0.9)) * 100)) });
			}, interval);
		})
		.on("reset", function(){
			window.clearInterval(status);
			$(this).progressbar({ value: 0 });
		})
		.appendTo($timer)
		.progressbar({ max: 100 });

	$(window).on("load", function(){
		var timer = false;
		var $bings = $("#phraselist a");
		var $count = $("#bings");
		var $minTime = $("#min");
		var $maxTime = $("#max");

		$("#bings, #min, #max").on("change", function(){
			var $this = $(this);
			var val = $this.val();
			if(val < 0 ){
				$this.val(0);
			}

			if($this.attr("data-require-redraw") === "true"){
				var defaultval = $this.attr("data-default");
				if(val === defaultval ){
					$("#modified").hide();
					$("#standard").show();
				} else {
					$("#modified").show();
					$("#standard").hide();
				}
			}
		});

		function getRandom(int){
			return Math.ceil((Math.random() * int));
		}

		function getInt(str){
			return parseInt(str, 10) * 1;
		}

		function bingMe() {
			// console.log("bingme");
			var count = getInt($count.val()) - 1;
			window.open($bings.eq(count).addClass("visited").attr("href"), "_newtab");

			$count.val(count);
			$statusbar.trigger("reset");

			if(count === 0){
				$timer.text("all done.");
				$stop.trigger("click");
			} else {
				var min = getInt($minTime.val());
				var max = getInt($maxTime.val());
				var seconds = ( getRandom(max - min)  + min );
				var time = ( seconds * 1000 );

				$statusbar.trigger("update", {"count": count, "time": time});

				window.clearTimeout(timer);
				timer = window.setTimeout(bingMe, time);
			}
		}

		$("#reset").on("click", function(){
			$("#modified").hide();
			$("#standard").show();
		});

		var $start = $("#bingMe").on("click", function(e){
			e.preventDefault();
			$timer.show();
			$("#form-controls").hide();
			$(this).add('#automate input[type="number"], #modified button').attr({disabled: "disabled"});
			bingMe();
		});

		var $stop = $("#stop").on("click", function(e){
			e.preventDefault();
			window.clearTimeout(timer);
			$statusbar.trigger("reset");
			$timer.hide();
			$("#form-controls").show();
			$start.add('#automate input[disabled], #modified button').removeAttr('disabled');
		});


	});
})(jQuery);
