<?php /* TEMPLATE PART FOR POST */ ?>
<div class="col-lg-6 col-xl-4">
  <?php $image = get_field( 'feature_image_wide' ); ?>
  <a class="news-card<?php if (!$image) { echo " no-image"; } ?>" href="<?php the_permalink(); ?>">
    <div class="news-card-container">
      <?php if ($image) { ?>
        <div class="news-card-image" style="background-image: url('<?php the_field( 'feature_image_wide' ); ?>')"></div>
        <div class="news-card-text">
          <?php $cats = wp_get_post_terms( get_the_ID(), 'news_categories' ); ?>
          <?php $count = 1; ?>
          <?php if (count($cats) > 0) { ?>
            <p>
              <?php foreach( $cats as $cat ) { ?>
                <?php if ($count < count($cats)) { echo $cat->name . ", "; } else { echo $cat->name; } ?>
                <?php $count++; ?>
              <?php } ?>
            </p>
          <?php } ?>
          <?php if (strlen(get_the_title()) > 120) { ?>
            <?php $title = substr(get_the_title(), 0, 120); ?>
            <h3 class="hidden-xs"><?php echo $title; ?>&hellip;</h3>
            <h3 class="visible-xs"><?php the_title(); ?></h3>
          <?php } else { ?>
            <h3><?php the_title(); ?></h3>
          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="news-card-text-only">
          <div class="vert-align">
            <?php $cats = wp_get_post_terms( get_the_ID(), 'news_categories' ); ?>
            <?php $count = 1; ?>
            <?php if (count($cats) > 0) { ?>
              <p>
                <?php foreach( $cats as $cat ) { ?>
                  <?php if ($count < count($cats)) { echo $cat->name . ", "; } else { echo $cat->name; } ?>
                  <?php $count++; ?>
                <?php } ?>
              </p>
            <?php } ?>
            <h3><?php the_title(); ?></h3>
          </div>
        </div>
      <?php } ?>
      <div class="news-card-button"><p class="card-button"><span class="button-basic">Read</span></p></div>
    </div>
  </a>
</div>
