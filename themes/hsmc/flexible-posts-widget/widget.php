<?php
/**
 * Flexible Posts Widget: Default widget template
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;

if ( !empty($title) )
	echo $before_title . $title . $after_title;

if( $flexible_posts->have_posts() ):

?>
	<ul class="dpe-flexible-posts">
	<?php while ( $flexible_posts->have_posts() ) : $flexible_posts->the_post(); ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix')); ?>>
			<a href="<?php echo the_permalink(); ?>">
				<?php
					if( $thumbnail == true )
						the_post_thumbnail( $thumbsize );
				?>
				<div class="hentry-wrap">
					<h4 class="title"><?php the_title(); ?></h4>
					
				</div>
			</a>
		</li>
	<?php endwhile; ?>
	</ul><!-- .dpe-flexible-posts -->
<?php else: // We have no posts ?>
	<div class="dpe-flexible-posts no-posts">
		<p>No post found</p>
	</div>
<?php	
endif; // End have_posts()
	
echo $after_widget;
?>