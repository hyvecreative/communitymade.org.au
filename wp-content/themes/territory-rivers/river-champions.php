<?php
/*
Template Name: river_champions
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
			
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('champ_image_1');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('champ_name_1') ?></h2>
					<h3><?php the_field('champ_location_1') ?></h3>
					<p><?php the_field('champ_quote_1') ?></p>
					<p><a class="btn btn-on-yell" 
						  <?php $display_1 = get_field('display_button_1');
							if( $display_1 && in_array('hide', $display_1) ) { ?>
								style="display: none;"
						  <?php } ?> 
						  href="<?php the_field('champ_url_1') ?>"><?php the_field('champ_link_text_1') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('champ_name_2') ?></h2>
					<h3><?php the_field('champ_location_2') ?></h3>
					<p><?php the_field('champ_quote_2') ?></p>
					<p><a class="btn btn-on-green" 
						  <?php $display_2 = get_field('display_button_2');
							if( $display_2 && in_array('hide', $display_2) ) { ?>
								style="display: none;"
						  <?php } ?> 
						  href="<?php the_field('champ_url_2') ?>"><?php the_field('champ_link_text_2') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('champ_image_2');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('champ_image_3');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('champ_name_3') ?></h2>
					<h3><?php the_field('champ_location_3') ?></h3>
					<p><?php the_field('champ_quote_3') ?></p>
					<p><a class="btn btn-on-yell" 
						  <?php $display_3 = get_field('display_button_3');
							if( $display_3 && in_array('hide', $display_3) ) { ?>
								style="display: none;"
						  <?php } ?> 
						  href="<?php the_field('champ_url_3') ?>"><?php the_field('champ_link_text_3') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('champ_name_4') ?></h2>
					<h3><?php the_field('champ_location_4') ?></h3>
					<p><?php the_field('champ_quote_4') ?></p>
					<p><a class="btn btn-on-green" 
						  <?php $display_4 = get_field('display_button_4');
							if( $display_4 && in_array('hide', $display_4) ) { ?>
								style="display: none;"
						  <?php } ?> 
						  href="<?php the_field('champ_url_4') ?>"><?php the_field('champ_link_text_4') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('champ_image_4');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
			</div>
				
			<div class="col-12" style="margin-top: 2rem; margin-bottom: 2rem;">
			</div>

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


