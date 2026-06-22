<?php 
	if (!defined('ABSPATH')) exit;
	get_header(); 
?>

<main>

<article>
	
<div class="container-fluid page-feature clean-header">

	<div class="container page-container">
		<div class="row">
				<div class="col-md-10 offset-md-1 pg-feature-text" style="display: flex; align-items: flex-end;">
						<h1 data-aos="fade-up">News and updates</h1>
				</div>
		</div>
	</div>
		
</div>

<div class="container-fluid px-0 page-color" style="min-height: 700px;">
<div class="container">

<!-- begin row -->

<div class="row">
	
<div class="col-md-10 offset-md-1" style="margin-bottom: 2rem;">
    
  <div class="news-intro"><?php the_field('news_intro', 'option'); ?></div>
               
  <?php get_template_part( 'partials/content', 'index-feed' ); ?>                

</div><!-- end col -->

        
</div><!-- end row -->
</div><!-- end container-->
	
</div>
    
    </article>
</main>

<!-- list html anchors -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Select all anchor links inside page-content that link to an ID
  const anchors = document.querySelectorAll(".page-content a[href^='#']");

  anchors.forEach(anchor => {
    anchor.addEventListener("click", function(e) {
      e.preventDefault(); // Prevent default jump

      const targetId = this.getAttribute("href").substring(1); // remove #
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        const navOffset = 130; // 90px nav + 30px extra
        const elementPosition = targetElement.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - navOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: "smooth" // smooth scroll
        });
      }
    });
  });
});
</script>

<?php get_footer(); ?>