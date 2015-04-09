(function($, $500px, window){
	'use strict';


	/*
		Utility Functions
	 */

	function getRandom(int){
		return Math.ceil((Math.random() * int));
	}

	function getInt(str){
		return parseInt(str, 10) * 1;
	}


	/*
		Open "external" links in a new window. Because it's 2008.
	 */

	$('a[rel*="external"]').attr('target', '_blank');


	/*
		Prevent certain inputs from having invalid values
	 */

	$('#bings, #min, #max').on('change', function(){
		var $this = $(this);
		var val = $this.val();
		if(val < 0 ){
			$this.val(0);
		}

	});


	/*
		Modal
	 */

	// Behaviors for overlay "modal"
	var $overlay = $('#overlay').on('modal', function(e, args){
		$overlay.addClass('active');
		$(args.selector).show().siblings('.form-panel').hide();
	}).on('close', function(){
		$('nav a.active').removeClass('active');
		$overlay.removeClass('active').children('.form-panel').hide();
	});

	// Modal "close" icon
	var $closeBtn = $('<span>', {
		'class': 'hide-overlay',
		html: '<i class=" fa fa-times-circle"></i>',
		click: function(e){
			e.preventDefault();
			$overlay.trigger('close');
			return false;
		}
	}).appendTo('.form-panel', $overlay);

	// Assign modal behaviors to the navigation
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


	/*
		Load "bing-like" image from 500px
	 */

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


	/*
		Enable jQuery UI "range/slider" elements
	 */

	var $delay = $('#delay');

	var $slider = $('#slider-range').slider({
		range: true,
		animate: true,
		min: $delay.data('min'),
		max: $delay.data('max'),
		values: [ $delay.data('min-default'), $delay.data('max-default') ],
		slide: function( event, ui ) {
			$delay.val( ui.values[ 0 ] + ' - ' + ui.values[ 1 ] );
		}
	});


	/*
		Enable jQuery UI "progressbar" element
	 */

	var $progressbar = $('<div>', {id: 'progressbar'}).hide()
		.insertBefore('#standard.control-group')
		.on('reset', function(){
			var $this = $(this);
			$this.progressbar({ value: 0 }); //.hide()
			$('.progress-label', $this).text('');
		})
		.progressbar({
			max: 100,
			complete: function(){
				bingMe();
			}
		});
	var $progresslabel = $('<div>', {'class': 'progress-label'}).appendTo($progressbar);


	/*
		Modify the title element
	 */

	var modifyTitle = {
		$el : $('title#app-title'),
		regex : /(^\()([0-9]{1,2})(\) )/ig,
		update: function (int){
			var self = this;
			if(self.$el.text().match(self.regex) != null){
				self.$el.text( self.$el.text().replace(self.regex, function(){
					return arguments[1] + int + arguments[3];
				}));
			} else {
				self.$el.text( '(' + int + ') ' + self.$el.text() ) ;
			}
		},
		reset: function(){
			var self = this;
			self.$el.text( self.$el.text().replace(self.regex, '') );
		}
	};


	/*
		BingMe
	 */

	var interval = false;
	var $bings = $('#phrases a');
	var $count = $('#bings');

	function bingMe() {
		window.clearInterval(interval);

		var count = getInt($count.val()) - 1;

		$count.val(count);

		window.open($bings.eq(count).addClass('visited').attr('href'), '_newtab');

		if(count === 0){
			$stop.trigger('click');
			$start.attr({disabled: 'disabled'});
		} else {
			$progressbar.trigger('reset');
			modifyTitle.update(count);

			var range = $slider.slider('values');
			var min = getInt(range[0]);
			var max = getInt(range[1]);
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

	var $start = $('#bingMe').on('click', function(e){
		e.preventDefault();
		$progressbar.add($stop).show();
		$(this).hide().add('#automate input[type="number"], #modified button').attr({disabled: 'disabled'});
		bingMe();
	});

	var $stop = $('#stop').hide().on('click', function(e){
		e.preventDefault();
		modifyTitle.reset();

		window.clearInterval(interval);
		$progressbar.trigger('reset');
		$(this).add($progressbar).hide();
		$start.show().add('#automate input[disabled], #modified button').removeAttr('disabled');
	});

	// Attach events to the window object
	$(window).on('resize', function(e) {
		var $body = $('body');
		var yOffset = parseInt($body.css('padding-top'), 10) + parseInt($body.css('padding-bottom'), 10);

		// resize the container height based on window dimensions
		$('#container').css({height: $(this).height() - yOffset});

	}).on('load', function(e, callback){
		// this was where the BingMe Function was. if there are issues, move it back.
	}).trigger('resize');

})(jQuery, _500px, window);
