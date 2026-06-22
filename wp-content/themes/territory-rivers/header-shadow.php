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
	
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />



</head>
    
  <body <?php body_class(); ?>>
  
<!-- begin wrapper -->
 <div id="wrapper" class="wrapperhome">

<!-- begin header -->
<div id="header" class="lo-shadow">

<div class="fm-container home-header  clearfix">

<div class="fm-button"><span class="fm-bar"></span><span class="fm-bar"></span><span class="fm-bar"></span></div>
     
<div id="logo">
<a href="<?php bloginfo('url'); ?>/"><img src="<?php bloginfo('template_directory'); ?>/images/cpactive-logo.png" alt="CPActive" /></a>
</div>

<div class="header-items">
<nav id="nav">
     <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'topmenu', 'container_class' => 'a-menu', 'items_wrap' => '<ul id="mymenu">%3$s</ul>' ) ); ?>
</nav>

</div>  <!-- end header-items-->  
           
</div>  <!-- end fm-container -->          
</div><!-- END Header -->



 


	
