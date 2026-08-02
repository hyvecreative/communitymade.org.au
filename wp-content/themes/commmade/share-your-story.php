<?php
/*
Template Name: share-your-story
*/
?><?php get_header(); ?>


<main>
	
<div class="container-fluid hm-hero">
    <div class="container hm-hero-wrap">
        <div class="row share-stories">
             <div class="col-lg-6 hero-text-wrap ">
                            <h1 data-aos="fade-up"><?php the_field('hm_hero_title'); ?></h1>
                            <h2 data-aos="fade-up" data-aos-delay="200" ><?php the_field('hm_hero_title_sm'); ?></h2>
                            <p data-aos="fade-up" data-aos-delay="400" ><?php the_field('hm_hero_sub'); ?></p>
            </div>
            <div class="col-lg-6 hero-image-wrap" style="display: flex;">
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


<article id="content">
    
<!-- Issues Block -->
    
    
<!-- Video Block -->
    
<div id="share-section" class="container-fluid share-section">
    
	<div  class="container" style="position: relative;">
            
        <div class="row">
        
             <div class="col-lg-5 share-content">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
                        <?php the_content(__('(more...)')); ?>

                        <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no video content is available.'); ?></p>
                    <?php endif; ?>	
             </div>
            
            <div class="col-lg-6 offset-lg-1 share-form">
                <?php
                $action_title = get_field('action_title');
                $action_sub_title = get_field('action_sub_title');
                $action_form = get_field('action_form');

                    if ($action_title) :
                    ?>
                    <h2><?php echo esc_html($action_title); ?></h2>
                    <h3 style="margin-bottom: 1.5rem;"><?php echo esc_html($action_sub_title); ?></h3>
                    <?php endif; ?>
                
                    <div><?php echo $action_form; ?></div>
            </div>

        </div> <!-- end video wrap -->

    </div>
</div>   
	
</article>
</main>

<?php get_footer(); ?>



