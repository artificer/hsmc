jQuery(document).ready(function($) {
	$('.userpic-upload').click(function() {
		tb_show('Upload Profile Picture', 'media-upload.php?referer=user-edit&type=image&TB_iframe=true&post_id=0', false);
		return false;
	});

	window.send_to_editor = function(html) {
		var image_url = jQuery('img',html).attr('src');
		jQuery('#userpic').val(image_url);
		tb_remove();
		$('#userpicPreview img').attr('src',image_url);
		$('#submit_options_form').trigger('click');
	}

});
