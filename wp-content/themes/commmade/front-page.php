<?php
/*
Template Name: front-page-temp
*/
?><?php get_header(); ?>


<main>
	
<div class="container-fluid hm-hero">
    <div class="container">
        <div class="row">
             <div class="col-lg-5 hero-text-wrap">
                            <h1><?php the_field('hm_hero_title'); ?></h1>
                            <p><?php the_field('hm_hero_sub'); ?></p>
                            <a href="#" class="btn btn-green">Send a message to your local MP <i class="fa-light fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-7 hero-image-wrap" style="display: flex;">
            <?php if (has_post_thumbnail()) : 
                $thumb_id = get_post_thumbnail_id($post->ID);

                $img_full   = wp_get_attachment_image_src($thumb_id, 'full');
                $img_large  = wp_get_attachment_image_src($thumb_id, 'large');
                $img_medium = wp_get_attachment_image_src($thumb_id, 'medium');
            ?>
                <img 
                    src="<?php echo esc_url($img_large[0]); ?>" 
                    srcset="<?php echo esc_url($img_medium[0]); ?> <?php echo $img_medium[1]; ?>w, 
                            <?php echo esc_url($img_large[0]); ?> <?php echo $img_large[1]; ?>w, 
                            <?php echo esc_url($img_full[0]); ?> <?php echo $img_full[1]; ?>w"
                    sizes="(max-width: 768px) 100vw, 58vw"
                    alt="<?php the_title_attribute(); ?>"
                    class="hero-img">
            <?php endif; ?>

            </div>
            </div>
        </div>
</div>
    
    	
<div class="container-fluid hm-spruik">
    <div class="container">
        <div class="row">
             <div class="col-12">
                 <h2>Community Housing:<br />
                    A solution that is for the people, by the people. </h2>
                    <i class="hm-down-arrow fa-light fa-circle-arrow-down fa-xl"></i>
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

                        <p><?php the_sub_field('issues_item_txt'); ?><p>
                     
                         <?php if (get_sub_field('issues_target_url')) : ?>
                         <a class="btn btn-blue" href="<?php the_sub_field('issues_target_url'); ?>" style="margin-top: 0;"><?php the_sub_field('issues_link_text'); ?> <i class="fa-light fa-arrow-right"></i></a>
                         <?php endif; ?>
                        
                </div>
             </div>
  
            <?php endwhile; else: endif; ?>
            </div> <!-- end issues items -->

    </div>
</div>
    
<!-- Quick stats  --> 
    
<div id="section-stats" class="container-fluid hm-quick-stats">
    
	<div  class="container" style="position: relative;">
		
		<div class="row">
				<div class="col-12 text-center">
                    <h2 class="text-center">Quick Stats<?php the_field('stats_head'); ?></h2>
                </div>
                
                
                <div class="col-lg-4 text-center stats-wrap">
                    <div class="stats-item">
                    <p>Stats 1</p>
                     </div>
                </div>
                <div class="col-lg-4 text-center stats-wrap">
                    <div class="stats-item">
                    <p>Stats 2</p>
                     </div>
                </div>
                <div class="col-lg-4 text-center stats-wrap">
                    <div class="stats-item">
                    <p>Stats 3</p>
                     </div>
                </div>

            </div>
                
		</div>
			
</div>


<!-- Intro  -->
    
<div id="section-intro" class="container-fluid section-intro" style="display: none">
    
	<div  class="container" style="position: relative;">
		
		<div class="row">
			<div class="col-md-12 intro-text-wrapper">
				<h2><?php the_field('intro_head'); ?></h2>
			</div>
			
		</div>
        
        <div class="row intro-holder">
            <div class="col-lg-6 intro-content-wrap">
                <?php the_field('intro_content'); ?>
		    </div>
            <div class="col-lg-6 deadline-wrapper">
                <h2 style="color: #ffffff; margin-top: .5rem;"><?php the_field('deadline_heading'); ?></h2>
                <?php if ( get_field('deadline_content') ) : ?>
                    <?php the_field('deadline_content'); ?>
                <?php endif; ?>
			    <a class="btn btn-lg" style="margin-top: 0;" href="<?php the_field('deadline_button_url'); ?>" aria-label="View the About Us page"><?php the_field('deadline_button_text'); ?> <i class="fa-solid fa-arrow-right"></i></a>
		    </div>
            <div class="brand-pointer"></div>
        </div> 
        
    </div>
</div>
    
<!-- What Happened?  -->
 <div id="whatHappened" class="container-fluid what-happened">
	<div  class="container" style="position: relative;">    

        
        <div class="row happened-title">
			<div class="col-md-12 intro-text-wrapper">
				<h2 class="text-center"><?php the_field('what_head'); ?></h2>
			</div>
		</div>
        
        <div class="row" style="margin-top:0; margin-bottom: 0;">

         <?php $count = 1; ?>
         <?php $count2 = 1; ?>

         <?php if( have_rows('what_happened') ): while ( have_rows('what_happened') ) : the_row(); ?>
        
             <div class="col-lg-6 happened-left">
                <div class="row happened-row">
                    <div class="col-3 happened-item-img">
                        <?php
                        $image = get_sub_field('happ_icon');
                        $size = 'full'; // (thumbnail, medium, large, full or custom size)
                        if( $image ) {
                            echo wp_get_attachment_image( $image, $size );
                        }
                        ?>
                    </div>
                    
                   
                    <div class="col-9 happened-item-text">
                        
                    <?php if (get_sub_field('happ_sub')) : ?>
                            <p style="margin-bottom: -.5rem"><strong><?php the_sub_field('happ_sub'); ?></strong></p>
                        <?php endif; ?>

                        <?php the_sub_field('happ_content'); ?> <a href="<?php the_sub_field('happ_url'); ?>" style="margin-top: 0;"><?php the_sub_field('happ_link_text'); ?> <i class="fa-solid fa-arrow-right"></i></a>
                        
                    </div>
                </div>
                
            </div>
            
        
        
            <?php endwhile; else: endif; ?>
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
                        <h2>Sign up for updates</h2>
                        </div>
                    
                       <div class="col-lg-6 updates-form">
                            <?php
                            $sw_form = get_field('sw_form', 'option'); // full AN embed

                            if ($sw_form) {
                                // 1️⃣ Remove any <script> tags so JS doesn't run immediately
                                $sw_form_no_script = preg_replace('/<script.*?<\/script>/is', '', $sw_form);

                                // 2️⃣ Echo the remaining HTML (CSS link + placeholder div)
                                echo $sw_form_no_script;
                            }
                            ?>
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
    var placeholder = document.querySelector('#can-form-area-tysb-get-updates-form');
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



