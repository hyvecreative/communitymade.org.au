<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	


<!-- begin storypost -->

               <div class="col-md-4 feedcont text-left" style="display:flex; ">
                                
                                <div class="feedcont-wrap" style="flex: 0 1 100%; padding: 0;">
                                
                                <div class="member-thumb">

                                    <a href="<?php the_permalink() ?>">

                                   <?php if ( has_post_thumbnail() ) {
                                        the_post_thumbnail('medium');
                                        } else { ?>
                                        <img src="<?php bloginfo('template_directory'); ?>/images/default-member-image.jpg" alt="<?php the_title_attribute(); ?>" />
                                        <?php } ?>

                                    </a>
                                    
                                </div><!-- end member-thumb -->	    
                                
                                
                                <div class="feedcont-content" style="padding: .5rem 1rem 1rem;"> 

                                <div>
                                    
                                    <?php           
                $product_terms = wp_get_object_terms( $post->ID,  'articles_categories' );
if ( ! empty( $product_terms ) ) {
	if ( ! is_wp_error( $product_terms ) ) {
			foreach( $product_terms as $term ) {
				echo '<a class="' . $term->slug .'" href="' . get_term_link( $term->slug, 'articles_categories' ) . '">' . esc_html( $term->name ) . '</a> '; 
			}

	}
} ?> 

                                    
                                    
                         </div>
                                    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
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