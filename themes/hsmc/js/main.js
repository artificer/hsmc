jQuery(document).ready(function(){
	$body = $('body');

	if($body.hasClass('home')){
		$body.find('.slider').filmslide();
	}

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
		if(this._viewNo > 0){
			this.element
				.one('transitionend.leave webkitTransitionEnd.leave', this._currentSlides.last(), $.proxy(this._arrive, this));
			this._leave();
		} else{
			this._arrive();
		}
		setTimeout($.proxy(this.next, this), this.options.interval);
	},
	prev: function(evt){
		//can't do previous if the 
		if(this._viewNo == 0)
			return false;
		
		this.element
				.one('transitionend.leave webkitTransitionEnd.leave', this._currentSlides.last(), $.proxy(this._arrive, this));
		this._leave(true);
	},
	_leave: function(reverse){
		reverse = typeof reverse !== 'undefined' ? a : false;
		var self = this, slideOffset = 0;

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
							'transition-delay' : ''
						})
						.removeClass('leave arrive')
						.css('display', '');

					this._queue = this._slides;
					this._viewNo = 0;
					this._dequeue = null;
					this._currentSlides = null;
					$.proxy(this._arrive, this);
				},this));


		}

		this._dequeue = this._currentSlides
							.removeClass('arrive')
							.addClass('leave')
							.css({
								'left' : ''
							});
	},
	_arrive: function(){
		reverse = typeof reverse !== 'undefined' ? reverse : false;
		var self = this, slideOffset = 0;

		this._viewNo++;
		this._currentSlides = this._queue
								.filter(':nth-child(-n+'+this.options.slidesPerView*this._viewNo+')')
								.addClass('arrive')
								.each(function(i){
									//calculate delay based on the slides position in the dom
									var delay = i * parseFloat($(this).css('transition-delay').replace('s',''));
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
 		interval: 3000,
 		duration: 1000,
 		frame: '.inner',
 		slidesPerView: 3
	}
});

$.extend($.cmist.filmslide, {
  version: "0.1"
});
})(this.jQuery);