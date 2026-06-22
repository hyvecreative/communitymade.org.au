<?php 
	if (!defined('ABSPATH')) exit;
	get_header(); 
?>

<!-- begin content -->


<div class="container">

<!-- begin row -->

<div class="row">
	
<div class="col-12 colLeft text-center">

            
              
<?php if ( is_home() ) { ?>

     <h1>Incidents</h1>

<?php } else { ?>

	 <h1><?php single_cat_title(); ?></h1>

<?php } ?>

                  
<ul>		
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	


				<div class="feeditem text-left">  
				
				<li style="list-style: none">
                
                <div class="feedcont">
					
					<div class="meta date-tab">
            			<span class="date"><?php the_time('M, Y') ?></span>
            		</div><!-- end meta -->

            		<div class="itemImage">
						<?php the_post_thumbnail( 'full' ); ?>
					</div>
                
					<h3><?php the_title(); ?></h3>
					
					<div class="excerpthm"><?php the_content(); ?></div>
					
					<a href="<?php the_field('learn_more_link') ?>" class="btn">Learn more</a>

					<p class="tag-display"><?php the_tags(' '); ?></p>
					
					<div class="share-icons text-right">
						
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" class="fb-share">
					  <span class="fa-stack fa-lg">
					  <i class="fas fa-square fa-stack-2x fa-inverse"></i>
					  <i class="fab fa-facebook-square fa-stack-2x"></i>
					</span></a>
					<a href="<?php the_field('twitter_url') ?>" class="tw-share <?php the_field('twitter_on'); ?>">
						<span class="fa-stack fa-lg">
					  <i class="fas fa-square fa-stack-2x fa-inverse"></i>
					  <i class="fab fa-twitter-square fa-stack-2x"></i>
					</span></a>
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



<?php get_footer(); ?>