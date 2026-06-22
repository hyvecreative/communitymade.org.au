<?php get_header(); ?>

<!-- begin content -->

<main>

	
<div class="container-fluid page-feature clean-header">

	<div class="container page-container">
		<div class="row">
				<div class="col-12 pg-feature-text" style="display: flex; align-items: flex-end;">
						<h1 data-aos="fade-up">News and updates</h1>
				</div>
		</div>
	</div>
		
</div>

    
<article>
    

<div class="container-fluid px-0 single-content">
        <div class="top-star-bg">
        <img src="<?php bloginfo('template_directory'); ?>/images/star-bundle_1.svg" />
        </div>
	<div id="content" class="container page-content">
        
        
        <div class="row">

		<div class="col-12 bCrumbs-wrap">

			<div class="bCrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
							<?php if(function_exists('bcn_display'))
							{
								bcn_display();
							}?>
			</div>

		</div>
		</div>
        
		
		<div class="row gutter-lg" style="min-height: 500px;">
            
			<div class="col-lg-8 single-page">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	

							<div class="single-content">

								<h1><?php the_title(); ?></h1>
                                
                                <div class="titlemeta">
								<div class="metadate"><?php the_time('j M Y') ?></div>
								</div>

								<?php the_content(__('Continue reading &raquo;')); ?> 

							</div> <!-- Postitem -->

						<?php endwhile; ?>

						<?php else : ?>

						<p>Sorry, but you are looking for something that isn't here.</p>				
						<?php endif; ?>


			</div>
            
            
            <div class="col-lg-4 single-aside">
                <h3 style="margin-top: .75rem;">Latest News and Updates</h3>
                <?php get_template_part( 'partials/content', 'sb-feed' ); ?>  
            </div>
	
	</div>
        
	</div>
</div>

	
</article>
</main>

<?php get_footer(); ?>




