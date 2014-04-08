(function($, $500px, window, _void){
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
			only: 'Landscapes', //Category list: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#categories
			page: 1,
			rpp: 1,
			image_size:4
		}, function(response){
			var photo = response.data.photos[0];
			var $container = $('#container').css({'background-image': 'url(' + photo.image_url + ')'});

			var icon = $('<span>', {
				id: 'photo_cred',
				text:'Info',
				title: photo.name + ' (by ' + photo.user.fullname + ' of ' + photo.user.city + ', ' + photo.user.country + ')'
			}).appendTo($container).prepend($('<i>', {
				'class': 'fa fa-camera'
			}));
		});
	}

	// Open "external" links in a new window. Because it's 2008.
	$('a[rel*="external"').attr('target', '_blank');

	// Enable jQuery UI "range/slider" elements
	// https://jqueryui.com/slider/
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

	// Enable jQuery UI "progressbar" element
	// https://jqueryui.com/progressbar/
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
		.insertBefore("#standard").hide();

	// Behaviors for overlay "modal"
	var $overlay = $("#overlay").on('modal', function(e, args){
		// console.log(arguments);
		$overlay.addClass('active');
		$(args.selector).show().siblings('.form-panel').hide();
	}).on('close', function(){
		$('nav a.active').removeClass('active');
		$overlay.removeClass('active').children('.form-panel').hide();
	});

	// "close" icon
	$('<span>', {
		'class': 'hide-overlay',
		html: '<i class=" fa fa-times-circle"></i>',
		click: function(e){
			e.preventDefault();
			$overlay.trigger('close');
			return false;
		}
	}).appendTo('.form-panel', $overlay);

	$('nav a[href^="#"]').each(function(){
		var $el = $(this);
		$el.on('click', function(e){
			e.preventDefault();
			if(!$el.hasClass('active')){
				$el.addClass('active').parent().siblings().find('.active').removeClass('active');
				$overlay.trigger('modal', {
					selector: $el.attr('href')
				});
			}
			return false;
		});
	});

	// Attach events to the window object
	var $window = $(window);
	$window.on('resize', function(e) {
		// resize the container height based on window dimensions
		var $el = $('#container');
		var $body = $('body');
		var yOffset = parseInt($body.css('padding-top'), 10) + parseInt($body.css('padding-bottom'), 10);

		$el.css({height: $window.height() - yOffset});

	}).on('load', function(){
		// force size the "pane"
		$window.trigger('resize');

		var timer = false;
		var $bings = $("#phrases a");
		var $count = $("#bings");
		var $delay = $("#delay");

		//
		$("#bings, #min, #max").on("change", function(){
			var $this = $(this);
			var val = $this.val();
			if(val < 0 ){
				$this.val(0);
			}

		});

		function getRandom(int){
			return Math.ceil((Math.random() * int));
		}

		function getInt(str){
			return parseInt(str, 10) * 1;
		}

		function bingMe() {
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

			return;
		}

		var $start = $("#bingMe").on("click", function(e){
			e.preventDefault();
			$statusbar.show();
			$(this).add('#automate input[type="number"], #modified button').attr({disabled: "disabled"});
			bingMe();
		});

		var $stop = $("#stop").on("click", function(e){
			e.preventDefault();
			window.clearTimeout(timer);
			$statusbar.trigger("reset").hide();
			$start.add('#automate input[disabled], #modified button').removeAttr('disabled');
		});


	});
})(jQuery, _500px, window);
