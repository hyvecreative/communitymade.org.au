<?php /* TEMPLATE PART FOR POST */ ?>
<div class="col-12 grid-item">
  <?php $image = get_field( 'feature_image_wide' ); ?>
  <div class="ideas-hub-card" style="border-bottom: #FAF6F1 solid 4px; padding-bottom: .5rem; margin-bottom: .75rem;">
    <div class="">
	  
		<div class="row">
      
		<div class="col-sm-9 col-xl-10">
			<p class='card-tag'><?php the_field('age_range'); ?></p>
			<p ><a style="font-size: 1.3333rem; margin-bottom: .25rem; color: #FF4F00;" class="" href="<?php the_field( 'report_url' ); ?>"><?php the_title(); ?></a></p>
			<p class="card-excerpt" style="margin-bottom: 0;">
				<?php the_field( 'excerpt_text' ); ?>
				<a style="font-size: 1rem; color: #FF4F00; display: inline-block" class="" href="<?php the_field( 'report_url' ); ?>">View Report</a>
			</p>
     	</div>
		
		<div class="col-3 col-sm-3 col-xl-2">
			<p style="margin-bottom: 0;"><?php 
					$image = get_field('report_image');
						if( !empty( $image ) ): ?>
						 <img style="width: 100%; height: auto; padding-top: .5rem;" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
				<?php endif; ?>
         	</p>
       	</div>
		  
      </div>

    </div>


  </div>
</div>
