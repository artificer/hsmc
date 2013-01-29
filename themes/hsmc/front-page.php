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
<div class="services clearfix">
	<section class="inner">
		<h1 class="fancy-header">Our Group</h1>
		<p class="intro h1">
			<strong>We care for your pregnancy</strong> with our personal <strong>private maternity services</strong>
		</p>
		<div class="service">
			<a href="<?php echo home_url('/consultants')?>">
				<img class="service-thumb" src="<?php echo get_bloginfo('template_url')?>/img/doctors.jpg"/>
			</a>

			<h2><a href="<?php echo home_url('/consultants')?>">Our Doctors</a></h2>
			<p>
				We are a team of consultants here to provide the very best in private maternity care.
			</p>
		</div>
		<div class="service">
			<a href="<?php echo site_url('/hospital')?>">
				<img class="service-thumb" src="<?php echo get_bloginfo('template_url')?>/img/hospitals.jpg"/>
			</a>
			<h2><a href="<?php echo site_url('/hospitals')?>">Our Hospitals</a></h2>
			<p>
				We have delivering privileges at some of the top private and NHS hospitals in London assuring you
				and your baby of excellent medical care
			</p>
		</div>
		<div class="service">
			<a href="<?php echo site_url('/rooms')?>">
				<img  class="service-thumb" src="<?php echo get_bloginfo('template_url')?>/img/rooms.jpg"/>
			</a>
			<h2><a href="<?php echo site_url('/rooms')?>">Our Rooms</a></h2>
			<p>
				Our modern and comfortable consulting rooms are conveniently located in Harley Street, central
				London where we also have access to a state of the art private scanning rooms
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
			<a href="<?php echo home_url( '/contact' ) ?>" class="h1 btn-big">
				Book your free first consultation now
			</a>
			<div class="about-exc">
				<h3 class="h1">Our Services</h3>
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
<div class="slider-captions">
	<?php echo $caption_html; ?>
</div>
<?php
	
	get_footer(); 
?>