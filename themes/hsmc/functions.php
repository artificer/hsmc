<?php 
/**
 * BassJunk functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 1.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since HSMC 1.0
 */
function hsmc_setup() {
	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	// set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
	
	/*
	 * NOTE: The size only works for newly uploaded images. If changed the thumbnails 
	 * are gonna have to be resized, there is a plugin for that apparently... 
	 */
	add_image_size( 'index-thumb', 216, 216, true); // Permalink thumbnail size
	add_image_size( 'article-hero', 588, 288, true); // Permalink thumbnail size
	
	if ( function_exists( 'register_nav_menu' ) ) {
    	register_nav_menu( 'primary', __( 'Primary Menu', 'hsmc' ) );
  	}
}
/** Tell WordPress to run actor_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'hsmc_setup' );

/**
 * Registers our footer widget area.
 *
 * @since HSMC 1.1
 */
function hsmc_widgets_init() {
	$args = array(
		'name'          => __( 'Footer Widgets', 'hsmc' ),
		'id'            => 'footer-widgets',
		'description'   => '',
        'class'         => 'hsmc-side',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle visuallyhidden">',
		'after_title'   => '</h2>' );

	register_sidebar($args);
}
add_action( 'widgets_init', 'hsmc_widgets_init' );

/**
 * Sets up custom post types for the site
 * 
 * @uses register_post_type() To add suppost for custom post types
 */
function create_post_type() {
	register_post_type( 'hospital', array(
      'labels' => array(
        'name' 				=> _x('Hospitals', 'post type general name' ),
		'singular_name' 	=> _x('Hospital', 'post type singular name'),
		'add_new'			=> _x('Add New', 'hospital'),
		'add_new_item'		=> __('Add New Hospital'),
		'new_item'			=> __('New Hospital'),
		'view_item'			=> __('View Hospital'),
		'edit_item'			=> __('Edit Hospital'),
		'parent_item_colon'	=> ''
      ),
	  'show-ui'	        => true,
	  'rewrite'         => array('slug' => 'hospital'),
	  'capability_type' => 'post',
	  'supports'        => array(
		  'title',
		  'editor',
      	  'thumbnail',
      	  'excerpt'
	   ),
  	   'public'         => true,
  	   'has_archive'    => true
    )
  );
}
/** Tell WordPress to run create_post_type() when the 'init' hook is run. */
add_action( 'init', 'create_post_type' );

function my_class_names($classes) {
	// add 'class-name' to the $classes array
	if(is_page('hospital') || is_post_type_archive('hospital'))
		$classes[] = 'hospitals';
	elseif(is_singular('post'))
		$classes[] = 'blog';
	elseif (is_page('consultants')) 
		$classes[] = 'doctors';
		
	// return the $classes array
	return $classes;
}
// Add specific CSS to the body element class by filter
add_filter('body_class','my_class_names');

function current_type_nav_class($classes, $item) {
    $post_type = get_post_type();
    if ($item->attr_title != '' && $item->attr_title == 'Hospitals' 
    	&& $post_type == 'hospital') {
        array_push($classes, 'current-menu-item');
    };
    return $classes;
}
//Add specific CSS to menu items, useful if we need archive pages in the main menu 
add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2 );

function enqueue_front_scriptstyles(){
	wp_deregister_script('jquery');
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', false, false, true);
	wp_enqueue_script('plugins', get_bloginfo('template_url').'/js/plugins.js', array('jquery'), false, true);
	
	if (is_front_page())
		wp_enqueue_script('main', get_bloginfo('template_url').'/js/main.js', array('plugins', 'jquery-ui-core', 'jquery-ui-widget'), false, true);
	else
		wp_enqueue_script('main', get_bloginfo('template_url').'/js/main.js', array('plugins'), false, true);

	wp_enqueue_style('shadowbox', get_bloginfo('template_url').'/css/shadowbox/shadowbox.css');

}
add_action('wp_enqueue_scripts', 'enqueue_front_scriptstyles');


function get_attached_imgs($pid, $size){
	$imgs = array();
	$images =&get_children( 'post_parent='.$pid.'&post_type=attachment&post_mime_type=image&orderby=menu_order&order=ASC' );
	
	if($images == false){
		//A project always has to have at least one image associated with it as
		//every project needs at least a hero shot 
		return false;
	}

	foreach ($images as $img){
		$tmp = wp_get_attachment_image_src($img->ID, $size);
		$imgs[] = array(
			'id'		=> $img->ID,
			'src' 		=> $tmp[0],
			'width'		=> $tmp[1],
			'height'	=> $tmp[2]
		);
	}
	return $imgs;
}

