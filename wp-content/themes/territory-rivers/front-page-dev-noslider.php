<?php
/*
Template Name: front_page_dev_noslider
*/
?>
<?php
get_header(); 
?>

<!-- begin content -->

<div class="container-fluid hm-pg-header" style="position: relative;">
    
        <?php if(has_post_thumbnail()) {
							$feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full", true);
						} ?>
		<div class="row hm-feature-wrap" style="background-image:url(<?php echo (($feat_image[0]))?>);"></div>
    
		<div class="row hm-feature">
            <div class="col col-lg-5 hm-form">
                <div class="col hm-form-wrap">
                        <h1><?php the_field('banner_hm_head') ?></h1>
                        <h2><?php the_field('banner_hm_sub') ?></h2>
                        <?php the_field('banner_hm_form') ?>
                        <?php the_field('collection_statement', 'option') ?>
                    </div>
            </div>
	    </div>
    
        <div class="row hm-feature-text">
            <div class="col hero-scroll-wrap text-center">
                <?php the_field('banner_hm_button') ?>
            </div>
        </div>
    
	    <div class="hm-wave"><img src="<?php bloginfo('template_directory'); ?>/images/hm-wave.png" alt="AMSRO" /></div>
    
</div>


<div id="content" class="container-fluid intro-panel">
	<div class="container">
		<div class="row">
            <div class="col-12 text-center" style="margin-bottom: 1rem;"><h2>Keep 'em flowing'</h2></div>
			<div class="col-12">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(__('(more...)')); ?>

				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no pages are available.2'); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
    <div class="hm-wave"><img src="<?php bloginfo('template_directory'); ?>/images/hm-wave-dk.png" alt="AMSRO" /></div>
</div>

<div id="our-rivers" class="container-fluid river-sections rivers-panel-wrap" style="background: #7b2015;">
		<div class="row">
			<div class="col-12 rivers-panel">
				<p class="text-center river-trigger">
				  <a class="btn btn-rivers" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">See our rivers <i class="fas fa-chevron-down rotate-icon" aria-hidden="true"></i></a>
				</p>
				<div class="collapse" id="collapseExample">
					<div class="card card-body">
						<?php get_template_part( 'partials/content', 'rivers' ); ?>
					</div>
				</div>
			</div>
		</div>
</div>

<div id="river-people" class="container-fluid river-sections" style="position: relative;">
<div class="container">
		<div class="row text-center">
			
			<div class="col-12" style="margin-bottom: 1rem;">
				<h2><?php the_field('champions_title') ?></h2>
				<p><?php the_field('champions_intro') ?></p>
			</div>
		</div>
			
			<?php if( have_rows('river_people') ): while ( have_rows('river_people') ) : the_row(); ?>
		<div class="row text-center people-grid">
			<div class="col-12 col-md-6 river-wrapper river-image">
			<?php
					$image = get_sub_field('rp_image');
					$size = 'full'; // (thumbnail, medium, large, full or custom size)

					if( $image ) {

					echo wp_get_attachment_image( $image, $size );

					}
					?>
			</div>
			
			<div class="col-12 col-md-6 river-wrapper">
				<div class="river-text-wrap">
					<h2><?php the_sub_field('rp_name') ?></h2>
					<h3><?php the_sub_field('rp_location') ?></h3>
					<p><?php the_sub_field('rp_quote') ?></p>
					<p class="<?php the_sub_field('rp_off') ?>"><a class="btn btn-on-yell" href="<?php the_sub_field('rp_url') ?>"><?php the_sub_field('rp_text') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
								
		</div>
				<?php endwhile; else: endif; ?>
	
	<div class="row">
		<div class="col-12 text-center" style="margin-top: 2rem; margin-bottom: 2rem;">
			<a href="/people-on-the-river/" class="btn btn-rev" title="Find out more">All River Champions <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
		</div>
	</div>


	</div>
        <div class="hm-wave"><img src="<?php bloginfo('template_directory'); ?>/images/hm-wave-white.png" alt="AMSRO" /></div>
</div>

<div id="threats" class="container-fluid threats-wrap" style="position: relative;"> <!-- threats -->
	<div class="container">	
		<div class="row text-center">
			
			<div class="col-12 col-lg-8 offset-lg-2" style="margin-bottom: 2rem;">
				<h2><?php the_field('threats_title') ?></h2>
				<?php the_field('threats_intro') ?>
			</div>
			
			<div class="row">
				<?php if( have_rows('threats') ): while ( have_rows('threats') ) : the_row(); ?>
					<div class="col-sm-6 col-md-3 col-lg-3 threat-icons">
						
						<a href="<?php the_sub_field('threat_url'); ?>"><div class="image-wrap">

							<?php
							$image = get_sub_field('threat_image');
								?>

							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
							<h2 class="threat-text-hd"><?php the_sub_field('threat_text_hd'); ?></h2>
							</div></a>
								
						<p class="<?php the_sub_field('threat_text_display'); ?>"><?php the_sub_field('threat_text'); ?> <a href="<?php the_sub_field('threat_url'); ?>">More <i class="fas fa-chevron-right small-i" aria-hidden="true"></i></a></p>
								
					</div>
				<?php endwhile; else: endif; ?>
			</div>
			
			<div class="col-12" style="margin-top: 1rem; margin-bottom: 2rem;">
				<a href="<?php the_field('threat_button_url') ?>" class="btn btn-rivers" title="Find out more"><?php the_field('threat_button_text') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
			</div>
			
		</div>
	</div>
