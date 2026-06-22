
<div class="row">
    
    <?php
// The WordPress Loop - customized with query_posts
query_posts(array(
    'post_type' => array('journalism', 'submissions'), // Array of post types you want to query
    'showposts' => 3,
    'orderby' => 'date',
    'order' => 'desc'
));
?>
    
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


            <!-- begin storypost -->

               <div class="col-md-4 feedcont text-left">
                                
                                <div class="feedcont-wrap">
                                
                                <div class="member-thumb">

                                    <a href="<?php the_permalink() ?>">

                                   <?php if ( has_post_thumbnail() ) {
                                        the_post_thumbnail('medium');
                                        } else { ?>
                                        <img src="<?php bloginfo('template_directory'); ?>/images/default-member-image.jpg" alt="<?php the_title_attribute(); ?>" />
                                        <?php } ?>

                                    </a>
                                    
                                </div><!-- end member-thumb -->	    
                                
                                
                                <div class="feedcont-content"> 

                                    <a class="cat-text" href="<?php echo esc_url(get_post_type_archive_link(get_post_type())); ?>" class="post-type">
                                <?php echo esc_html(get_post_type()); ?>
                                    </a>
                                    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                                </div>
                                
                                </div>
                             </div><!-- END feedcont-->


<?php endwhile; else:

endif;
wp_reset_query(); // reset the query
?>	
</div>  <!-- end row -->

<div class="row" style="margin-top: 1rem; margin-bottom: 3rem;">
<div class="col-sm-12 text-center">
			<a class="link-nav" href="/our-work/">All work</a> | <a class="link-nav" href="/articles/">Articles</a> | <a class="link-nav" href="/reports/">Research</a> | <a class="link-nav" href="/submissions/">Submissions</a>
		</div>
</div>  <!-- end row -->