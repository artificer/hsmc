<?php
/**
 * The template for displaying single blog posts
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
		<h2 class="h1">Blog</h2>
	</div>	
</div>
<div class="content "> 
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('inner clearfix') ?> >
		<div class="left-col"> 
			<h1><?php the_title() ?></h1>
			<div>
				<span class="time">
					Date: <b><?php the_time('F j, Y') ?></b>
				</span>
			</div>
			<?php the_post_thumbnail('article-hero' , array('class' => 'hero-img')) ?>
			<?php the_content() ?>
		</div>

		<aside class="sidebar right-col col-wrap"> 
			<section class="gallery clearfix">
				<h1>Author</h1>
				<h2><?php the_author() ?></h2>
			</section>
			<section>
				<h1>Categories</h1>
			</section>
		</aside>
	</article>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
