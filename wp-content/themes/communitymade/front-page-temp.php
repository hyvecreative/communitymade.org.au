<?php
/*
Template Name: front-page-temp
*/
?><?php get_header(); ?>


<main>
	
<div class="container-fluid hm-hero">
    <div class="container hm-hero-wrap">
        <div class="row">
             <div class="col-lg-5 hero-text-wrap">
                            <h1 data-aos="fade-up"><?php the_field('hm_hero_title'); ?></h1>
                            <h2 data-aos="fade-up" data-aos-delay="200" ><?php the_field('hm_hero_title_sm'); ?></h2>
                            <p data-aos="fade-up" data-aos-delay="400" ><?php the_field('hm_hero_sub'); ?></p>
                            <a href="#newsUpdates" class="btn btn-clear">Join us <i class="fa-light fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-7 hero-image-wrap hero-slider">
                     <div class="slider-pic"><img src= "<?php bloginfo('template_directory'); ?>/images/hero-pic_people_4.webp" alt="" /></div>
                     <div class="slider-pic"><img src= "<?php bloginfo('template_directory'); ?>/images/hero-pic_people_11.webp" alt="" /></div> 
                     <div class="slider-pic"><img src= "<?php bloginfo('template_directory'); ?>/images/hero-pic_people_7.webp" alt="" /></div>
                     <div class="slider-pic"><img src= "<?php bloginfo('template_directory'); ?>/images/hero-pic_people_9.webp" alt="" /></div> 
                     <div class="slider-pic"><img src= "<?php bloginfo('template_directory'); ?>/images/hero-pic_people_8.webp" alt="" /></div>
                     <div class="slider-pic"><img src= "<?php bloginfo('template_directory'); ?>/images/hero-pic_people_10.webp" alt="" /></div> 
            </div>
        </div>
        
        
    </div>
    
    
    
</div>
    
    	
<div class="container-fluid hm-spruik">
    <div class="container">
        <div class="row">
             <div class="col-12">
                 <h2 data-aos="fade-up" data-aos-delay="800">Great homes and communities,<br />built by the people who know how</h2>
            </div>
        </div>
    </div>
</div>


<article id="content">
    
<!-- Issues Block -->
    
<div id="section-issues" class="container-fluid section-issues">
    
	<div  class="container" style="position: relative;">
        
		<?php
            $issues_head = get_field('issues_head');

            if ($issues_head) :
            ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2><?php echo esc_html($issues_head); ?></h2>
                    </div>
                </div>
        <?php endif; ?>
            
        <div class="row issues_wrap">

         <?php $count = 1; ?>
         <?php $count2 = 1; ?>

         <?php if( have_rows('issues_items') ): while ( have_rows('issues_items') ) : the_row(); ?>
        
             <div class="col-lg-6 issues-item-wrap">
                 <div class="issues-item">

                        <?php
                        $image = get_sub_field('issue_icon');
                        $size = 'full'; // (thumbnail, medium, large, full or custom size)
                        if( $image ) {
                            echo wp_get_attachment_image( $image, $size );
                        }
                        ?>
                 
                        <h3><?php the_sub_field('issues_item_hd'); ?></h3>

                        
                        <?php if (get_sub_field('issues_sub_head')) : ?>
                            <p class="issue-sub"><strong><?php the_sub_field('issues_sub_head'); ?></strong></p>
                        <?php endif; ?>

                        <?php the_sub_field('issues_item_txt'); ?>
                     
                         <?php if (get_sub_field('issues_target_url')) : ?>
                         <a class="btn btn-blue" href="<?php the_sub_field('issues_target_url'); ?>"><?php the_sub_field('issues_link_text'); ?> <i class="fa-light fa-arrow-right"></i></a>
                         <?php endif; ?>
                        
                </div>
             </div>
  
            <?php endwhile; else: endif; ?>
            </div> <!-- end issues items -->

    </div>
</div>
    
<!-- Video Block -->
    
<div id="video-section" class="container-fluid video-section" style="display: block!important;">
    
	<div  class="container" style="position: relative;">
        
		<?php
            $video_head = get_field('video_head');
            $video_intro = get_field('video_intro');

            if ($video_head) :
            ?>
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center video-header-text">
                        <h2><?php echo esc_html($video_head); ?></h2>
                        <p><?php echo esc_html($video_intro); ?></p>
                    </div>
                </div>
        <?php endif; ?>
            
        <div class="row">
        
             <div class="col video-item-wrap">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
                        <?php the_content(__('(more...)')); ?>

                        <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no video content is available.'); ?></p>
                    <?php endif; ?>	
             </div>

        </div> <!-- end video wrap -->

    </div>
</div>
    
    
    
