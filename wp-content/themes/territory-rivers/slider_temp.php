<?php
/*
Template Name: slider-temp
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

<div class="container-fluid">
	<div id="content" class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 offset-md-2 text-center">

			<?php if(get_field('echo_title')):?>
				<h1 class=""><?php the_title(); ?></h1> 
			<?php else:?> 
			<?php endif;?> 
				
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php the_content(__('(more...)')); ?>

			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no content matched your criteria.'); ?></p>
			<?php endif; ?>
			</div>
		</div>

	</div>
</div>

<div class="container-fluid slider-wrap">
	<div id="content" class="container">
	<div class="row">
	<div class="col-12">

		<div class="col-sm-12 col-md-8 offset-md-2 hero-text text-center">
			<p class="text-center"><?php the_field('story_feed_intro'); ?></p>
		</div>
		
			<div class="slider feedcont feed-quote" style="position: relative;"> <!-- slider class here -->

				<?php if( have_rows('story_quote') ): while ( have_rows('story_quote') ) : the_row(); ?>
					<div class="quote-item">
						<div class="quote-item-wrap">
							<h3 class="quote-text" style="width: 100%;"><?php the_sub_field('quote_text'); ?> <span class="quote-byline"><?php the_sub_field('quote_byline'); ?></span></h3>
							<a href="<?php the_sub_field('quote_link_url'); ?>" class="btn"><?php the_sub_field('quote_link_text'); ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
						</div>
					</div>
				<?php endwhile; else: endif; ?>

			</div>
		</div>
	</div>
</div>
		</div>
		</div>
	
</article>
</main>
    
<?php get_footer(); ?>




