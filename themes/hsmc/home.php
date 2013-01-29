<?php
/**
 * The blog template file.
 *
 * This is the template for the blog index page
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
	<div class="inner clearfix "> 
		<div class="left-col blog-index	"> 
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class() ?> >
				<h1 class="article-header">
					<a href="<?php the_permalink()?>"><?php the_title() ?></a>
				</h1>
				<div>
					<span class="time">
						Date: <b><?php the_time('F j, Y') ?></b>
					</span>
					<span class="author-name">
						Author: <b><?php the_author() ?> </b>
					</span>
				</div>
				<?php the_post_thumbnail('article-hero' , array('class' => 'hero-img')) ?>
				<?php the_content() ?>
			</article>
			<?php endwhile; endif; ?>
		</div>

		<div class="sidebar right-col col-wrap"> 
			<section class="clearfix col-inner">
				<h1>Categories</h1>
				<ul class="plain">
					<?php 
						echo wp_list_categories(array(
							'title_li' => ''
						)) 
					?>
				</ul>
			</section>
		</div>
	</div>
</div>

<?php get_footer(); ?>
