jQuery(document).ready(function(){
	$body = $('body');

	if($body.hasClass('home') || $body.hasClass('about')){
		$body.find('.slider').softslide();
	}else if($body.hasClass('author')){
		Shadowbox.init({
			skipSetup: true
		});

		// $(CiCo.formSelector).citrusform();
		$bookingForm = $body.find('.booking-form-wrap').detach();
		$body.on('click', '.btn-booking', function(evt){
			evt.preventDefault();

			var sb = Shadowbox.open({
				content: $bookingForm.html(),
				player: 'html',
				title: "Book Consultant",
				width: 350,
				height: 550,
				options: {
					onFinish: function(el){
						$(CiCo.formSelector).citrusform();
					},
					enableKeys: false
				}
			});
		});
	}else if($body.hasClass('single-hospital') || $body.hasClass('rooms')){
		Shadowbox.init();
		console.log('shadow');
	}
});

(function($){

$.fn.redraw = function(){
	$(this).each(function(){ var redraw = this.offsetHeight; });
	return this;
};

$.widget('cmist.softslide', {
	_create: function(){
		var self = this;
		this._slides = this.element.find(self.options.slides);
		this._captions = $('body').find('.slider-captions')
							.find('.slide-caption');
		/**
		 * TODO: adjust the _leftBoundary value when the browser is resized
		 */
		this._leftBoundary = $(self.options.frame).first().offset().left;

		this.element
			.on('click', '.slide img', $.proxy(this.showProfile, this));
		
		this._captions
			.on('click', '.slide-caption-close', $.proxy(this.closeProfile, this));

		this.element
			.addClass(this.widgetBaseClass)
			.imagesLoaded($.proxy(this.start, this));
	},
	start: function(){
		var slideWdth = this._slides.first().outerWidth(true);
		var classes = this.widgetBaseClass + '-loaded ' + this.widgetBaseClass + '-' + this.options.slideDirection;

		if(Modernizr.csstransitions){
			console.log('in transit baby');
		}

		this._slides
			.find('.slide-img')
				.wrap('<div class="slide-mask"/>')
			.end()
			.redraw()
			.css({
				'left': function(index, value){
					console.log('setting left');
					return index * parseInt(value, 10);
				}
			});

		if(this.options.slideDirection == 'bottomcrop'){
			this._slides
				.find('.slide-img')
					.wrap('<div class="slide-mask--crop"/>');
		}

		//trigger the introductory transitions
		this.element
			.addClass(classes);
	},
	reset: function(){
		console.log('reset');

		this._slides
			.find('.slide-img')
				.unwrap()
			.end()
			.css({'left': ''});

		if(this.options.slideDirection == 'bottomcrop'){
			this._slides
				.find('.slide-img')
					.unwrap();
		}

		//trigger the introductory transitions
		this.element
			.removeClass(this.widgetBaseClass + '-loaded')
			.removeClass(this.widgetBaseClass + '-' + this.options.slideDirection);
	},
	showProfile: function(evt){
		var $slide = $(evt.currentTarget)
					.closest(this.options.slides)
					.addClass('active');

		var offset = $slide.offset();

		console.log("showing profile");
		// $slide = $(evt.currentTarget).closest(this.options.slides).addClass('active');
		// $caption = $slide.find('.slide-caption').removeClass('hidden');
		$caption = this._captions
					.filter('[data-slide='+ $slide.attr('id') +']')
					.css({
						'left' : offset.left + 120,
						'top'  : offset.top	+ 260
					})
					.removeClass('hidden')
					.addClass('fadeInUp');

		this.element.addClass(this.widgetBaseClass + '-active');
	},
	closeProfile: function(evt){
		console.log('closing');
		$closeBtn = $(evt.currentTarget);	

		$caption = $closeBtn.closest('.slide-caption')
					.removeClass('fadeInUp')
					.addClass('fadeOutDown');
					
		$caption.one('webkitAnimationEnd animationend oAnimationEnd MSAnimationEnd', function(event) {
			$(event.target).addClass('hidden')
				.removeClass('fadeOutDown')
				.css({
					'left' : '',
					'top'  : ''
				});
		});

		this.element.find('#' + $caption.data('slide')).removeClass('active');

		if(this.element.find('.active').size() === 0){
			this.element.removeClass(this.widgetBaseClass + '-active');
		}
	},
	_captions: null,
	_slides: null,
	_currentSlide: null,
	_leftBoundary: 0,
	_timeoutID: null,
	_setOption: function(key, value){
		// switch(key){
			// case 'current':
			// break;
		// }
		this.options[key] = value;
		// In jQuery UI 1.8, you have to manually invoke the _setOption method from the base widget
		$.Widget.prototype._setOption.apply( this, arguments );
		// this._super( "_setOption", key, value);
		// In jQuery UI 1.9 and above, you use the _super method instead
		// this._super( "_setOption", key, value );
	},
	_destroy: function(){
		// $.Widget.prototype.destroy.call( this );
		// In jQuery UI 1.9 and above, you would define _destroy instead of destroy and not call the base method
	},
	options:{
		slides: '.slide',
		slideDirection: 'bottom',
		frame: '.inner',
		slidesPerView: 2
	}
});

$.extend($.cmist.softslide, {
  version: "0.1"
});
})(this.jQuery);