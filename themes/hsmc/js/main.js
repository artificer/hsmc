jQuery(document).ready(function(){
	$body = $('body');

	if($body.hasClass('home')){
		$body.find('.slider').filmslide();
	}

	Shadowbox.init();

});

(function($){
$.widget('cmist.filmslide', {
	_create: function(){
		var self = this;
		this._slides = this.element.find(self.options.slides);
		/**
		 * TODO: adjust the _leftBoundary value when the browser is resized
		 */
		this._leftBoundary = $(self.options.frame).first().offset().left;


		this.element
			.on('click', '.slider-prev', $.proxy(this.prev, this))
			.on('click', '.slider-next', $.proxy(this.next, this));

		this.element
			.addClass(this.widgetBaseClass)
			.imagesLoaded($.proxy(this.start, this));

		// this.element.on('transitionend webkitTransitionEnd',self.options.partOne, function(evt){
		// }).on('click', '.next a', $.proxy(this.next, this))
		//   .on('click', '.prev a', $.proxy(this.prev, this));
	},
	start: function(){
		this._queue = this._slides;
		this.next();			
	},
	next: function(evt){
		if(evt) clearTimeout(this._timeoutID);

		if(this._viewNo > 0){
			this.element
				.one('transitionend.leave webkitTransitionEnd.leave', this._currentSlides.last(), $.proxy(this._arrive, this));
			this._leave();
		} else{
			this._arrive();
		}

		this._timeoutID = setTimeout($.proxy(this.next, this), this.options.interval);
	},
	prev: function(evt){
		clearTimeout(this._timeoutID);
		//not sure if this is right way to go about it
		//probably should be able to look at previous if viewNo == 0
		console.log('previous');
		if(this._viewNo == 0)
			return false;
		

		this.element
				.one('transitionend.leave webkitTransitionEnd.leave', this._currentSlides.last(),{ 'reverse': true },$.proxy(this._arrive, this));
		this._leave(true);

		this._timeoutID = setTimeout($.proxy(this.next, this), this.options.interval);
	},
	_leave: function(reverse){
		reverse = typeof reverse !== 'undefined' ? reverse : false;
		var self = this, slideOffset = 0;

		//reverse flow
		//TODO adjust delays so the leaving feels like its going backwards
		if(reverse){
			// var slides = $(this._currentSlides.get().reverse())
			var slides = $(this._currentSlides.get().reverse())
				.removeClass('arrive')
				.addClass('leave')
				.css({
					'-webkit-transition-delay' : '',
					'-moz-transition-delay' : '',
					'transition-delay' : '',
				})
				.each(function(i){
					var delay = i * parseFloat($(this).css('transition-delay').replace('s',''));
					$(this).css({
						'-webkit-transition-delay' : delay + 's',
						'-moz-transition-delay' : delay + 's',
						'transition-delay' : delay + 's',
						left : ''
					});	
				})
				
			this._queue = this._queue.add(slides);
			return true;
		}

		//normal flow
		if(this._queue.length == 0){
			//reset queue
			this.element.off('transitionend.leave webkitTransitionEnd.leave');
			this.element
				.one('transitionend.leave webkitTransitionEnd.leave', this._currentSlides.last(), $.proxy(function(evt){
					this._slides
						.css({
							'display': 'none',
							'left': '',
							'-webkit-transition-delay' : '',
							'-moz-transition-delay' : '',
							'transition-delay' : '',
							// '-webkit-transition-duration': '0s'
						})
						.removeClass('leave arrive')
						.css({
							'display': '',
							// '-webkit-transition-duration': ''	
						});

					console.log('resetting queue' + this._slides.first().css('left'));
					this._queue = this._slides;
					this._viewNo = 0;
					this._dequeue = null;
					this._currentSlides = null;

					clearTimeout(this._timeoutID);
					this._arrive();
					this._timeoutID = setTimeout($.proxy(this.next, this), this.options.interval);
				},this));
		}

		this._currentSlides
			.removeClass('arrive')
			.addClass('leave')
			.css({
				'-webkit-transition-delay' : '',
				'-moz-transition-delay' : '',
				'transition-delay' : ''
			})
			.each(function(i){
				//calculate delay based on the slides position in the dom
				var delay = i * parseFloat($(this).css('transition-delay').replace('s',''));
				$(this).css({
					'-webkit-transition-delay' : delay + 's',
					'-moz-transition-delay' : delay + 's',
					'transition-delay' : delay + 's',
					'left' : -9999
				});
				slideOffset = $(this).outerWidth(true);
			});


			// .css({
			// 	'left' : -9999
			// });

		if(this._dequeue == null){
			this._dequeue =	this._currentSlides;
		} else{
			this._dequeue = this._dequeue.add( this._currentSlides );
		}
	},
	_arrive: function(evt, reverse){
		if (evt != null){
			reverse = typeof evt.data.reverse !== 'undefined' ? evt.data.reverse : false;
		}

		var self = this, slideOffset = 0;
		console.log('arriving' + reverse);
		console.log(reverse);


		if(reverse){
			this._viewNo--;
			console.log(this._dequeue.get().reverse())
			// this._currentSlides = $(this._dequeue.get().reverse())
			this._currentSlides = $(this._dequeue)
									.filter(':nth-child(-n+'+this.options.slidesPerView*this._viewNo+')')
									.removeClass('leave')
									.addClass('arrive')
									.css({
										'-webkit-transition-delay' : '',
										'-moz-transition-delay' : '',
										'transition-delay' : ''
									})
									.each(function(i){
										//calculate delay based on the slides position in the dom
										var delay = (self.options.slidesPerView - i -1 )* parseFloat($(this).css('transition-delay').replace('s',''));

										$(this).css({
											'-webkit-transition-delay' : delay + 's',
											'-moz-transition-delay' : delay + 's',
											'transition-delay' : delay + 's',
											'left' : self._leftBoundary + (i*slideOffset)
										});
										slideOffset = $(this).outerWidth(true);
									});

			this._dequeue = this._dequeue.not(this._currentSlides);
			return true;
		}

		this._viewNo++;
		this._currentSlides = this._queue
								.filter(':nth-child(-n+'+this.options.slidesPerView*this._viewNo+')')
								.addClass('arrive')
								.each(function(i){
									console.log($(this).css('transition-delay'));
									//calculate delay based on the slides position in the dom
									// var delay = i * parseFloat($(this).css('transition-delay').replace('s',''));
									var delay = i * self.options.delay/1000;
									$(this).css({
										'-webkit-transition-delay' : delay + 's',
										'-moz-transition-delay' : delay + 's',
										'transition-delay' : delay + 's',
										'left' : self._leftBoundary + (i*slideOffset)
									});
									slideOffset = $(this).outerWidth(true);
							});
			
		this._queue = this._queue.not(this._currentSlides);	
	},
	_slides: null,
	_currentSlides: null,
	_queue: null,
	_dequeue: null,
	_leftBoundary: 0,
	_viewNo: 0,
	_timeoutID: null,
	_setOption: function(key, value){
		// switch(key){
			// case 'current':
			// break;
		// }
		this.options[key] = value;
		// In jQuery UI 1.8, you have to manually invoke the _setOption method from the base widget
      	// $.Widget.prototype._setOption.apply( this, arguments );
      	this._super( "_setOption", key, value);
	    // In jQuery UI 1.9 and above, you use the _super method instead
	    // this._super( "_setOption", key, value );
	},
	_destroy: function(){
		// $.Widget.prototype.destroy.call( this );
		// In jQuery UI 1.9 and above, you would define _destroy instead of destroy and not call the base method
	},
	options:{
 		slides: '.slide',
 		interval: 5000,
 		duration: 1000,
 		delay: 300,
 		frame: '.inner',
 		slidesPerView: 3
	}
});

$.extend($.cmist.filmslide, {
  version: "0.1"
});
})(this.jQuery);