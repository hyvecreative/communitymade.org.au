<div class="col-12">
<?php
// Get the current page number
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

// WP_Query arguments with pagination for a custom post type
$args = array(
    'post_type' => 'newsletters', // Replace 'your_custom_post_type' with your actual custom post type name
    'posts_per_page' => -1, // all posts per page
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
    // Loop through the posts and display them
    while ( $query->have_posts() ) {
        $query->the_post();
        echo '<h2>' . esc_html( get_the_date( 'Y' ) ) . '</h2>'; // Display the year as a heading
        echo '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a><br>'; // Display post title as a link
    }

    // Pagination
    echo paginate_links( array(
        'total' => $query->max_num_pages, // Total number of pages
    ) );

    // Restore original post data
    wp_reset_postdata();
} else {
    // No posts found
    echo 'No posts found.';
}
?>
    </div>
