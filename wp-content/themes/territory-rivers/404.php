<?php get_header(); ?>

<!-- begin content -->

<div class="container-fluid page-simple">
	<div id="content" class="container" style="margin-top: 80px; margin-bottom: 40px; min-height: 700px;">
		<div class="row">
			<div class="col-sm-12 col-md-8 offset-md-2">
				
			<h1><?php the_title(); ?></h1>
				
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php the_content(__('(more...)')); ?>

			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no pages are available.'); ?></p>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
    
<?php get_footer(); ?>


