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
		<h2 class="h1">Our Doctors</h2>
		<p class="intro">
			Lorem ipsum dolor sit amet, consectetur adipisicing eli Lorem ipsum 
			dolor sit amet, consectetur adipisicing sit amet, consectetur 
			adipisicing.
		</p>
	</div>
</div>
<div class="content "> 
	<section class="inner clearfix">
		<h1>Doctors</h1>
		<ul class="plain inline doc-list">
		<?php
			$docs = get_users(array('role' => 'doctor'));
			foreach ($docs as $doc):
				$data = get_user_meta($doc->ID);
				$profile_url = get_author_posts_url($doc->ID);
		?>
			<li class="media">
				<a href="<?php echo $profile_url  ?>" class="img">
					<img src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($doc->display_name)?>" class="thumb"/>
				</a>
				<div class="bd">
					<div class="bd-mask">
						<h2 class="h3">
							<a href="<?php echo $profile_url ?>"><?php echo $doc->display_name ?></a>
						</h2>
					
						<p><?php echo $data['description'][0]?></p>
					</div>
					<a href="<?php echo $profile_url  ?>" class="btn-secondary">View Profile</a>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
	</section>
</div>	


<?php get_footer(); ?>
