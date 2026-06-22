<div class="col-12">
    <h2 class="latest-h3" style="margin-top: .25rem; margin-bottom: 1rem; color: #139cd8;">All Submissions</h2>
</div>


<?php
// Get the current page number
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

// WP_Query arguments for a custom post type, querying all posts and grouping by year
$args = array(
    'post_type' => 'submissions', // Replace 'your_custom_post_type' with your actual custom post type name
    'posts_per_page' => -1, // Get all posts
    'orderby' => 'date', // Order by date
    'order' => 'DESC', // Order in descending order
    'date_query' => array(
        array(
            'after' => '5 years ago', // Modify this to change the date range if needed
        ),
    ),
    'paged' => $paged, // Current page number
);

// The Query
$query = new WP_Query( $args );

// Check if there are any posts
if ( $query->have_posts() ) {
    // Create an empty array to store grouped posts
    $grouped_posts = array();

    // Loop through the posts and group them by year
    while ( $query->have_posts() ) {
        $query->the_post();
        $year = get_the_date('Y'); // Get the year of the current post

        // Add the post to the respective year in the grouped_posts array
        $grouped_posts[$year][] = get_post();
    }

    // Restore original post data
    wp_reset_postdata();

    // Loop through the grouped posts and display them
    foreach ( $grouped_posts as $year => $posts ) {
        echo '<h2 style="padding-left: 15px; color: #139cd8; margin-bottom: 1rem;">' . esc_html( $year ) . '</h2>'; // Display the year as a heading

        foreach ( $posts as $post ) {
            setup_postdata( $post ); // Set up post data for the current post
            echo '<div class="col-12 feedcont text-left"> <div class="feedcont-wrap submisions-archive"> <div class="feedcont-content">';
                     
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

            
            echo '<h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>'; // Display post title as a link
            echo '<div class="excerpt-txt"><p>' . esc_html( get_the_excerpt() ) . ' <a href="' . esc_url( get_permalink() ) . '">Download&nbsp;<i class="fa-solid fa-arrow-right"></i></a></p></div>'; // Display post excerpt
            echo '</div> </div> </div>'; // Close .col-12
        }
    }
} else {
    // No posts found
    echo 'No posts found.';
}
?>
