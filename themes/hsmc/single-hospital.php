<?php
/**
 * The template for displaying single hospital entries
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

get_header(); ?>
<div class="hero">
	<div class="inner">
		<h2 class="h1">Our Hospitals</h2>
	</div>	
</div>
<div class="content "> 
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('hospital inner clearfix') ?> >
		<div class="left-col"> 
			<h1><?php the_title() ?></h1>
			<?php the_post_thumbnail('article-hero' , array('class' => 'hero-img')) ?>
			<?php the_content() ?>
		</div>

		<aside class="sidebar right-col col-wrap"> 
			<section class="gallery clearfix">
				<h1>Gallery</h1>
				<?php
					if($imgs = get_attached_imgs(get_the_ID(), 'index-thumb')):		
						foreach ($imgs as $img):
							$full_src = wp_get_attachment_image_src($img['id'], 'full');
				?>
					<a href="<?php echo $full_src[0] ?>" rel="shadowbox[hospital]">
						<img src="<?php echo $img['src']?>" class="gallery-thumb"/>
					</a>

				<?php endforeach; endif; ?>
			</section>
			<section class="location">
				<h1>Location</h1>
				<?php 
					$custom = get_post_custom(get_the_ID());
  					$location = isset($custom['location']) ? unserialize($custom['location'][0]) : array();
  					echo isset(var) ? $location['map'] : '';
				?>
				<h2>Address</h2>
				<div>
					<?php echo isset($location['address']) ? nl2br($location['address']) : '' ?>
				</div>
			</section>
		</aside>
	</article>
	<?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
