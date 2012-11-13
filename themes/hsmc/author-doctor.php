<?php 
	global $clinician;
	global $data;
?>

<div class="hero">
	<div class="inner">
		<img class="profile-pic" src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($clinician->display_name)?>" />
		<p class="quote">Dr Nichols was amazing, his care was second to none <span class="source">Michelle Friedman</span></p>
	</div>
</div>

<div class="content">
	<div class="inner clearfix">
		<div class="left-col">
			<section class="video">
				<h1>Video</h1>
				<?php echo $data['uservid'][0];?>
			</section>
			<section class="blog">
				<h1>Latest Blog</h1>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<article <?php post_class() ?> >
						<h2><?php the_title() ?></h2>
						<?php the_excerpt(); ?>
					</article>
				<?php endwhile; endif; ?>
			</section>
		</div>
		<div class="right-col">
			<div class="col-wrap">
				<section class="">
					<h1><?php echo $clinician->display_name ?></h1>
					<?php echo apply_filters('the_content', $data['description'][0])?>
				</section>
				<section class="">
					<h1> Fees / Availability </h1>
				</section>
			</div>
			<section class="hospital">
			</section>

		</div>
	</div> <!-- end of .inner -->
</div>