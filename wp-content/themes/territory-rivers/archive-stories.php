<?php 
	if (!defined('ABSPATH')) exit;
	get_header(); 
?>



<div class="container-fluid" style="position: relative;">
<div class="row hm-feature-page page-default" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/generic-pic.jpg'); background-size: cover; background-position: center center;"></div>
<div class="row">
<div class="col feature-text page-text text-center">
<h1 class="<?php the_field('h1_large'); ?>">Our Stories</h1>
</div>
</div>
</div>

<!-- begin content -->

<div class="container-fluid page-simple-wrap join-wrap">
	<div id="content" class="container page-simple">

<!-- begin row -->

<div class="row">
	
<div class="col-sm-12 col-md-10 offset-md-1 text-center">
              
<?php if ( is_post_type_archive( $stories )  ) { ?>

<?php } else { ?>

	<h1><?php single_cat_title(); ?></h1>
	
<?php } ?>

<div class="text-center" style="margin-bottom: 1.5rem">
<h2 style="margin-bottom: .5rem"><?php the_field('champions_sub_head', 'option'); ?></h2>
<?php the_field('champions_intro', 'option'); ?>
</div>

</div>

<div class="col-sm-12 text-center">
                  
<ul style="padding-left: 0;">		
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	


				<div class="feeditem text-left">  
				
				<li style="list-style: none">
                
                <div class="row feedItem">

            		<div class="col-sm-4 itemImage">
					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
					</div>
                
					<div class="col-sm-8 itemContent" style="display: flex; align-items: center;" >
						<div class="itemContent-wrap">
							<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
							
							<div class="excerpthm"><?php the_excerpt(); ?></div>
							
							<a href="<?php the_permalink() ?>" class="btn">Learn more</a>
						</div>
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
</div>



<?php get_footer(); ?>