<!-- Quick stats  --> 
    
<div id="section-stats" class="container-fluid hm-quick-stats">
    
	<div  class="container" style="position: relative;">
		
		<div class="row">
				<div class="col-12 text-center">
                    <h2 class="text-center">Quick Stats – Community Housing in NSW<?php the_field('stats_head'); ?></h2>
                </div>
                
                
                <div class="col-lg-4 text-center stats-wrap">
                    <div class="stats-item">
                        <h2>67,000+ </h2>
                        <p>rental homes owned or managed </p>
                     </div>
                </div>
                <div class="col-lg-4 text-center stats-wrap">
                    <div class="stats-item">
                        <h2>8,800 </h2>
                        <p>new homes built since 2012 </p>
                     </div>
                </div>
                <div class="col-lg-4 text-center stats-wrap">
                    <div class="stats-item">
                        <h2>81% </h2>
                        <p>of residents satisfied with their home</p>
                     </div>
                </div>

            </div>
                
		</div>
			
</div>

    
    <div id="newsUpdates" class="container-fluid news-and-updates">
	<div  class="container" style="position: relative;">
        
    <!-- start news on/off --> 
        <?php if ( get_field('display_news_section') ) : ?>
            <div class="news-on">

                    <div class="row news-title">
                        <div class="col-md-12">
                            <h2>News and updates</h2>
                            <?php the_field('news_intro', 'option'); ?>
                        </div>
                    </div>


                            <?php
                            $featured_posts = get_field('report_questions');
                            if( $featured_posts ): ?>
                                <div class="row hm-work">

                                <?php foreach( $featured_posts as $post ): 

                                    // Setup this post for WP functions (variable must be named $post).
                                    setup_postdata($post); ?>


                                    <!-- begin storypost -->


                                        <div class="col-md-4 feedcont text-left" style="display:flex; ">

                                            <div class="feedcont-wrap" style="flex: 0 1 100%; padding: 0;"> 


                                            <div class="feedcont-content" style="padding: 1rem 2rem 1.5rem;"> 

                                                <a class="cat-text" aria-label="Published on <?php echo esc_html( get_the_date() ); ?>">
                                                    <?php echo esc_html( get_the_date() ); ?>
                                                </a>
                                                <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                                                <?php echo esc_html( get_the_excerpt() ); ?>
                                            </div>

                                            </div>
                                         </div><!-- END feedcont-->

                                    <?php endforeach; ?>
                                </div>
                                <?php 
                                // Reset the global post object so that the rest of the page works correctly.
                                wp_reset_postdata(); ?>
                            <?php endif; ?>
                
              </div> <!-- end news on/off -->
            <?php endif; ?>  
        
    <div class="row" style="">
        <div class="col-12 updates-form-col">
                        
                    <div class="row updates-form-wrap" style="">
                    
                        <div class="col-lg-6 updates-form-head">
                        <h2>Add your name</h2><br>
                            <p>Building enough community housing is a choice, and the people elected in your seat will be the ones who make it for us all. 
                            <p>To receive updates, add your name to the growing list of supporters backing community housing.</
                            </p>
                        </div>
                    
                       <div class="col-lg-6 updates-form">
                            <?php
                            $sw_form = get_field('sw_form', 'option'); // full AN embed
                            $chia_priv = get_field('collection_statement', 'option'); // Pricavt statement site wide
                           
                            if ($sw_form) {
                                // 1️⃣ Remove any <script> tags so JS doesn't run immediately
                                $sw_form_no_script = preg_replace('/<script.*?<\/script>/is', '', $sw_form);

                                // 2️⃣ Echo the remaining HTML (CSS link + placeholder div)
                                echo $sw_form_no_script;
                            }
                            ?>
                           
                            <?php echo wp_kses_post($chia_priv); ?>  
                           
                        </div>
                    
                    </div>
                        
    </div>
                    
    </div>
        
        
</div>
</div>
    
	
</article>
</main>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var placeholder = document.querySelector('#can-form-area-i-support-community-made');
    if (!placeholder) return;

    // Use IntersectionObserver to load script when placeholder scrolls into view
    var observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {

                // Find the original script in the ACF field
                var acfHTML = <?php echo json_encode($sw_form); ?>;
                var scriptMatch = acfHTML.match(/<script.*?src=['"]([^'"]+)['"].*?<\/script>/i);

                if (scriptMatch && scriptMatch[1]) {
                    var s = document.createElement('script');
                    s.src = scriptMatch[1];
                    s.async = true;
                    placeholder.appendChild(s);
                }

                observer.unobserve(placeholder);
            }
        });
    }, { threshold: 0.1 });

    observer.observe(placeholder);
});
</script>

<?php get_footer(); ?>



