<?php get_header(); ?>

<!-- begin content -->

<div class="container-fluid news-page">
<div class="container">

<!-- begin row -->
	
    <div class="row content" style="min-height: 900px">
	<div class="col-sm-12 col-md-10 offset-md-1">
    
    <div class="bCrumbs" style="margin-bottom: 20px;" xmlns:v="http://rdf.data-vocabulary.org/#">
				    <?php if(function_exists('bcn_display'))
				    {
				        bcn_display();
				    }?>
	</div>
		
                
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	

					<div class="postItem itemContent">
						
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
		
	
			<a href="/people-on-the-river/" class="btn" title="Find out more">Back to news <i class="fas fa-chevron-left" aria-hidden="true"></i></a>
	</div>
                
	</div>
			<!-- end col left -->
	
            
		</div><!-- end row-->
		</div><!-- end cont -->
</div> <!-- end cont fluid -->
        <?php get_footer(); ?>




