<?php
/**
 * The template file the Contact page
 * 
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

get_header(); ?>

<div class="hero">
	<div class="inner">
		<h2 class="h1"><?php the_title() ?></h2>
		<p class="intro">
			To book your first complimentary and obligation free 
			consultation with any of the private consultants or midwives 
			please contact the London Ultrasound Centre:
		</p>	
		<p class="intro">Call us on 020 7908 3878 (24/7)</p>
	</div>	
</div>
<div class="content"> 
	<div class="inner clearfix">
		<div class="left-col ">
			<iframe class="map" width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
				src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=112+Harley+Street+London+W1G+7JQ+&amp;aq=&amp;sll=51.528642,-0.101599&amp;sspn=0.514326,1.234589&amp;ie=UTF8&amp;hq=&amp;hnear=112+Harley+St,+London+W1G+7JQ,+United+Kingdom&amp;t=m&amp;ll=51.521562,-0.147886&amp;spn=0.021362,0.051413&amp;z=16&amp;iwloc=A&amp;output=embed">
			</iframe>

			<div class="directions">
				<h3 class="h2">Directions</h3>
				<h4 class="h3">By foot/train:</h4>
				<p>
					We are a five minute walk from the nearest tube station, Regent's Park on the Bakerloo Line. 
					You will find us on the corner of Harley Street and Devonshire Street.
				</p>
				<h4 class="h3">Parking</h4>
				<p>
					Parking meters on Harley Street have a maximum stay of four hours.
					Private garage on Devonshire Street between Harley Street and Portland Place.
					NCP car park on Weymouth Mews.
				</p>
				<p>
					If you have any questions, please call us on: 020 7908 3878
				</p>
			</div>
		</div>
		<div class="right-col col-wrap">
			<form method="post" action id="frmContact" class="booking-form">
				<div id="" class="vcard">
					You’ll find us at:
					<div class="org">Harley Medical Group</div>
					<div class="adr">
						<div class="street-address">112 Harley Sreet</div>
					  	<span class="locality">London</span>
						, 
						<span class="postal-code">W1G 7JQ</span>
					</div>
				</div>
				<div class="err-box"></div>
				<label for="contactName" class="h3">Your Name</label>
				<input name="contactName" id="contactName" class="booking-form-field" type="text" placeholder="e.g. Jane Doe" required />
				<label for="contactEmail" class="h3">Your Email</label>
				<input name="email" id="contactEmail" class="booking-form-field" type="text" placeholder="something@example.com" required />
				<label for="contactEmail" class="h3">Telephone</label>
				<input name="phone" id="contactPhone" class="booking-form-field" type="tel" placeholder="078 5555 5555" required />
				<label for="message" class="h3">Your Enquiry</label>
				<textarea class="booking-form-field" id="message" name="comments" required></textarea>
				<label class="visuallyhidden" for="checking">If you want to submit this form, do not enter anything in this field</label>
				<input id="checking" class="visuallyhidden" type="text" value="" name="checking" />
				<input id="submitted" type="hidden" name="submitted"/>
				<?php wp_nonce_field(wp_get_theme()->Name,'cico_nonce'); ?>
				<button type="submit" name="submit" class="btn-primary cico-submit">Send Enquiry</button>
			</form>
		</div>
	</div>
</div>

<?php get_footer(); ?>
