<?php get_header(); ?>

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

<div class="container-fluid page-simple-wrap">
	<div id="content" class="container page-simple">
		<div class="row">
			<div class="col-sm-12 col-lg-8 offset-lg-2">

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
	</div>
</div>
	
<div id="Sign-up" class="container-fluid bottom-sign-up">
	<div id="sign-up" class="container sign-up">	
		<div class="row text-center">
			
			<?php get_template_part( 'partials/content', 'footer-signup' ); ?>
		
		</div>
	</div>
</div>
	
</article>
</main>
    
<?php get_footer(); ?>


