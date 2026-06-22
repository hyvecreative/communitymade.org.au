<?php 
	if (!defined('ABSPATH')) exit;
	get_header(); 
?>


<main>

	
<div class="container-fluid page-feature clean-header">

	<div class="container page-container">
		<div class="row">
				<div class="col-md-10 offset-md-1 pg-feature-text" style="display: flex; align-items: flex-end;">
						<h1 data-aos="fade-down"><?php single_cat_title(); ?></h1>
				</div>
		</div>
	</div>
		
</div>

<!-- begin introduction -->
<article>


<!-- begin content -->

<article>
<div class="container-fluid px-0">
	<div id="content" class="container page-content">
        
        <div class="row">

		<div class="col-lg-10 offset-lg-1 bCrumbs-wrap">

			<div class="bCrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
							<?php if(function_exists('bcn_display'))
							{
								bcn_display();
							}?>
			</div>

		</div>
		</div>
		
		<div class="row" style="min-height: 500px;">
            
			<div class="col-lg-10 offset-lg-1">
				
				<?php get_template_part( 'partials/content', 'index-feed' ); ?> 

			</div>
	
	</div>
	</div>
</div>

	
</article>
</main>



<?php get_footer(); ?>