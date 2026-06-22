<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	


<div class="newsitem">  
		<div class="newsitem-wrap">  		                
            <div class="newscont">

                <div class="meta clearfix">
                    <span class="date"><?php the_time('M j, Y') ?></span>
                </div><!-- end meta -->

                <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

                <p class="excerpthm"><?php the_excerpt(); ?></p>

            </div> <!-- END feedcont-->
			
		</div>
		
<div class="feedrule"></div>

</div> <!-- END feeditem-->

					
<?php endwhile; ?>

				

				<?php else : ?>

				<p>Sorry, but you are looking for something that isn't here.</p>

				<?php endif; ?>


<!--<div class="navigation">

							<div class="alignleft"><?php next_posts_link() ?></div>

							<div class="alignright"><?php previous_posts_link() ?></div>

</div>-->

				<?php if (function_exists("emm_paginate")) {

					emm_paginate();

				} ?>