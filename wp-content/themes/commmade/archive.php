<?php 
	if (!defined('ABSPATH')) exit;
	get_header(); 
?>

<main>

<div class="container-fluid page-feature pg-feature">
	 <?php if(has_post_thumbnail()) {
                        $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full", true);
                    } ?>
	<div class="pg-feature-img" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/engineer-wide.jpg'); background-color: transparent; background-repeat: no-repeat; background-position: center center">	</div>
	
</div>
<div class="container-fluid page-header-wrap">    
    <div class="container page-header">
            <div class="row">
                    <div class="col-md-12 pg-feature-text">
                        <div>
                            <?php if ( is_home() ) { ?>

                            <h1 data-aos="fade-down">In the Media</h1>
                        
                            <?php } elseif ( is_archive() ) { ?>

                            <?php
                            $archive_title = get_the_archive_title();
                            $modified_archive_title = str_replace('Archives: ', '', $archive_title);
                            ?>

                            <h1 data-aos="fade-down"><?php echo $modified_archive_title; ?></h1>

                            <?php } else { ?>

                             <h1 data-aos="fade-down"><?php single_cat_title(); ?></h1>

                            <?php } ?>
                        </div>
                    </div>
            </div>
    </div>
</div>


<!-- begin content -->
    
<article>

<div class="container-fluid page-color" style="min-height: 700px;">
<div class="container">

<!-- begin row -->

<div class="row">
	
<div class="col-md-12" style="margin-bottom: 2rem;">
    
    <div class="row">
               
         <?php get_template_part( 'partials/content', 'archive-feed' ); ?> 
        
    </div>    

</div><!-- end col -->

        
</div><!-- end row -->
</div><!-- end container-->
	
</div>
    
    </article>
</main>


<?php get_footer(); ?>