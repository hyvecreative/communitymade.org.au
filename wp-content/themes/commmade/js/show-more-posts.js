jQuery(document).ready(function($) {
    var offset = 10; // Initial offset, as we've already loaded 10 posts
    var postsContainer = $('#posts-container');
    var loadMoreButton = $('#load-more-posts');

    loadMoreButton.on('click', function() {
        $.ajax({
            url: ajaxurl, // WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'load_more_posts',
                offset: offset
            },
            success: function(response) {
                if (response) {
                    postsContainer.append(response); // Append new posts to the container
                    offset += 10; // Increase the offset for the next query
                } else {
                    loadMoreButton.hide(); // Hide the button if no more posts to load
                }
            }
        });
    });
});