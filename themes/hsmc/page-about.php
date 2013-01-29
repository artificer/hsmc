<?php
/**
 * The template for the About Us page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post();?>
<div class="slider hero">
	<div class="inner">
		<?php
			$docs = get_users(array('role' => 'doctor'));
			$mids = get_users(array('role' => 'midwife'));

			$caption_html = "";

			$staff = array_merge($docs, $mids);
			shuffle($staff);
			foreach ($staff as $clinician):
				$data = get_user_meta($clinician->ID);
				$role = array_keys(unserialize($data['wp_capabilities'][0]));
				// Debug_Bar_Extender::instance()->trace_var($data);
				// Debug_Bar_Extender::instance()->trace_var($role);
		?>
		<div class="slide" id="slide-<?php echo $clinician->ID ?>">
			<h2><?php echo $clinician->display_name ?></h2>
			<img class="slide-img" src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($clinician->display_name)?>"/>
		</div>
		<?php 
			$caption_html .= hsmc_slide_caption(
				$clinician->display_name, 
				limit_words($data['description'][0], 25),
				"slide-{$clinician->ID}",
				get_author_posts_url($clinician->ID),
				$role[0]
			);
			endforeach;
		?>
	</div>
</div>
<div class="content"> 
	<div class="inner clearfix">
		<div class="left-col">
			<?php the_content(); ?>
		</div>
	</div>
</div>
<?php endwhile; ?>
<div class="slider-captions">
	<?php echo $caption_html; ?>
</div>

<?php get_footer(); ?>
