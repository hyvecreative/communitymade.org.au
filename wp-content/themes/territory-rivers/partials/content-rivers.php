
	<div class="container">
		<div class="row text-center">
			
			
			<div class="col-12" style="margin-bottom: 2rem;">
				<h2><?php the_field('rivers_section_title') ?></h2>
				<p><?php the_field('rivers_section_intro') ?></p>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('rivers_name_1') ?></h2>
					<p><?php the_field('river_text_1') ?></p>
					<p><a class="btn btn-on-yell" href="<?php the_field('river_url_1') ?>"><?php the_field('river_link_text_1') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('river_image_1');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
			</div>
			
						
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('river_image_2');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('river_name_2') ?></h2>
					<p><?php the_field('river_text_2') ?></p>
					<p><a class="btn btn-on-green" href="<?php the_field('river_url_2') ?>"><?php the_field('river_link_text_2') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_field('river_name_3') ?></h2>
					<p><?php the_field('river_text_3') ?></p>
					<p><a class="btn btn-on-yell" href="<?php the_field('river_url_3') ?>"><?php the_field('river_link_text_3') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper river-image">
				<?php
				$image = get_field('river_image_3');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
				?>
				<button type="button" class="btn btn-warning"><i class="fas fa-times"></i></button> 

			</div>
			

				
			<div class="col-12" style="margin-top: 2rem; margin-bottom: 2rem;">
				<a href="/our-rivers/" class="btn btn-rev" title="Find out more">Our Rivers <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
			</div>
			
			 
			
		</div>
	</div>

<script>
$(document).ready(function(){
  $(".btn-warning").click(function(){
    $(".collapse").collapse('hide');
  });
});
</script>
