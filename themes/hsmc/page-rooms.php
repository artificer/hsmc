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
		<p class="intro">Our modern and comfortable consulting rooms have all the facilities required for your private antenatal care including a state of the art ultrasound clinic</p>
	</div>	
</div>
<div class="content"> 
	<div class="inner clearfix">
		<div class="left-col">
			<?php the_post_thumbnail('article-hero' , array('class' => 'hero-img')); ?>
			<?php the_content(); ?>
		</div>
		<div class="sidebar right-col col-wrap">
			<section class="gallery clearfix">
				<h1>Gallery</h1>
				<?php
					if($imgs = get_attached_imgs(get_the_ID(), 'index-thumb')):		
						foreach ($imgs as $img):
							$full_src = wp_get_attachment_image_src($img['id'], 'large');
				?>
					<a href="<?php echo $full_src[0] ?>" rel="shadowbox[rooms]">
						<img src="<?php echo $img['src']?>" class="gallery-thumb"/>
					</a>

				<?php endforeach; endif; ?>
			</section>
		</div>
	</div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>
