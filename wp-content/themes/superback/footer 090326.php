


<!-- begin footer -->
<footer>

<div class="container-fluid ftwraptop">
<div class="container">
	<div class="row main-row">

            <div class="col-md-4 col-lg-3 profile-ft">
				
				<?php the_field('footer_copyright', 'option'); ?>
                <a href="<?php the_field('partner_logo_1_url', 'option'); ?>" aria-label="Go to Super Consumers" >
                    <?php 
								$image = get_field('partner_logo_1', 'option');
								if( !empty( $image ) ): ?>
									<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
					<?php endif; ?>
                </a>
				<?php the_field('footer_authorisation_text', 'option'); ?>
				
				<?php the_field('footer_contact', 'option'); ?>
				
			</div>

            <div class="col-md-3 col-lg-4 nav-ft">
			
                <div class="nav-ft">
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_id' => 'topmenu', 'container_class' => 'menu-ft', 'depth' => 1, 'items_wrap' => '<ul id="mymenu">%3$s</ul>' ) ); ?>
                </div>

			</div>
        
            <div class="col-md-2 social-logos">
                <h2>Share</h2>
					<a href="<?php the_field('linkedin_url', 'option'); ?>" class="li-share" style="margin-right: 10px;"><i aria-hidden="true" class="fa-brands fa-linkedin fa-2x" title="Share on Linkedin"></i>
					<span class="sr-only">See on Linkedin</span>
					</a>
                
                    <a style="display: none;" href="<?php the_field('twitter_url', 'option'); ?>" class="tw-share"><i aria-hidden="true" class="fa-brands fa-square-x-twitter fa-2x" title="Share on X"></i>
					<span class="sr-only">Share on X</span>
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
    
    <div class="footer-star">
        <img src="<?php bloginfo('template_directory'); ?>/images/footer-bundle.svg" / alt="">
    </div>
    
</footer><!-- end footer -->

</div> <!-- end inner__wrapper -->
</div><!-- end wrapper -->

<a id="scroll-to-top" title="Back To Top" class="scroll-to-top" href="#">
<span class=" " aria-hidden="true">
	<i class="fas fa-arrow-up"></i></span>
<span class="sr-only">Error:</span>
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

<script>

    document.querySelectorAll('.schema-faq-question').forEach(q => {
      q.addEventListener('click', () => {
        const answer = q.nextElementSibling;

        // Toggle clicked answer only
        if (answer.style.height && answer.style.height !== '0px') {
          // Collapse
          answer.style.height = answer.scrollHeight + 'px'; // Start from current height
          requestAnimationFrame(() => {
            answer.style.height = '0';
            answer.style.opacity = 0;
          });
        } else {
          // Expand
          answer.style.height = '0'; // Start from 0
          answer.style.opacity = 0;
          requestAnimationFrame(() => {
            answer.style.height = answer.scrollHeight + 'px';
            answer.style.opacity = 1;
          });
        }
      });
    });

</script>


</body>

</html>