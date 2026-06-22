<?php
/*
Template Name: people-on-river
*/
?><?php get_header(); ?>

<main>
<article>

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

<!-- begin content -->
	
<div id="content" class="container-fluid river-sections river-sections-page">
<div class="container">	
	
		<div class="row text-center">
			
			<div class="col-12" style="margin-bottom: 1rem;">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(__('(more...)')); ?>

				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no pages are available.2'); ?></p>
				<?php endif; ?>
			</div>
		</div>
			
	

		<?php if( have_rows('river_people') ): while ( have_rows('river_people') ) : the_row(); ?>
		<div class="row text-center people-grid">
			<div class="col-12 col-md-6 river-wrapper river-image">
			<?php
					$image = get_sub_field('rp_image');
					$size = 'full'; // (thumbnail, medium, large, full or custom size)

					if( $image ) {

					echo wp_get_attachment_image( $image, $size );

					}
					?>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_sub_field('rp_name') ?></h2>
					<h3><?php the_sub_field('rp_location') ?></h3>
					<p><?php the_sub_field('rp_quote') ?></p>
					<p class="<?php the_sub_field('rp_off') ?>"><a class="btn btn-on-yell" href="<?php the_sub_field('rp_url') ?>"><?php the_sub_field('rp_text') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
								
		</div>
				<?php endwhile; else: endif; ?>
	
	<div class="row">
	<div class="col-12" style="margin-top: 2rem; margin-bottom: 2rem;"></div>
	</div>
			
	</div>
</div>
	
	
<div id="Sign-up" class="container-fluid bottom-sign-up" style="background: #f4f5f9;">
	<div id="sign-up" class="container sign-up">	
		<div class="row text-center">
			
			<?php get_template_part( 'partials/content', 'footer-signup' ); ?>
		
		</div>
	</div>
</div>
	
	
	
</article>
</main>
    
<?php get_footer(); ?>


