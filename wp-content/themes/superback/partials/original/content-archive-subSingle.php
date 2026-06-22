<div class="col-12">
    <h2 class="latest-h3" style="margin-top: .25rem; margin-bottom: 1.5rem; color: #139cd8;">Latest submission</h2>
</div>

<?php
$args = array(
    'post_type'      => 'submissions', // Replace 'your_custom_post_type' with the actual name of your custom post type
    'posts_per_page' => 1,  // Limit the query to 1 latest post
    // Add other query arguments here if needed
);

$query = new WP_Query($args);

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
?>

<!-- begin storypost -->
<div class="col-12 feedcont text-left">
    <div class="feedcont-wrap submisions-archive">
        <div class="member-thumb submiss-thumb">
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
        <div class="feedcont-content" style="margin-top: 1rem;"> 
            <div>
                <?php           
                // Get all taxonomies associated with the current post type
                $post_type = get_post_type_object(get_post_type());
                $taxonomies = get_object_taxonomies($post_type->name);
                
                foreach ($taxonomies as $taxonomy) {
                    $terms = get_the_terms($post->ID, $taxonomy);
                    if ($terms && ! is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo '<a class="' . $term->slug .'" href="' . get_term_link($term->slug, $taxonomy) . '">' . esc_html($term->name) . '</a> '; 
                        }
                    }
                }
                ?> 
            </div>
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <div class="excerpt-txt">
                <p><?php the_excerpt(); ?><a href="<?php the_permalink() ?>" class="readmore">Download <i class="fa-solid fa-arrow-right"></i></a></p>
            </div>
        </div>
    </div>
</div><!-- END feedcont-->
<?php endwhile; ?>


<?php else : ?>

<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

<?php wp_reset_postdata(); // Reset the query ?>



