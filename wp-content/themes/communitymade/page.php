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
document.addEventListener("DOMContentLoaded", function () {
  const NAV_OFFSET = 130;

  function scrollWithOffset(id) {
    const target = document.getElementById(id);
    if (!target) return;

    const elementPosition = target.getBoundingClientRect().top;
    const offsetPosition = elementPosition + window.pageYOffset - NAV_OFFSET;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth"
    });
  }

  // 1. Handle clicks on anchor links
  document.querySelectorAll(".page-content a[href^='#']").forEach(anchor => {
    anchor.addEventListener("click", function (e) {
      const id = this.getAttribute("href").substring(1);
      if (!id) return;

      e.preventDefault();
      history.pushState(null, "", "#" + id);
      scrollWithOffset(id);
    });
  });

  // 2. Handle page load with hash
  if (window.location.hash) {
    const id = window.location.hash.substring(1);

    // Delay allows browser + fonts + layout to finish
    setTimeout(() => {
      scrollWithOffset(id);
    }, 100);
  }

  // 3. Handle back/forward navigation
  window.addEventListener("hashchange", function () {
    const id = window.location.hash.substring(1);
    if (!id) return;

    setTimeout(() => {
      scrollWithOffset(id);
    }, 50);
  });
});
</script>



    
<?php get_footer(); ?>





