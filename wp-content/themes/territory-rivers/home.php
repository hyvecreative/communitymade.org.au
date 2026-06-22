<?php 
	if (!defined('ABSPATH')) exit;
	get_header(); 
?>

<div class="container-fluid" style="position: relative;">
	 <?php if (is_home() && get_option('page_for_posts') ) {
    $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_option('page_for_posts')),'full'); 
    $featured_image = $img[0];
	} ?>
<div class="row feature-level" style="background-image:url(<?php echo (($feat_image[0]))?>); background-size: cover; background-position: <?php the_field('image_vert_position') ?> center;"></div>
<div class="row">
<div class="col level-text page-text text-center">
<h1 class="<?php the_field('h1_large'); ?>">News</h1>
</div>
</div>
</div>

<!-- begin content -->

<div class="container-fluid page-simple-wrap news-feed">
<div id="content" class="container page-simple">

<!-- begin row -->

<div class="row">
	
<div class="col-sm-12 col-md-10 offset-md-1 text-center">


     <h2>The latest from Territory Rivers</h2>

                  
<ul style="padding-left: 0;">		
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	


				<div class="feeditem text-left">  
				
					<li style="list-style: none">

						<div class="row">
								<div class="col-12 itemContent">

								<div class="meta date-tab">
									<span class="date"><?php the_time('M, Y') ?></span>
								</div><!-- end meta -->

								<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

								<div class="excerpthm"><?php the_excerpt(); ?></div>

								<a href="<?php the_permalink() ?>" class="btn btn-on-blue">Read more</a>
								</div>

						</div>


					</li>
                
    			</div><!-- END feeditem-->

					
<?php endwhile; ?>

				

				<?php else : ?>

				<p>Sorry, but you are looking for something that isn't here.</p>

				<?php endif; ?>
<ul>
	
	<?php if (function_exists("emm_paginate")) {

					emm_paginate();

				} ?>
                
</div><!-- end col -->

        
</div><!-- end row -->
</div><!-- end container-->
</div><!-- end container-fluid-->



<?php get_footer(); ?>