<?php
/**
 * The index template file for the Hospital custom post type.
 *
 * This file will be responsible for displaying all the hospitals
 * on the sire
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
		<p class="intro">
			Lorem ipsum dolor sit amet, consectetur adipisicing eli Lorem ipsum 
			dolor sit amet, consectetur adipisicing sit amet, consectetur 
			adipisicing.
		</p>
	</div>
</div>
<div class="content "> 
	<section class="inner clearfix">
		<h1>Hospitals</h1>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class('hospital-short media') ?> >
				<a href="<?php the_permalink() ?>" class="img">
					<?php the_post_thumbnail('index-thumb' , array('class' => 'thumb')) ?>
				</a>
				
				<div class="bd">
					<div class="bd-mask">
						<h2>
							<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
						</h2>
						<?php the_excerpt(); ?>
					</div>
					<a class="btn-secondary" href="<?php the_permalink() ?>">Read more</a>
				</div>

			</article>
		<?php endwhile; endif; ?>
	</section>
</div>	


<?php get_footer(); ?>