/* Adds a box to the main column on the Post and Page edit screens */
function add_address_box() {
    add_meta_box( 
        'hsmc_address',
        __( 'Location', 'hsmc' ),
        'hsmc_address_box',
        'hospital',
        'normal',
        'low'
    );
}
add_action( 'add_meta_boxes', 'add_address_box' );

/* Prints the box content */
function hsmc_address_box( $post ) {
  $custom = get_post_custom($post->ID);
  $location = isset($custom['location']) ? unserialize($custom['location'][0]) : array();
  wp_nonce_field( 'hsmc_location', 'hsmc_adressnonce' );
  ?>
	<div>
		<h4>Address</h4>
		<textarea name="location[address]"><?php echo esc_textarea($location['address']) ?></textarea>
	</div>  
  	<div>
  		<h4>Map Embed Code</h4>
  		<textarea name="location[map]"><?php echo esc_textarea($location['map']) ?></textarea>
  	</div>
  
  <?php
}

/**
 * Saves custom fields for enabled post_types
 * @uses update_post_meta To update additional meta fields
 * @return 
 */
function hsmc_save_location($post_id){
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
    	!wp_verify_nonce( $_POST["hsmc_adressnonce"], 'hsmc_location')){
        return;
    }
	
	// print_r($_POST);
    if (isset($_POST['location'])) {
    	/* Request passes all checks; update the post's metadata */
        update_post_meta($post_id, 'location', $_POST['location']);
    } else{
    	delete_post_meta($post_id, 'location' );
    }
}
/* Do something with the data entered */
add_action( 'save_post', 'hsmc_save_location' );


/*********************************************
 * TODO: Put in a separate plugin file
 *********************************************/

/**
 * Remove all the unnecessary contact fields from the user
 * admin pages	
 */
function new_contactmethods( $contactmethods ) {
    unset($contactmethods['yim']); // Remove YIM
    unset($contactmethods['aim']); // Remove AIM
    unset($contactmethods['jabber']); // Remove Jabber
    unset($contactmethods['website']);
    return $contactmethods;
}
add_filter('user_contactmethods','new_contactmethods',10,1);   

/*
 * Adds the form elements which will allow the users to add an externally
 * hosted video and a profile pic to their profile
 */
function hsmc_user_profile($user) {
	$userpic_url = get_the_author_meta('userpic', $user->ID);
	$uservid_code = get_the_author_meta('uservid', $user->ID );
	$user_tmonial = get_the_author_meta('usertmonial', $user->ID);
	log_me($user_tmonial);
    ?>
    <h3>User Media</h3>
    <table class="form-table">
    	<tbody>
    		<tr>
	    		<th><label for="userpic">Profile Image</label></th>
	    		<td>
	    			<input id="userpic" type="hidden" name="userpic" value="<?php echo esc_url($userpic_url);?>" />
	    			<input type="button" class="button userpic-upload" value="<?php _e( 'Upload Image', 'hsmc' ); ?>"/>
	    			<?php if ( '' != $userpic_url): ?>
						<input name="submit" id="userpicRemove" type="submit" class="button" value="<?php _e('Remove Image', 'hsmc'); ?>" />
					<?php endif; ?>
	    			<span>Upload an image from your computer</span>
					<div id="userpicPreview" class="userpic-preview">
						<img src="<?php echo esc_url($userpic_url); ?>" />
					</div>
	    		</td>
    		</tr>
    		<tr>
	    		<th><label for="uservid">Profile Video</label></th>
	    		<td>
	    			<textarea name="uservid" id="uservid" rows="5" cols="30"><?php echo esc_textarea( $uservid_code ); ?></textarea>
	    		</td>
    		</tr>
    	</tbody>
    </table>
    <h3>User Testimonial</h3>
    <table class="form-table">
    	<tbody>
    		<tr>
	    		<th><label for="userpic">Testimonial</label></th>
	    		<td>
	    			<textarea name="usertmonial[text]" id="usertmonial_text" rows="5" cols="30"><?php echo esc_textarea( $user_tmonial['text']); ?></textarea>
	    		</td>
    		</tr>
    		<tr>
    			<th><label for="userpic">Testimonial Source</label></th>
    			<td>
    				<input type="text" name="usertmonial[source]" id="usertmonial_source" value="<?php echo esc_attr($user_tmonial['source']) ?>" />
	    		</td>
    		</tr>
	    </tbody>
	</table>
    <?php
}
add_action('edit_user_profile','hsmc_user_profile');   
add_action('show_user_profile','hsmc_user_profile');

