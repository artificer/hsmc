<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

get_header(); ?>
<div class="slider hero">
	<?php
		$docs = get_users(array(
			'role' => 'doctor'
		));
		$mids = get_users(array(
			'role' => 'midwife'
		));

		$staff = array_merge($docs, $mids);
		shuffle($staff);
		foreach ($staff as $clinician):
			$data = get_user_meta($clinician->ID);
			$role = array_keys(unserialize($data['wp_capabilities'][0]));
			// Debug_Bar_Extender::instance()->trace_var($data);
			// Debug_Bar_Extender::instance()->trace_var($role);
	?>
	<div class="slide">
		<h3><?php echo $clinician->display_name ?></h3>
		<img src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($clinician->display_name)?>"/>
		<div class="slide-caption">
			<h4>About the doctor:</h4>
			<p><?php echo $data['description'][0]?></p>
			<a href="<?php echo get_author_posts_url($clinician->ID)?>"> View <?php echo $role[0]?> profile</a>
		</div>
	</div>
	<?php 
		endforeach;
	?>
	<span class="slider-next">next</span>
	<span class="slider-prev">prev</span>
</div>

<?php get_footer(); ?>
