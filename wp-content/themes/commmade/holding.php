<?php
/*
Template Name: holding-temp
*/
?>
<!DOCTYPE html>
<html lang="en"><head >

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta content="index, follow, noarchive" name="robots">
	<meta name="google-site-verification" content="X_SuFmC9mGtqfiV7KcxBc8R8dcnq75GZl-yqs93B5Ow" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/images/favicon-16x16.png">
	<link rel="manifest" href="<?php bloginfo('template_directory'); ?>/site.webmanifest">
    
        <?php
        $template_directory = get_bloginfo('template_url');
        
        wp_enqueue_style('style', get_bloginfo('stylesheet_url'));
		wp_enqueue_style('awesome', $template_directory.'/css/all.css');

		
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', false, '1.12.4', false);
        wp_enqueue_script( 'jquery');
	
		wp_enqueue_script( 'flexmenu', $template_directory."/js/jquery.flexmenu.js", array('jquery'), null, true);
		wp_enqueue_script( 'bootstrap', $template_directory."/bootstrap/js/bootstrap.min.js", array('jquery'), null, true);
		wp_enqueue_script( 'scrollTo', $template_directory."/js/jquery.scrollTo.js", array('jquery'), null, true);
		wp_enqueue_script( 'fancyboxeasing', $template_directory."/js/jquery.easing-1.3.pack.js", array('jquery'), null, true);
		wp_enqueue_script( 'scroll', $template_directory."/js/scroll.js", array('jquery'), null, true);

		?>

    
	<?php wp_head();?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="<?php bloginfo('template_url'); ?>/css/ie8.css" />
	<![endif]-->   
	
<link rel="stylesheet" href="https://use.typekit.net/hlv3yhd.css">

 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />



</head>
    
  <body <?php body_class(); ?>>

<!-- begin content -->


<div class="wp-site-blocks">
<main id="wp--skip-link--target" class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:var(--wp--preset--spacing--60)">
<div class="wp-block-group alignfull has-global-padding is-layout-constrained wp-container-core-group-is-layout-bd7bfa8f wp-block-group-is-layout-constrained" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><div class="entry-content alignfull wp-block-post-content has-global-padding is-layout-constrained wp-block-post-content-is-layout-constrained">
<div class="wp-block-cover alignfull is-light has-parallax landingpg-content has-custom-css has-accent-1-color has-text-color has-link-color wp-elements-96eb15e961230100187bffc05c03e199 wp-custom-css-6be20f7f" style="margin-top:0;margin-bottom:0;padding-top:200px;padding-right:var(--wp--preset--spacing--50);padding-bottom:200px;padding-left:var(--wp--preset--spacing--50);min-height:100vh;aspect-ratio:unset;"><div class="wp-block-cover__image-background wp-image-33 size-full has-parallax" style="background-position:50% 50%;background-image:url(https://communitymade.org.au/wp-content/uploads/2026/06/spacer-pattern.png)"></div><span aria-hidden="true" class="wp-block-cover__background has-white-background-color has-background-dim-10 has-background-dim"></span><div class="wp-block-cover__inner-container has-global-padding is-layout-constrained wp-container-core-cover-is-layout-6714f75d wp-block-cover-is-layout-constrained">
<p class="has-text-align-center has-base-color has-text-color has-link-color wp-elements-7acf96badc9771d58a7ce4d4976d9ad0 wp-block-paragraph">Something exciting is on the way.</p>



<h3 class="wp-block-heading has-text-align-center has-base-color has-text-color has-link-color has-xx-large-font-size wp-elements-e3ff9bc037020c94c01573289bb7c0d8">The Community Made campaign launches soon – so stay tuned!</h3>



<figure class="wp-block-image size-large"><img fetchpriority="high" decoding="async" width="1024" height="451" src="https://communitymade.org.au/wp-content/uploads/2026/06/community-made-logo-lozonge-1024x451.png" alt="" class="wp-image-16" srcset="https://communitymade.org.au/wp-content/uploads/2026/06/community-made-logo-lozonge-1024x451.png 1024w, https://communitymade.org.au/wp-content/uploads/2026/06/community-made-logo-lozonge-300x132.png 300w, https://communitymade.org.au/wp-content/uploads/2026/06/community-made-logo-lozonge-768x339.png 768w, https://communitymade.org.au/wp-content/uploads/2026/06/community-made-logo-lozonge.png 1200w" sizes="(max-width: 1024px) 100vw, 1024px"></figure>
</div></div>
</div></div>
</main>
</div>



<?= wp_footer() ?> 
</body>

</html>