/**
 * Saves the user media data when the user profile has been updated 
 * 
 * @uses hsmc_delete_image() To delete the image from the WP database and
 */
function hsmc_save_extra_profile_fields( $user_id ) {
	// Debug_Bar_Extender::instance()->checkpoint('Saving Profile');
	// Debug_Bar_Extender::instance()->trace_var($_POST);
	// log_me($_POST);
	
	$userpic_url = $_POST['userpic'];
	$delete_img = $_POST['submit'] == "Remove Image" ? true : false;
	if ($delete_img) {
		hsmc_delete_image($userpic_url);
		$userpic_url = '';
	}

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'uservid' to the field ID. */

	update_user_meta($user_id, 'uservid', $_POST['uservid']);
	update_user_meta($user_id, 'userpic', $userpic_url);
	update_user_meta($user_id, 'usertmonial', $_POST['usertmonial']);
}   
add_action( 'personal_options_update', 'hsmc_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'hsmc_save_extra_profile_fields' );

function hsmc_delete_image( $image_url ) {
	global $wpdb;
	// We need to get the image's meta ID.
	$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";
	$results = $wpdb->get_results($query);
	// And delete it
	foreach ( $results as $row ) {
		wp_delete_attachment( $row->ID );
	}
}

function hsmc_options_enqueue_scripts() {		
	wp_register_script( 'hsmc-upload', get_template_directory_uri() .'/js/hsmc-upload.js', array('jquery','media-upload','thickbox') );
	if(get_current_screen()->id == "user-edit"){
		wp_enqueue_style('thickbox');
		wp_enqueue_script('hsmc-upload');
	}
}
add_action('admin_enqueue_scripts', 'hsmc_options_enqueue_scripts');

function hsmc_options_setup() {
	global $pagenow;
	if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
		// Now we'll replace the 'Insert into Post Button' inside Thickbox
		add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
	}
}
add_action( 'admin_init', 'hsmc_options_setup' );

function replace_thickbox_text($translated_text, $text, $domain) {
	if ('Insert into Post' == $text) {
		$referer = strpos( wp_get_referer(), 'user-edit' );
		if ( $referer != '' ) {
			return __('Set the profile image!', 'hsmc' );
		}
	}
	return $translated_text;
}


// function hsmc_options_validate( $input ) {
// 	$default_options = hsmc_get_default_options();
// 	$valid_input = $default_options;
// 	$submit = ! empty($input['submit']) ? true : false;
// 	$reset = ! empty($input['reset']) ? true : false;
// 	if ( $submit )
// 		$valid_input['logo'] = $input['logo'];
// 	elseif ( $reset )
// 		$valid_input['logo'] = $default_options['logo'];
// 	return $valid_input;
// }
function my_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="' .get_template_directory_uri(). '/wp-admin.css">';
}
add_action('admin_head', 'my_admin_head');
 
function my_admin_menu() {
     remove_menu_page('link-manager.php');
}
add_action( 'admin_menu', 'my_admin_menu' );

add_action('wp_dashboard_setup', 'my_dashboard_widgets');
function my_dashboard_widgets() {
     global $wp_meta_boxes;
     // remove unnecessary widgets
     // print_r( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
     unset(
          $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
          $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'],
          $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'],
          $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
          $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
     );
     // add a custom dashboard widget
     // wp_add_dashboard_widget( 'dashboard_custom_feed', 'Sigma DAC News', 'dashboard_custom_feed_output' ); //add new RSS feed output
}

/***
 * Rebrand Wordpress
 **/
function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/wp-admin.css" />';
}
add_action('login_head', 'my_custom_login');

add_filter( 'admin_footer_text', 'my_admin_footer_text' );
function my_admin_footer_text( $default_text ) {
     return '<span id="footer-thankyou">Website managed by <a href="http://thebigagency.net">The BiG Agency</a><span> | Powered by <a href="http://www.wordpress.org">WordPress</a>';
}

function new_wp_login_url() {
    echo bloginfo('url');
}

function new_wp_login_title() {
    echo 'Powered by ' . get_option('blogname');
}

add_filter('login_headerurl', 'new_wp_login_url');
add_filter('login_headertitle', 'new_wp_login_title');
/** END REBRAND WP LOGIN **/

function log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}