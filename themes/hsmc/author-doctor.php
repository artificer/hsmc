<?php 
	global $clinician;
	global $data;
?>

<div class="hero">
	<div class="inner">
		<img class="profile-pic" src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($clinician->display_name)?>" />
		<p class="quote">
			<?php echo esc_html($data['usertmonail']['text'])?> 
			<span class="source">– <?php echo esc_html($data['usertmonail']['text']) ?></span>
		</p>
	</div>
</div>

<div class="content">
	<div class="inner clearfix">
		<div class="left-col">
			<section class="video">
				<h1 class="fancy-header">Video</h1>
				<?php echo $data['uservid'][0];?>
			</section>
			<section class="blog">
				<h1 class="fancy-header">Latest Blog</h1>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<article <?php post_class() ?> >
						<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
				<?php endwhile; endif; ?>
			</section>
		</div>
		<div class="right-col">
			<div class="col-wrap">
				<section class="author-profile">
					<h1><?php echo $clinician->display_name ?></h1>
					<div class="author-desc">
						<?php echo apply_filters('the_content', $data['description'][0])?>
					</div>
					<a  class="btn-primary" href="#">Book now</a>
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