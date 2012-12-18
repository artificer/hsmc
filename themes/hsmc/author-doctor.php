<?php 
	global $clinician;
	global $data;
	$user_tmonial =  (isset($data['usertmonial'][0])) ? unserialize($data['usertmonial'][0]) : null;
?>

<div class="hero">
	<div class="inner">
		<img class="profile-pic" src="<?php echo esc_attr($data['userpic'][0])?>" alt="Portriat of <?php echo esc_attr($clinician->display_name)?>" />
		<p class="quote">
			<?php echo esc_html($user_tmonial['text'])?> 
			<span class="source">– <?php echo esc_html($user_tmonial['source']) ?></span>
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
					<a class="btn-primary btn-booking" href="javascript:void(0)">Book now</a>
				</section>
				<section class="">
					<h1> Fees / Availability </h1>
				</section>
			</div>
			<section class="hospital">
				<h1 class="h2"><?php echo esc_html($clinician->display_name)?> is available at:</h1>
				<?php 
					$args = array(
						'post_type' => 'hospital',
						'meta_query' => array(
							array(
								'key' 	  => 'user_tags',
								'value'	  => serialize(strval($clinician->ID)),
								'compare' => 'LIKE'	
							)
						)
					);
					$posts = get_posts($args);
					Debug_Bar_Extender::instance()->trace_var( $posts);
					foreach ($posts as $post) :  
						setup_postdata($post); 
						$custom = get_post_custom(get_the_ID());
  						$location = isset($custom['location']) ? unserialize($custom['location'][0]) : array();
				?>
				<div class="media">
					<a class="img" href="<?php the_permalink()?>">
						<?php the_post_thumbnail('index-thumb' , array('class' => 'thumb')) ?>
					</a>
					<div class="bd">
						<h2>
							<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
						</h2>
						<p><?php echo isset($location['address']) ? nl2br($location['address']) : '' ?></p>
						<a class="btn-secondary" href="<?php the_permalink() ?>">View hospital</a>
					</div>
				</div>

				<?php 
					endforeach;
				?>
				</ul>
			</section>

		</div>
	</div> <!-- end of .inner -->
	<div class="booking-form-wrap hidden">
		<form method="post" action id="bookingForm" class="booking-form">
			<div class="err-box"></div>
			<label for="userName" class="h3">Clinican’s Name</label>
			<input name="userName" id="userName" type="text"  class="booking-form-field" value="<?php echo esc_html($clinician->display_name)?>" disabled />
			<label for="contactName" class="h3">Your Name</label>
			<input name="contactName" id="contactName" class="booking-form-field" type="text" placeholder="e.g. Jane Doe" required>
			<label for="contactEmail" class="h3">Your Email</label>
			<input name="contactEmail" id="contactEmail" class="booking-form-field" type="text" placeholder="something@example.com" required>
			<label for="message" class="h3">Your Enquiry</label>
			<textarea class="booking-form-field" id="message" name="message"></textarea>
			<label class="visuallyhidden" for="checking">If you want to submit this form, do not enter anything in this field</label>
			<input id="checking" class="visuallyhidden" type="text" value="" name="checking">
			<input id="submitted" type="hidden" name="submitted">
			<input type="submit" name="submit" value="Submit" class="btn-primary"/>
		</form>
	</div>
</div>