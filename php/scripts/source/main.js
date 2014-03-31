(function($, $500px){
	'use strict';

	// load '500px' background image bing-style
	// https://github.com/500px/500px-js-sdk
	// https://github.com/500px/api-documentation

	if(arguments.length > 1 && typeof $500px === 'object'){
		$500px.init({
			sdk_key: 'bb90d1c6f1b501447a9a4c2ed000fcf9ecc464a7'
		});

		$500px.api('/photos', {
			feature: 'popular',
			only: 'Landscapes',
			page: 1,
			rpp: 1,
			image_size:4
		}, function(response){
			var photo = response.data.photos[0];

			// http://srobbin.com/jquery-plugins/backstretch/
			$.backstretch(photo.image_url);


			var icon = $('<span>', {
				id: 'photo_cred',
				text:'Info',
				title: photo.name + ' (by ' + photo.user.fullname + ' of ' + photo.user.city + ', ' + photo.user.country + ')'
			}).appendTo('body').prepend($('<i>', {
				'class': 'fa fa-camera'
			}));
		});
	}

	$(".toggle, #modified").hide();

	$(".toggle-control").on("click", function(){
		$(this).toggleClass("active").next().toggleClass("active").slideToggle();
		$("i.fa", $(this)).toggleClass("fa fa-plus-square-o").toggleClass("fa fa-minus-square-o");
	}).prepend($("<i>", {"class": "fa fa-plus-square-o"}));

	var $range = $("#delay");

	var $slider = $( "#slider-range" ).slider({
		range: true,
		animate: true,
		min: $range.attr("data-min") * 1,
		max: $range.attr("data-max") * 1,
		values: [ 5, 15 ],
		slide: function( event, ui ) {
			$range.val( ui.values[ 0 ] + " - " + ui.values[ 1 ] ).data({
				min: ui.values[ 0 ],
				max: ui.values[ 1 ]
			});
		}
	});
	$range.data({
		min: $slider.slider( "values", 0 ),
		max: $slider.slider( "values", 1 )
	});

	var status = false;
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
		.progressbar({ max: 100 })
		.insertBefore("#search-phrases").hide();

	$(window).on("load", function(){
		var timer = false;
		var $bings = $("#phraselist a");
		var $count = $("#bings");
		var $delay = $("#delay");

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
				$stop.trigger("click");
			} else {
				var min = getInt($delay.data("min"));
				var max = getInt($delay.data("max"));
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
			$statusbar.show();
			$("#form-controls").hide();
			$(this).add('#automate input[type="number"], #modified button').attr({disabled: "disabled"});
			bingMe();
		});

		var $stop = $("#stop").on("click", function(e){
			e.preventDefault();
			window.clearTimeout(timer);
			$statusbar.trigger("reset").hide();
			$("#form-controls").show();
			$start.add('#automate input[disabled], #modified button').removeAttr('disabled');
		});


	});
})(jQuery, _500px);
