<?php
/*
Template Name: page-resources
*/
?><?php get_header(); ?>


<main>

	
<div class="container-fluid page-feature clean-header">

	<div class="container page-container">
		<div class="row">
				<div class="col-md-12 pg-feature-text" style="display: flex; align-items: flex-end;">
						<h1 data-aos="fade-up"><?php the_title(); ?></h1>
				</div>
		</div>
	</div>
		
</div>

<!-- begin introduction -->
<article>
<div class="container-fluid">
	<div id="content" class="container page-content">
		
		<div class="row">
            
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
        
    <div class="row res-items" style="margin-top: 3rem;">
					
					<?php if( have_rows('resource_row') ): while ( have_rows('resource_row') ) : the_row(); ?>
                    
                   <div class="col-md-6 res-item" style="margin-bottom: 2rem;">
                    
                       
                       <div class="res-item-wrap">
                        <div class="row">

                                <div class="col-lg-6 res-item-image">
                                        <a <?php the_sub_field('typelink'); ?> href="<?php the_sub_field('resource_link'); ?>">
                                            <?php
                                            $image = get_sub_field('resource_image');
                                            if ($image) :
                                                // Use the 'medium' image size
                                                $image_url = $image['sizes']['medium'];
                                                $alt = esc_attr($image['alt']);
                                            ?>
                                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo $alt; ?>" />
                                            <?php endif; ?>
                                        </a>
                                    </div>



                                <div class="col-lg-6 res-item-content" style="padding-top: 0;">
                                <h3 style="margin-top: 0rem;"><?php the_sub_field('resource_title'); ?></h3>
                                    <p><?php the_sub_field('resource_excerpt'); ?></p>
                                    <a <?php the_sub_field('typelink') ?> class="btn btn-blue" href="<?php the_sub_field('resource_link') ?>"><?php the_sub_field('resource_link_title') ?></a>
                                </div>

                        </div>
                       
                    </div>
                       
                    </div>
                    
				<?php endwhile; else: endif; ?>
                    
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





