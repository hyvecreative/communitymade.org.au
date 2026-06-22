<?php
$news_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
));
?>

<?php if ($news_query->have_posts()) : ?>
    
    <div class="newsitem sb-feed anchor-nav">
        <ul class="newsitem-wrap">

            <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                <li class="newscont">
                    <h4>
                        <a class="li-arrow" href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h4>
                </li>
            <?php endwhile; ?>

        </ul>

        <div class="feedrule"></div>
    </div>

<?php else : ?>
    <p>No news items found.</p>
<?php endif; ?>

<?php wp_reset_postdata(); ?>

