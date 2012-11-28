<?php
/*
Plugin Name: User Tags
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Enables posts to be "tagged" with registered users with a particular role thus enabling WordPress to have multiple users/authors associated with a single post
Version: 0.1
Author: Milos Soskic (Citrus Mist)
Author URI: http://citrus-mist.com
License: GPL2
*/

class User_Tags{
    function __construct() {
        register_activation_hook( __FILE__, array( &$this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

		add_action( 'add_meta_boxes', array( &$this, 'user_tag_meta_box'));
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_usertags_scripts' ), 10);
		add_action( 'save_post', array(&$this,'save_user_tags'));
    }

    function activate() {
    	add_option( 'user_tags_enabled', true);

    	$caps = array(
			'read'                   => true,
			'publish_posts' 		 => true,
			'delete_posts' 		     => true,
			'delete_published_posts' => true,
			'edit_published_posts' 	 => true,
			'edit_posts'			 => true,
			'upload_files' 			 => true
		);

		$doctor = add_role( 'doctor', 'Doctor', $caps);
		$midwife = add_role( 'midwife', 'Midwife', $caps);
	} // end activate

	function deactivate() {
		remove_role('doctor');
		remove_role('midwife');
	    delete_option( 'user_tags_enabled' );
	} // end deactivate

	function user_tag_meta_box(){
	  add_meta_box("userTags", "User Tags", array(&$this, "render_meta_box"), "hospital", "normal", "low");
	}

	function enqueue_usertags_scripts($handle){
		if(get_current_screen()->post_type == 'hospital'){
			//meta boxes seem to be generated via dynamic javascript so we include our scirpt at the bottom of the page after the meta box has been created
			wp_register_script(
				'user-tags-edit', 
				plugins_url('/js/usertagsedit.js', __FILE__), 
				array('jquery-ui-draggable','jquery-ui-droppable'), 
				false, 
				true
			);
			wp_enqueue_script('user-tags-edit');
		}
	}

	function render_meta_box($the_post){
		$custom = get_post_custom($the_post->ID);
		log_me($custom);
  		$user_tags = isset($custom['user_tags']) ? unserialize($custom['user_tags'][0]) : array();
		// log_me($user_tags);

		if(empty($user_tags)){
			$assigned_users = array();
    	}else{
	    	$assigned_users = get_users(array(
    			"include" => $user_tags,
    			"role"	  => 'doctor'	
    		));
    	}
  		// foreach ($user_tags as $user_tag) {
  		// 	$user_tag = json_decode($user_tag);
  		// 	//TODO: instead of calling get_user_by individually we could obtain all the users by passing
  		// 	//an array of ID's to the get_users() function
  		// 	if(isset($user_tag->id))
  		// 		$assigned_users[$user_tag->id] = get_user_by('id', $user_tag->id);
  		// }
  		// log_me($assigned_users);

    	$avail_users = get_users(array(
    			'exclude' => $user_tags,
    			"role"	  => 'doctor'
    		));
  		
    	$labels = get_post_type_object( get_current_screen()->post_type )->labels;
  		?>

 		<div class="user-tags-wrap clearfix">
	  		<div class="user-tags-available">
	  			<h4>Available Users</h4>
	  			<ul class="plain-list user-available" id="usersAvailable">
	  			<?php foreach ($avail_users as $user): ?>

	  				<li class="user-tag" data-username="<?php echo esc_attr($user->user_login)?>" data-userid="<?php echo esc_attr($user->ID)?>">
	  					<?php echo $user->display_name; ?>
	  				</li>

	  			<?php endforeach; ?>
	  			</ul>
	  		</div>
	  		<div class="user-tags-assigned">
	  			<h4>Assigned Users</h4>
	  			<ul class="plain-list user-assigned" id="usersAssigned" >
  				<?php foreach ($assigned_users as $user): ?>
	  				<li class="user-tag" data-username="<?php echo esc_attr($user->user_login)?>" data-userid="<?php echo esc_attr($user->ID)?>">
	  					<?php echo $user->display_name ?>
	  					<input type="hidden" name="user_assigned[]" class="user-tags-input" value='<?php echo esc_attr($user->ID)?>'/>
	  				</li>
	  			<?php endforeach; ?>	
	  			</ul>
	  		</div>
	  		<p class="user-tags-description">
	  			Drag users from <em>Available Users</em> to <em>Assigned Users</em> in order to associate them with this <?php echo $labels->singular_name ?>
	  		</p>
  		</div>
  		<?php wp_nonce_field(get_current_theme(),'user_tags_nonce'); ?>
  		<?php
	}

	/**
	 * Saves custom fields for enabled post_types
	 * @uses update_post_meta To update additional meta fields
	 * @return 
	 */
	function save_user_tags($post_id){
		//Taken from http://codex.wordpress.org/Plugin_API/Action_Reference/save_post	  
	  	$slug = 'hospital';

	    /* check whether anything should be done */
	    // $_POST += array("{$slug}_edit_nonce" => get_current_theme());
	    if ( !isset($_REQUEST['post_type']) || $slug != $_REQUEST['post_type'] ) {
	        return;
	    }
		
	    if ( !current_user_can( 'edit_post', $post_id ) ) {
	        return;
	    }
		
	    if (!isset($_POST["user_tags_nonce"]) || 
	    	!wp_verify_nonce( $_POST["user_tags_nonce"], get_current_theme())){
	        return;
	    }
		
		// print_r($_POST);
	    if (isset($_REQUEST['user_assigned'])) {
	    	/* Request passes all checks; update the post's metadata */
	        update_post_meta($post_id, 'user_tags', $_REQUEST['user_assigned']);
	    } else{
	    	delete_post_meta($post_id, 'user_tags' );
	    }
	}
}
new User_Tags();
?>