</div>

<div id="threats" class="container-fluid threats-wrap next-wrap" style="position: relative;"> <!-- what happens next -->
	<div class="container">	
		<div class="row text-center">
			
			<div class="col-12 col-lg-8 offset-lg-2" style="margin-bottom: 2rem;">
				<h2><?php the_field('what_next_title') ?></h2>
				<?php the_field('what_next_intro') ?>
			</div>
			
			<div class="row" style="justify-content: center;">
				<?php if( have_rows('what_next') ): while ( have_rows('what_next') ) : the_row(); ?>
					<div class="col-sm-6 col-md-3 col-lg-3 threat-icons">
						
						<a href="<?php the_sub_field('next_url'); ?>"><div class="image-wrap">

							<?php
							$image = get_sub_field('next_image');
								?>

							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
							<h2 class="threat-text-hd"><?php the_sub_field('next_hd'); ?></h2>
							</div></a>
								
						<p class="<?php the_sub_field('what_next_display'); ?>"><?php the_sub_field('next_text'); ?> <a href="<?php the_sub_field('next_url'); ?>">More <i class="fas fa-chevron-right small-i" aria-hidden="true"></i></a></p>
								
					</div>
				<?php endwhile; else: endif; ?>
			</div>
			
			<div class="col-12" style="margin-top: 1rem; margin-bottom: 2rem;">
				<a href="<?php the_field('next_button_url') ?>" class="btn btn-rivers" title="Find out more"><?php the_field('next_button_text') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
			</div>
			
		</div>
	</div>
    
    <div class="hm-wave"><img src="<?php bloginfo('template_directory'); ?>/images/hm-wave-dk.png" alt="AMSRO" /></div>

</div>

<div id="promo sectoion" class="container-fluid promo-section" style="position: relative;">
<div class="container">
    
        <div class="row text-center">
			
			<div class="col-12" style="margin-bottom: 1rem;">
				<h2 style="margin-top: 0;">More about our rivers</h2>
			</div>
		</div>
    
		<div class="row promo-grid text-center">
            
            <div class="col-12" style="margin-bottom: 1rem;">
                <?php
				    $image = get_field('promo_image');
				?>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
            </div>
            
            <div class="promo-grid-wrap" style="display: flex;">
			
                <div class="col-12" style="margin-bottom: 1rem;">
                    <h2><?php the_field('promo_title') ?></h2>
                    <?php the_field('promo_intro') ?>
                    <a href="<?php the_field('promo_url') ?>" class="btn btn-rivers" title="Find out more" style="margin-bottom: 0;"><?php the_field('promo_btn_text') ?> <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
                </div>
                
            </div> 
            
		</div>

	</div>
        <div class="hm-wave"><img src="<?php bloginfo('template_directory'); ?>/images/hm-wave.png" alt="AMSRO" /></div>
</div>

<div id="solutions" class="container-fluid solutions-wrap">
	<div class="container">	
		<div class="row text-center">
			
			<div class="col-12 col-md-8 offset-md-2 solution-intro" style="margin-bottom: 1rem;">
				<h2><?php the_field('solutions_title') ?></h2>
				<h3><?php the_field('solutions_intro') ?></h3>
			</div>
			
			<div class="col-12 col-md-8 offset-md-2 solution-content">
				<?php the_field('solutions_content') ?>
				<p><i class="fas fa-chevron-down fa-3x" aria-hidden="true" style="color: #7b2015"></i></p>
			</div>
			
			<div class="col-12 col-md-8 offset-md-2 solution-cta">
				<h2><?php the_field('solution_cta_title') ?></h2>
				<p><?php the_field('solution_cta_text') ?></p>
			</div>
            
            
			
		</div>
        
        <div id="sign-up" class="row sign-up sign-up-hm text-center">
            <div class="col-12 col-md-8 offset-md-2 sign-up-wrap">
               <h2 ><?php the_field('join_title') ?></h2>
               <p><?php the_field('join_text') ?><p>
               <?php echo get_field('join_form') ?>
               <?php the_field('collection_statement', 'option'); ?>
            </div>
        </div>

	</div>
</div>

		
<div id="hero-pic" class="container-fluid bottom-hero-pic">

		<?php
				$image = get_field('bottom-hero-image');
				$size = 'full'; // (thumbnail, medium, large, full or custom size)

				if( $image ) {

				echo wp_get_attachment_image( $image, $size );

				}
		?>
		<dic class="row">
			<div class="col feature-text feature-bottom">
						<h2 class=""><?php the_field('bot_hero_title') ?></h1>
						<h3 class=""><?php the_field('bot_hero_sub') ?></h2>
		</div>
</div>

</div>

<style>#content.intro-panel h2 {margin-top: 0; margin-bittom: .5rem;}
    .river-sections.rivers-panel-wrap .rivers-panel p.river-trigger {margin: -6.2rem 0 0;}
    p.river-trigger .btn.btn-rivers {font-size: 1.6em; padding: 1.5rem 2rem; letter-spacing: .5px; margin: .5rem 0 1rem; box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);}
</style>

<?php get_footer(); ?>