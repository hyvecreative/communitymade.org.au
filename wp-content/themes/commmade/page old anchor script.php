<?php get_header(); ?>


<main>

	
<div class="container-fluid page-feature clean-header">

	<div class="container page-container">
		<div class="row">
				<div class="col-md-10 offset-md-1 pg-feature-text" style="display: flex; align-items: flex-end;">
						<h1 data-aos="fade-up"><?php the_title(); ?></h1>
				</div>
		</div>
	</div>
		
</div>

<!-- begin introduction -->
<article>
<div class="container-fluid px-0">
	<div id="content" class="container page-content">
		
		<div class="row" style="min-height: 500px;">
            
			<div class="col-md-10 offset-md-1">
                
                <?php if ( get_field('show_modified_date') ) : ?>
                    <div class="mod-date">
                        Last updated: <?php echo get_the_modified_date( 'j F Y' ); ?>
                    </div>
                <?php endif; ?>
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(__('(more...)')); ?>

				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no pages are available.2'); ?></p>
				<?php endif; ?>

			</div>
	
	</div>
	</div>
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





