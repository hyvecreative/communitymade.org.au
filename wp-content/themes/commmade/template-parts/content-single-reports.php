<?php /* TEMPLATE PART FOR POST */ ?>
<div class="col-12 grid-item">
  <?php $image = get_field( 'feature_image_wide' ); ?>
  <div class="ideas-hub-card">
    <div class="hub-card-container front-face">
      <div class="card-image" style="background-image: url('<?php the_field( 'feature_image_wide' ); ?>')"></div>
      <div class="card-text">
        <?php /*
          $tags = get_the_tags( get_the_ID() );
          if (count($tags) > 0)
          {
            echo "<p class='card-tag'>" . $tags[0]->name . "</p>";
          }*/
        ?>
        <p class='card-tag'><?php the_field('age_range'); ?></p>
        <h3><?php the_title(); ?></h3>
        <p class="card-excerpt"><?php the_excerpt(); ?><?php the_field( 'idea_excerpt' ); ?></p>
      </div>
		
		<div class="row card-logos">
        <div class="col-5 left-column">
          <p style="padding-bottom: 1rem;"><?php 
					$image = get_field('report_image');
						if( !empty( $image ) ): ?>
						 <img style="width: 100%; height: auto; padding-top: .5rem;" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
				<?php endif; ?></p>
        </div>
        <div class="col-7 right-column">
          <p><a class="card-toggle button-basic" href="<?php the_field( 'report_url' ); ?>">View Report</a></p>
        </div>
      </div>

    </div>


  </div>
</div>
