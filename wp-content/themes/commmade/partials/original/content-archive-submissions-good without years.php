<div class="col-12">
    <h2 class="latest-h3" style="margin-top: .25rem; margin-bottom: 1rem;">All Reports</h2>
</div>

<?php 
if (have_posts()) : while (have_posts()) : the_post(); 
?>

<!-- begin storypost -->
<div class="col-12 feedcont text-left">
    <div class="feedcont-wrap submisions-archive">
  
        <div class="feedcont-content"> 
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
            <div class="excerpt-txt"><p><?php the_excerpt(); ?></p></div>
        </div>
    </div>
</div><!-- END feedcont-->
<?php endwhile; ?>


				<?php else : ?>

				<p>Sorry, but you are looking for something that isn't here.</p>

				<?php endif; ?>


<!--<div class="navigation">

							<div class="alignleft"><?php next_posts_link() ?></div>

							<div class="alignright"><?php previous_posts_link() ?></div>

</div>-->

<div class="col-12">

				<?php if (function_exists("emm_paginate")) {

					emm_paginate();

				} ?>
    
    </div>