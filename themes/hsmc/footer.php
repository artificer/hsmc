  <footer>
    <div class="widget-wrap">
      <div class="inner"> 
      <?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
        <?php dynamic_sidebar( 'footer-widgets' ); ?>
      <?php endif; ?>
      </div>
    </div>
    <div class="sign-off">
      <div class="inner  clearfix">
        <div class="colophon">&copy; All Rights Reserved</div>
        <ul class="social-btns inline">
          <li>
            <a href="http://www.facebook.com/harleymaternitygroup">Facebook</a>
          </li>
          <li>
            <a href="http://twitter.com/PrivateMaternityCare">Twitter</a> 
          </li>
          <li>
            <a href="<php home_url('/feed')?>">RSS</a>
          </li>
        </li>
      </div>
    </div>
  </footer>
  <?php wp_footer() ?>

	<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
   		mathiasbynens.be/notes/async-analytics-snippet -->
	<script>
		/*var _gaq=[['_setAccount','UA-8697059-10'],['_trackPageview'],['_trackPageLoadTime']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));*/
	</script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
</body>
</html>