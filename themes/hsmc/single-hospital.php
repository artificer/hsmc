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

get_header(); 
$custom = get_post_custom(get_the_ID());
$location = isset($custom['location']) ? unserialize($custom['location'][0]) : array();
$docs = isset($custom['user_tags']) ? unserialize($custom['user_tags'][0]) : array();
?>
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
			<div class="article-content">
				<?php the_content() ?>
			</div>

			<section>
				<h1 class="h2">Consultants at this hospital</h1>
				
				<ul class="plain inline doc-list--short clearfix">
				<?php
					$docs = get_users(array('role' => 'doctor'));
					foreach ($docs as $doc):
						$data = get_user_meta($doc->ID);
						$profile_url = get_author_posts_url($doc->ID);
				?>
					<li class="media">
						<div class="media-wrap clearfix">
							<a href="<?php echo $profile_url  ?>" class="img">
								<img src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($doc->display_name)?>" class="thumb"/>
							</a>
							<div class="bd">
								<div class="bd-mask">
									<h2>
										<a href="<?php echo $profile_url ?>"><?php echo $doc->display_name ?></a>
									</h2>
								
									<p><?php echo $data['description'][0]?></p>
								</div>
								<a href="<?php echo $profile_url  ?>" class="btn-teritary">View Profile</a>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
			</section>
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
			<section class="location col-inner">
				<h1>Location</h1>
				<?php 					
  					echo (isset($location['map']) ? $location['map'] : '');
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
