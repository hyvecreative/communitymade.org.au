<!DOCTYPE html>
<html lang="en"><head >

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title> 
<?php
	$site_description = get_bloginfo( 'description', 'display' );
	$site_name = get_bloginfo( 'name' );
    //for home page
	if ( $site_description && ( is_home() || is_front_page() ) ):
		echo $site_name;echo ' | '; echo  $site_description; 
	endif;
	// for other post pages
	if (!( is_home() ) && ! is_404() ):
	the_title(); echo ' | '; echo $site_name;
	endif;
	?>
</title>
	
	<meta content="index, follow, noarchive" name="robots">
	<meta name="google-site-verification" content="X_SuFmC9mGtqfiV7KcxBc8R8dcnq75GZl-yqs93B5Ow" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/images/favicon-16x16.png">
	<link rel="manifest" href="<?php bloginfo('template_directory'); ?>/site.webmanifest">
	<meta name="facebook-domain-verification" content="d31ifweotb7p3l6zve4rkxawfhjt8t" />

	<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};

  ttq.load('CATTDDJC77U5TKNG59QG');
  ttq.page();
}(window, document, 'ttq');
</script>
	
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
	
<link rel="stylesheet" href="https://use.typekit.net/buc8zsh.css">

 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />



</head>
    
  <body <?php body_class(); ?>>
  
<!-- begin wrapper -->
 <div id="wrapper" class="wrapperhome">

<!-- begin header -->

<div id="header" class="header lo-shadow">

<div class="fm-container home-header  clearfix">

<div class="fm-button"><span class="fm-bar"></span><span class="fm-bar"></span><span class="fm-bar"></span></div>
     
<div id="logo">
<a href="<?php bloginfo('url'); ?>/" class="logo"><img src="<?php bloginfo('template_directory'); ?>/images/generic-logo.png" alt="Territory Rivers" /></a>
</div>

<div class="header-items">
<nav id="nav">
     <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'topmenu', 'container_class' => 'a-menu', 'items_wrap' => '<ul id="mymenu">%3$s</ul>' ) ); ?>
</nav>

</div>  <!-- end header-items-->  
	
<div class="hs-social">
	<a href="<?php the_field('facebook_url', 'option'); ?>" class="fb-share" ><i aria-hidden="true" class="fab fa-facebook-square fa-2x" title="Find us on Facebook"></i><span class="sr-only">Find us on facebook</span></a>
	
	<a href="<?php the_field('tiktok_url', 'option'); ?>" class="tw-share"><i aria-hidden="true" class="fab fa-tiktok fa-2x" title="TikTok"></i><span class="sr-only">Find us on TikTok</span></a>
	
	<a href="<?php the_field('instagram_url', 'option'); ?>" class="tw-share"><i aria-hidden="true" class="fab fa-instagram fa-2x" title="Find us on Instagram"></i><span class="sr-only">Find us on Instagram</span></a>
</div>	
           
</div>  <!-- end fm-container -->          
</div>
	 <!-- Google tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-192515329-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-192515329-1');
</script>
	 <!-- END Header -->



 


	
