<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="<? bloginfo('charset');?> ">
  
  	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
     Remove this if you use the .htaccess -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
	
		// Add the blog name.
		bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
	
		?></title>

	<!-- Mobile viewport optimized: j.mp/bplateviewport -->
  	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  	<meta name="viewport" content="width=device-width">
  	<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->

  	<script type="text/javascript" src="//use.typekit.net/yoo2qup.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri() ?>/css/normalize.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  	<script src="<?php bloginfo('template_url'); ?>/js/vendor/modernizr-2.6.2.min.js"></script>
	  
	<?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>

</head>

<body <?php body_class(); ?>>
	<header>
		<div class="inner clearfix">
			<h1 class="site-title ir"><?php bloginfo('name', 'Display')?></h1>
			<?php wp_nav_menu( array( 
				'theme_location' => 'primary', 
				'container' => 'nav'
			)); ?>
		</div>
	</header>	