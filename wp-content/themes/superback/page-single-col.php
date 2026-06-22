<?php
/*
Template Name: page_single_col_temp
*/
?><?php get_header(); ?>


<main>

	
<div class="container-fluid page-feature pg-feature">     
    
	 <?php if(has_post_thumbnail()) {
                        $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full", true);
                    } ?>
    
	<div class="pg-feature-img" style="background-image:url(<?php echo (($feat_image[0]))?>); background-color: transparent; background-repeat: no-repeat; background-position: center <?php the_field('vertical_location'); ?>%;">    
    
    </div>
    

	
</div>


<!-- begin introduction -->
    
<article>
    
<div class="container-fluid page-header-wrap">    
    <div class="container page-header">
            <div class="row">
                    <div class="col-12 pg-feature-text">
                        <div>
                             <h1 data-aos="fade-down"><?php the_title(); ?></h1>
                        </div>
                    </div>
            </div>
    </div>
</div>

<div class="container-fluid about-content">
        <div class="top-star-bg">
        <img src="<?php bloginfo('template_directory'); ?>/images/star-bundle_1.svg" />
            </div>
	<div id="content" class="container page-content">
		
		<div class="row page-row" style="min-height: 500px;">
            
            
            
			<div class="col-md-9 main-content">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(__('(more...)')); ?>

				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no pages are available.2'); ?></p>
				<?php endif; ?>

			</div>
            
            
            <div class="col-md-3">
				
				<div class="sub-nav-wrap">

	
				<button id="showNavBut" class="show-nav-but"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>

	
				<div id="showNav" >
					<div  class="button-wrap button-wrap-flex">
						<?php if( have_rows('nav_links') ): while ( have_rows('nav_links') ) : the_row(); ?>
			
                        <?php 
                        $link = get_sub_field('navlink');
                        if( $link ): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                            <p>
                                <i class="fa-solid fa-arrow-right"></i> <a class="" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                           </p>
                        <?php endif; ?>
				
				
                        <?php endwhile; else: endif; ?>
					</div>
				</div>
            
	
				        
				                
                </div>

			</div>
	
	</div>
	</div>
</div>

	
</article>
</main>


<script>
	
$(document).ready(function () {
    $("#showNavBut").click(function (event) {
        $("#showNav").slideToggle(500, function () {
      if ($('#showNav').is(':visible')) {
        $(event.currentTarget).html('<i class="fa-solid fa-xmark" aria-hidden="true"></i>');
      } else {
        $(event.currentTarget).html('<i class="fa-solid fa-bars" aria-hidden="true"></i>');
      }
    });
    });
});

</script>

    
<?php get_footer(); ?>


