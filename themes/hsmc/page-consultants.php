<?php
/**
 * The template file for the Doctors page.
 * 
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

get_header(); ?>

<div class="hero">
	<div class="inner">
		<h2 class="h1">Our Consultants</h2>
		<p class="intro">
			Here you can make your choice of private consultant 
			obstetrician who will care for you and your baby before 
			during and after childbirth.
		</p>
	</div>
</div>
<div class="content ">
	<section class="inner clearfix">
		<h1>Consultants</h1>
		<ul class="plain inline doc-list">
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
						<a href="<?php echo $profile_url  ?>" class="btn-secondary">View Profile</a>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
	</section>
</div>	


<?php get_footer(); ?>
