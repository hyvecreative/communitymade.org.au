


<!-- begin footer -->
<footer>

<div class="container-fluid ftwraptop">
<div class="container">
	<div class="row main-row">

            <div class="col-md-4 col-lg-3 profile-ft">
				
				<?php the_field('footer_copyright', 'option'); ?>
                
				<?php the_field('footer_authorisation_text', 'option'); ?>
				
				<?php the_field('footer_contact', 'option'); ?>
				
			</div>

            <div class="col-md-3 col-lg-4 nav-ft">
			
                <div class="nav-ft">
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_id' => 'topmenu', 'container_class' => 'menu-ft', 'depth' => 1, 'items_wrap' => '<ul id="mymenu">%3$s</ul>' ) ); ?>
                </div>

			</div>
        
            <div class="col-md-2 partner-logos">
                <a href="<?php the_field('partner_logo_1_url', 'option'); ?>" aria-label="Go to Super Consumers" >
                    <?php 
								$image = get_field('partner_logo_1', 'option');
								if( !empty( $image ) ): ?>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
					<?php endif; ?>
                </a>
				
            </div>
			
			<div class="col-md-3 logos-ft">
				
				<div class="logo-ft partner-logo" style="margin-bottom: 1rem;"><a href="<?php the_field('main_logo_url', 'option'); ?>" aria-label="Go Back to home page" title="Go to Take Your Super Back homepage">
					<?php 
								$image = get_field('footer_main_logo', 'option');
								if( !empty( $image ) ): ?>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
					<?php endif; ?>
					</a>
				</div>
        
			</div>
        
	</div> <!-- end row -->

</div> <!-- end container -->
</div><!-- end container-fluid -->

    
</footer><!-- end footer -->

</div> <!-- end inner__wrapper -->
</div><!-- end wrapper -->

<a id="scroll-to-top" title="Back To Top" class="scroll-to-top" href="#">
<span class=" " aria-hidden="true">
	<i class="fa-light fa-arrow-up"></i></span>
<span class="sr-only">Back to Top</span>
</a>

<?= wp_footer() ?> 

<script>
	AOS.init({
  duration: 1200,
  animatedClassName: 'aos-animate',
})
</script>

<script>	
document.querySelectorAll('a.btn[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
      
      // Smooth scroll to #results 
      var target = $(this.hash);
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 1000, function() {});

    });
});
</script>

<script>
  // Add a class to the touched <a> element on touch devices
  document.addEventListener('touchstart', function (event) {
    // Check if the target is an <a> element
    if (event.target.tagName.toLowerCase() === 'a') {
      // Add the touch-active class to the touched <a> element
      event.target.classList.add('touch-active');

      // Remove the touch-active class after a short delay
      setTimeout(function () {
        event.target.classList.remove('touch-active');
      }, 300);
    }
  });
</script>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


</body>

</html>