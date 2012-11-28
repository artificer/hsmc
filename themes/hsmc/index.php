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
		<h2><?php echo $clinician->display_name ?></h2>
		<img src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($clinician->display_name)?>"/>
		<div class="slide-caption hidden">
			<h3 class="h2">
				<?php echo esc_attr($clinician->display_name)?>
				<span class="slide-caption-close"></span>
			</h3>
			<div class="slide-caption-body">
				<h4>About the <?php echo $role[0]?>:</h4>
				<p><?php echo limit_words($data['description'][0], 25)?></p>
				<a class="btn-teritary" href="<?php echo get_author_posts_url($clinician->ID)?>">
					View <?php echo $role[0]?> profile
				</a>
			</div>
		</div>
	</div>
	<?php 
		endforeach;
	?>
	<span class="slider-next">next</span>
	<span class="slider-prev">prev</span>
</div>
<div class="services clearfix">
	<section class="inner">
		<h1 class="fancy-header">Our Services</h1>
		<p class="intro h1">
			We offer a <strong>bespoke consultancy</strong> service for <strong>your pregnancy</strong>.
		</p>
		<div class="service">
			<img  class="service-thumb" src="<?php echo get_bloginfo('template_url')?>/img/rooms.jpg"/>
			<h2>Our Rooms</h2>
			<p>
				The Harley Maternity Group is a dedicated team of private consultants 
				working together to provide the best in private maternity care.
			</p>
		</div>
		<div class="service">
			<img class="service-thumb" src="<?php echo get_bloginfo('template_url')?>/img/hospitals.jpg"/>
			<h2><a href="<?php echo site_url('/hospitals')?>">Our Hospitals</a></h2>
			<p>
				The Harley Maternity Group is a dedicated team of private consultants 
				working together to provide the best in private maternity care.
			</p>
		</div>
		<div class="service">
			<img class="service-thumb" src="<?php echo get_bloginfo('template_url')?>/img/doctors.jpg"/>
			<h2><a href="<?php echo site_url('/doctors')?>">Our Doctors</a></h2>
			<p>
				The Harley Maternity Group is a dedicated team of private consultants 
				working together to provide the best in private maternity care.
			</p>
		</div>
	</section>
</div>
<div class="content ">
	<div class="inner clearfix">
		<div class="left-col">
			<section class="blog">
				<h1 class="fancy-header">Latest Blog</h1>
				<?php 
					global $post;
					$args = array( 'numberposts' => 3 );
					$myposts = get_posts( $args );
					foreach( $myposts as $post ) :	setup_postdata($post); 
				?>
					<article <?php post_class() ?> >
						<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
				<?php endforeach; ?>
				<a class="btn-secondary" href="<?php echo site_url('/blog') ?>">View All</a>
			</section>
		</div>

		<div class="right-col">
			<a class="btn-big h1">
				Start your journey with us
			</a>
			<div class="about-exc">
				<h3 class="h1">Harley maternity group</h3>
				<p>
					The Harley Maternity Group is a dedicated team of private consultants 
					working together to provide the best in private maternity care.
				</p>
				<p>
					Our consulting rooms are conveniently located on Harley Street in
					central London, and delivery of your baby can be booked into the private 
					wing at one of several top London hospitals. <a href="<?php echo site_url('/about')?>">Read More</a>
				</p>
			</div>

		</div>
	</div>
</div>
<?php get_footer(); ?>
