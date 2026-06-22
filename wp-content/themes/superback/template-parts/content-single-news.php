<?php /* TEMPLATE PART FOR POST */ ?>
<div class="col-md-4 feedcont text-left" style="display:flex; ">
    <div class="feedcont-wrap" style="flex: 0 1 100%; padding: 0;">
        <div class="member-thumb">
            <a href="<?php the_permalink() ?>">
                <?php 
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('medium');
                } else { 
                ?>
                    <img src="<?php bloginfo('template_directory'); ?>/images/default-image.jpg" alt="<?php the_title_attribute(); ?>" />
                <?php 
                } 
                ?>
            </a>
        </div><!-- end member-thumb -->	    
        <div class="feedcont-content" style="padding: .5rem 1rem 1rem;"> 
            <div class="archive-cats">
               <?php
                    // Get all taxonomies associated with the current post type
                    $post_type = get_post_type_object(get_post_type());
                    $taxonomies = get_object_taxonomies($post_type->name);

                    foreach ($taxonomies as $taxonomy) {
                        $terms = get_the_terms($post->ID, $taxonomy);

                        if ($terms && ! is_wp_error($terms)) {
                            $count = count($terms);

                            foreach ($terms as $index => $term) {
                                echo '<a class="' . $term->slug .'" href="' . get_term_link($term->slug, $taxonomy) . '">' . esc_html($term->name) . '</a>';

                                // Check if it's not the last term
                                if ($index < $count - 1) {
                                    echo ' | ';
                                }
                            }
                        }
                    }
                    ?>

            </div>
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
        </div>
    </div>
</div><!-- END feedcont-->
