<?php /* TEMPLATE PART FOR POST */ ?>
<div class="col-lg-6 col-xl-4 grid-item">
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
        <?php
          $cats = get_the_terms( get_the_ID(), 'category' );
          if (count($cats) > 0)
          {
            echo "<p class='card-category'>" . $cats[0]->name . "</p>";
          }
        ?>
        <p class="card-excerpt"><?php the_field( 'idea_excerpt' ); ?></p>
      </div>
      <div class="row card-logos">
        <div class="col-5 left-column">
          <p><img src="<?php echo get_bloginfo('template_directory');  ?>/img/svg-vroom-black.svg" alt="Vroom | Brain Building Moments" /></p>
        </div>
        <div class="col-7 right-column">
          <p><a class="card-toggle button-basic" href="#">Learn more</a></p>
        </div>
      </div>
    </div>

    <div class="hub-card-container back-face">
      <div class="card-label">
        <div class="card-close"><i class="far fa-window-close"></i></div>
        <?php /*
          $tags = get_the_tags( get_the_ID() );
          if (count($tags) > 0)
          {
            echo "<p class='card-tag'>" . $tags[0]->name . "</p>";
          }*/
        ?>
        <p class='card-tag'><?php the_field('age_range'); ?></p>
        <h3><?php the_title(); ?></h3>
        <?php
          $cats = get_the_terms( get_the_ID(), 'category' );
          if (count($cats) > 0)
          {
            echo "<p class='card-category'>" . $cats[0]->name . "</p>";
          }
        ?>
      </div>
      <div class="card-background">
        <p class="card-excerpt"><?php the_field( 'idea_excerpt' ); ?></p>
        <h5>BRAINY BACKGROUND</h5>
        <p class="card-excerpt"><?php the_field( 'idea_background' ); ?></p>
        <hr />
        <div class="row card-logos">
          <div class="col-4 left-column">
            <p><img src="<?php echo get_bloginfo('template_directory');  ?>/img/svg-vroom-black.svg" alt="Vroom | Brain Building Moments" /></p>
          </div>
          <div class="col-8 right-column">
            <p><img src="<?php echo get_bloginfo('template_directory');  ?>/img/svg-brainy-background.svg" alt="Brainy Background™" /></p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
