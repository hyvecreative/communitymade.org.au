<?php
$args = array(
    'post_type' => 'articles', // Replace 'your_custom_post_type' with your actual custom post type slug
    'posts_per_page' => 3,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); ?>	


 <div class="col-md-4" style="margin-bottom: 1.5rem;">
        
        <div class="row">

            <!-- begin storypost -->

                <div class="col-12 member-thumb">

                <a href="<?php the_permalink() ?>">

               <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail('medium');
                    } else { ?>
                    <img src="<?php bloginfo('template_directory'); ?>/images/default-member-image.jpg" alt="<?php the_title_attribute(); ?>" />
                    <?php } ?>

                </a>
                </div><!-- end member-thumb -->	
            
                <div class="col-12 feedcont text-left">
                    <div class="feedcont-wrap">
                        
                        <a class="cat-text" href="<?php echo esc_url(get_post_type_archive_link(get_post_type())); ?>" class="post-type">
                    <?php echo esc_html(get_post_type()); ?>
                        </a>
                        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                    </div>
                 </div><!-- END feedcont-->

        </div>  <!-- end row -->
    </div>  <!-- end col -->

					
<?php endwhile; ?>

				

				<?php else : ?>

				<p>Sorry, but you are looking for something that isn't here.</p>

				<?php endif; ?>


