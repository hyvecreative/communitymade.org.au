<?php
/*
Template Name: thanks_temp
*/
?>
<?php get_header(); ?>

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

<div class="container-fluid page-intro">
	<div id="content" class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 offset-md-2 text-center">
				
				<h2><?php the_field('thanks-intro') ?></h2>
				
			</div>
		</div>
	</div>
</div>

<div class="container-fluid sources-content">
	<div class="container">
		
		<div class="row">
		
			<div class="col-sm-12 col-md-8 offset-md-2 text-center">
				
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php the_content(__('(more...)')); ?>

			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no pages are available. visit: http://coalimpactindex.com.au'); ?></p>
			<?php endif; ?>
				
			<div class="share-icons text-center">
						
				<a href="<?php the_field('thanks_link_fb') ?>" class="fb-share">
					  <span class="fa-stack fa-lg">
					  <i class="fas fa-square fa-stack-2x fa-inverse"></i>
					  <i class="fab fa-facebook-square fa-stack-2x"></i>
					</span></a>
				<a href="<?php the_field('thanks_link_tw') ?>" class="tw-share twitter-on">
						<span class="fa-stack fa-lg">
					  <i class="fas fa-square fa-stack-2x fa-inverse"></i>
					  <i class="fab fa-twitter-square fa-stack-2x"></i>
				</span></a>
			</div>
				
			</div>
		
		</div>
		
	</div>
</div>

    
<?php get_footer(); ?>


