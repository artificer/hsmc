jQuery(document).ready(function(){
	jQuery("a[rel^='sInstRecentMediaWid']").prettyPhoto({
  		autoplay_slideshow: sInst.auto_play,
  		social_tools:false,
  		theme: sInst.theme
  	});
  	
  	$('.front-widget-area').masonry({
  		itemSelector: '.widget',
  		columnWidth: 336
  	});
});
