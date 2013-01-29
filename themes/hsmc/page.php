<?php
/**
 * The general page template
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post();?>
<div class="hero">
	<div class="inner">

		<h2 class="h1"><?php the_title() ?></h2>
	</div>	
</div>
<div class="content"> 
	<div class="inner clearfix">
		<div class="left-col">
			<?php the_post_thumbnail('article-hero' , array('class' => 'hero-img')); ?>
			<?php the_content(); ?>	
		</div>
	</div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>
