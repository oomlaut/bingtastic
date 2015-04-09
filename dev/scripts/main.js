(function($, $500px, window, _void){
	'use strict';

	var self = this;

	if(arguments.length > 1){
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
	$('a[rel*="external"]').attr('target', '_blank');

	// Enable jQuery UI "range/slider" elements
	// https://jqueryui.com/slider/
	var $range = $('#delay');

	var $slider = $('#slider-range');
	$slider.slider({
		range: true,
		animate: true,
		min: $range.data('min') * 1,
		max: $range.data('max') * 1,
		values: [ $slider.data('min-default'), $slider.data('max-default') ],
		slide: function( event, ui ) {
			$range.val( ui.values[ 0 ] + ' - ' + ui.values[ 1 ] ).data({
				min: ui.values[ 0 ],
				max: ui.values[ 1 ]
			});
		}
	});

	$range.data({
		min: $slider.slider( 'values', 0 ),
		max: $slider.slider( 'values', 1 )
	});

	// Enable jQuery UI "progressbar" element
	// https://jqueryui.com/progressbar/
	var status = false;
	var $progressbar = $('<div>', {id: 'progressbar'}).hide()
		.insertBefore('#standard.control-group')
		.on('reset', function(){
			var $this = $(this);
			$this.progressbar({ value: 0 }); //.hide()
			$('.progress-label', $this).text('');
		})
		.progressbar({ max: 100 });
	var $progresslabel = $('<div>', {'class': 'progress-label'}).appendTo($progressbar);

	// Behaviors for overlay "modal"
	var $overlay = $('#overlay').on('modal', function(e, args){
		$overlay.addClass('active');
		$(args.selector).show().siblings('.form-panel').hide();
	}).on('close', function(){
		$('nav a.active').removeClass('active');
		$overlay.removeClass('active').children('.form-panel').hide();
	});

	// "close" icon
	var $closeBtn = $('<span>', {
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
	var $window = $(window).on('resize', function(e) {
		var $context = $(this);
		var $el = $('#container');
		var $body = $('body');
		var yOffset = parseInt($body.css('padding-top'), 10) + parseInt($body.css('padding-bottom'), 10);


		// resize the container height based on window dimensions
		$el.css({height: $context.height() - yOffset});

	}).on('load', function(e, callback, undefined){
		var $context = $(this);

		var interval = false;
		var $bings = $('#phrases a');
		var $count = $('#bings');
		var $delay = $('#delay');

		// force size the "pane"
		$context.trigger('resize');

		$('#bings, #min, #max').on('change', function(){
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

		var $title = $('title#app-title');
		var exp = /^\([0-9]{1,2}\) /i;

		function updateTitle(int){
			var prepend = '(' + int + ') ';

			if($title.text().match(exp) != null){
				$title.text( $title.text().replace(exp, prepend) );
			} else {
				$title.text( prepend + $title.text() );
			}
		}

		function resetTitle(){
			$title.text($title.text().replace(exp, ''));
		}

		function bingMe() {
			window.clearInterval(interval);

			var count = getInt($count.val()) - 1;

			$count.val(count);

			window.open($bings.eq(count).addClass('visited').attr('href'), '_newtab');

			if(count === 0){
				$stop.trigger('click');
			} else {
				$progressbar.trigger('reset');
				updateTitle(count);

				var min = getInt($delay.data('min'));
				var max = getInt($delay.data('max'));
				var seconds = ( getRandom(max - min)  + min );
				var started = Date.now();
				var rate = 50;

				$progresslabel.text(seconds + ' seconds until the next Bing. ' + count + ' remaining.');

				interval = window.setInterval(function(){
					$progressbar.progressbar({
						value: ((Date.now() - started) / (seconds * 1000)) * 100
					});
				}, rate);

			}

		}

		$progressbar.progressbar({
			complete: function(){
				bingMe();
			}
		});

		var $start = $('#bingMe').on('click', function(e){
			e.preventDefault();
			$progressbar.add($stop).show();
			$(this).hide().add('#automate input[type="number"], #modified button').attr({disabled: 'disabled'});
			bingMe();
		});

		var $stop = $('#stop').hide().on('click', function(e){
			e.preventDefault();
			resetTitle();
			window.clearInterval(interval);
			$progressbar.trigger('reset');
			$(this).add($progressbar).hide();
			$start.show().add('#automate input[disabled], #modified button').removeAttr('disabled');
		});

	});
})(jQuery, _500px, window);
