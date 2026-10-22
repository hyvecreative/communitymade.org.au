<!-- begin colRight -->

<div class="col-lg-3 offset-lg-1 col-md-4 sidebar-main colRight" style="margin-bottom: 30px;">
 
<div class="sbevents">
<h2>News</h2>

<ul>
    <?php
			$my_query = new WP_Query("cat=5,18&showposts=5");
			while ($my_query->have_posts()) : $my_query->the_post();?>

				<li>
                
                <a href="<?php the_permalink() ?>"><i class="fas fa-chevron-right"></i> <?php the_title(); ?></a>
              
                </li>
                
			<?php endwhile;	?>
    </ul>

</div><!-- end sbevents-->

<div class="sbevents sbevents-feed">
<h2>Events</h2>

<ul>
    <?php
			$my_query = new WP_Query("cat=4&showposts=2");
			while ($my_query->have_posts()) : $my_query->the_post();?>
 
				<li>
					
				<div class="casethumb">

				<a href="<?php the_permalink() ?>">

				<?php if ( has_post_thumbnail() ) {
												the_post_thumbnail(array());
												} else { ?>
												<img src="<?php bloginfo('template_directory'); ?>/images/default-image.jpg" alt="<?php the_title(); ?>" />
												<?php } ?>

				</a></div><!-- end casethumb -->
					
				<div class="sb-feed-content">	
                <a href="<?php the_permalink() ?>"><i class="fas fa-chevron-right"></i> <?php the_title(); ?></a>
				</div>	
              
                </li>
                
                
			<?php endwhile;	?>
    </ul>

</div><!-- end sbevents-->

</div><!-- end colRight -->