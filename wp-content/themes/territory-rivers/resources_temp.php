<?php
/*
Template Name: resources-temp
*/
?>
<?php get_header(); ?>

<main>
<article>

<div class="container-fluid" style="position: relative;">
	 <?php if(has_post_thumbnail()) {
                        $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full", true);
                    } ?>
<div class="row hm-feature-page page-default" style="background-image:url(<?php echo (($feat_image[0]))?>); background-size: cover; background-position: <?php the_field('image_vert_position') ?> center;"></div>
<div class="row">
<div class="col feature-text page-text text-center">
<h1 class="<?php the_field('h1_large'); ?>"><?php the_title(); ?></h1>
</div>
</div>
</div>

<!-- begin content -->

<div class="container-fluid page-simple-wrap join-wrap">
	<div id="content" class="container page-simple">
		<div class="row">
			<div class="col-sm-12 col-md-8 offset-md-2 text-center">

			<?php if(get_field('echo_title')):?>
				<h1 class="page-header-title"><?php the_title(); ?></h1> 
			<?php else:?> 
			<?php endif;?> 
				
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php the_content(__('(more...)')); ?>

			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no pages are available. visit: http://coalimpactindex.com.au'); ?></p>
			<?php endif; ?>
			</div>
		</div>


		<div class="row">

			<!-- start recources block -->
					
			<div class="col-sm-12 col-md-8 offset-md-2" style="">
				
				<h2 class="text-center"><?php the_field('resource_row_title') ?></h2>
					
					<?php if( have_rows('resource_row') ): while ( have_rows('resource_row') ) : the_row(); ?>
					<div class="row feeditem res-wrap" style="background: #fff; clear: both; padding-bottom: 20px; padding-top: 20px; margin-bottom: 20px; overflow: hidden;">
							
							<div class="col-sm-6 res-image-col" style="">
			
					<a href="<?php the_sub_field('resource_link') ?>" download="">
			
							<?php
							$image = get_sub_field('resource_image');
			
							?>
			
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
							
								</a></div>
			
							<div class="col-sm-6 itemContent" style="padding-top: 0;">
							<h3><?php the_sub_field('resource_title'); ?></h3>
								<p><?php the_sub_field('resource_excerpt'); ?></p>
								<a class="btn" href="<?php the_sub_field('resource_link') ?>" download=""><?php the_sub_field('resource_link_title') ?></a>
							</div>
			
					</div>
				<?php endwhile; else: endif; ?>
						
			
			</div><!-- .col end bus-resources -->

		</div>
	</div>
</div>
	
</article>
</main>
    
<?php get_footer(); ?>




