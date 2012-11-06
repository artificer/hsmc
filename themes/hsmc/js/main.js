jQuery(document).ready(function(){
	$body = $('body');

	if($body.hasClass('home')){
		console.log('here');
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
		 * TODO: allow the widget to specify the number of slider per page
		 *
		 */
		this._leftBoundary = $(self.options.frame).first().offset().left;

		this.element.addClass(this.widgetBaseClass);
		this.element.imagesLoaded($.proxy(this.start, this));

		// this.element.on('transitionend webkitTransitionEnd',self.options.partOne, function(evt){
		// }).on('click', '.next a', $.proxy(this.next, this))
		//   .on('click', '.prev a', $.proxy(this.prev, this));
	},
	start: function(){
		var self = this, slideOffset = 0;
		this._slides.addClass('arrive').each(function(i){
			//calculate delay based on the slides position in the dom
			var delay = i * parseFloat($(this).css('transition-delay').replace('s', ''));
			$(this).css({
				'-webkit-transition-delay' : delay + 's',
				'-moz-transition-delay' : delay + 's',
				'transition-delay' : delay + 's',
				'left' : self._leftBoundary + (i * slideOffset)
			});
			slideOffset = $(this).outerWidth(true);
		});
	},
	next: function(evt){
		
	},
	prev: function(evt){
		
	},
	_slides: null,
	_leftBoundary: 0,
	_setOption: function(key, value){
		// switch(key){
			// case 'current':
			// break;
		// }
		this.options[key] = value;
		// In jQuery UI 1.8, you have to manually invoke the _setOption method from the base widget
      	$.Widget.prototype._setOption.apply( this, arguments );
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
 		frame: '.inner'
	}
});

$.extend($.cmist.filmslide, {
  version: "0.1"
});
})(this.jQuery);