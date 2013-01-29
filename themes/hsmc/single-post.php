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
			<h1 class="article-header"><?php the_title() ?></h1>
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
		</div>

		<aside class="sidebar right-col col-wrap"> 
			<section class="author-credit clearfix col-inner">
				<?php 
					$data = get_user_meta( get_the_author_meta('ID'));
					$profile_url = get_author_posts_url(get_the_author_meta('ID'));
				?>
				<h1>Author</h1>
				<div class="media">
					<a href="<?php echo $profile_url  ?>" class="img">
						<img src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php the_author() ?>" class="thumb"/>
					</a>
					<div class="bd">
						<div class="bd-mask">
							<h2 class="h3">
								<a href="<?php echo $profile_url ?>"><?php the_author() ?></a>
							</h2>
						
							<p><?php echo $data['description'][0]?></p>
						</div>
						<a href="<?php echo $profile_url  ?>" class="btn-teritary">View Profile</a>
					</div>
				</div>
			</section>
			<section class="col-inner">
				<h1>Categories</h1>
				<?php the_category() ?>
			</section>
		</aside>
	</article>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
