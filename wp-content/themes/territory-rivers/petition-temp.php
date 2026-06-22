<?php
/*
Template Name: petition-temp
*/
?>
<?php
get_header(); 
?>

<!-- begin content -->

<div class="container-fluid" style="position: relative;">
	 <?php if(has_post_thumbnail()) {
                        $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full", true);
                    } ?>
<div class="row feature-level" style="background-image:url(<?php echo (($feat_image[0]))?>); background-size: cover; background-position: <?php the_field('image_vert_position') ?> center;"></div>
<div class="row">
<div class="col level-text page-text text-center">
<h1 class="<?php the_field('h1_large'); ?>"><?php the_title(); ?></h1>
</div>
</div>
</div>


<div class="container-fluid action-wrap">
<div class="container">
	
				<div class="row">
					<div class="col-lg-6 action-intro">
                    <h2 class="pet-intro-mob"><?php the_field('action_title') ?></h2>
					<div class="btn scroll-down-pet petition-action"><?php the_field('scroll_text') ?></div>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php the_content(__('(more...)')); ?>

							<?php endwhile; else: ?>
							<p><?php _e('Sorry, no pages are available. visit: http://cpactive.org.au'); ?></p>
							<?php endif; ?>
					</div>

					<div class="col-lg-5 offset-lg-1 action-form-wrap">
						<div class="action-form">
						<h2><?php the_field('action_title') ?></h2>
						<?php the_field('action_text') ?>
							<div class="" style="margin: 20px 0;"><?php the_field('action_form') ?></div>
						</div>
					</div>
				</div>

	
</div>
</div>


<?php get_footer(); ?>