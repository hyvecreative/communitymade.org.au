<?php

/**
 * Theme Assets (Merged Legacy + dist/assets.json)
 */
function theme_enqueue_assets() {

    /* ---------------------------
     * 1. Load main theme stylesheet
     * --------------------------- */
    wp_enqueue_style('theme-style', get_stylesheet_uri());


    /* ---------------------------
     * 2. AOS CSS
     * --------------------------- */
    wp_enqueue_style(
        'aos-css',
        'https://unpkg.com/aos@next/dist/aos.css',
        [],
        null
    );

    /* ---------------------------
     * 3. Font Awesome Kit
     * --------------------------- */
    wp_enqueue_script(
        'fontawesome',
        'https://kit.fontawesome.com/d7b2e24a18.js',
        [],
        null,
        true
    );


    /* ---------------------------
     * 4. Replace default jQuery
     * --------------------------- */
    wp_deregister_script('jquery');
    wp_register_script(
        'jquery',
        'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
        [],
        '3.5.1',
        true
    );
    wp_enqueue_script('jquery');


    /* ---------------------------
     * 5. Bootstrap + Popper
     * --------------------------- */
    wp_enqueue_script(
        'popper',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'bootstrap',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
        ['jquery', 'popper'],
        null,
        true
    );


    /* ---------------------------
     * 6. Local Theme JS Files
     * --------------------------- */
    $js_dir = get_template_directory_uri() . '/js/';

    wp_enqueue_script('scrollTo',       $js_dir . 'jquery.scrollTo.js', ['jquery'], null, true);
    wp_enqueue_script('scroll',         $js_dir . 'scroll.js',          ['jquery'], null, true);


    /* AOS script */
    wp_enqueue_script(
        'aos-js',
        'https://unpkg.com/aos@2.3.0/dist/aos.js',
        ['jquery'],
        null,
        true
    );


    /* ---------------------------
     * 7. dist/assets.json bundle (Webpack/Vite output)
     * --------------------------- */
    $manifest_path = get_template_directory() . '/dist/assets.json';

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (!empty($manifest['main'])) {
            $main = $manifest['main'];

            // Main compiled CSS
            if (!empty($main['css'])) {
                wp_enqueue_style(
                    'theme-dist-css',
                    get_template_directory_uri() . '/dist/' . $main['css'],
                    [],
                    null
                );
            }

            // Main compiled JS
            if (!empty($main['js'])) {
                wp_enqueue_script(
                    'theme-dist-js',
                    get_template_directory_uri() . '/dist/' . $main['js'],
                    ['jquery'],
                    null,
                    true
                );
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets', 20);


/*******************************

 MENUS SUPPORT

********************************/

if ( function_exists( 'wp_nav_menu' ) ){

	if (function_exists('add_theme_support')) {

		add_theme_support('nav-menus');

		add_action( 'init', 'register_my_menus' );

		function register_my_menus() {

			register_nav_menus(

				array(

					'main-menu' => __( 'Main Menu' ),
	  				'footer-menu' => __( 'Footer Menu' )

				)

			);

		}

	}

}



/* CallBack functions for menus in case of earlier than 3.0 Wordpress version or if no menu is set yet*/



function primarymenu(){ ?>

			<div id="topMenu">

				You need to set up the menu from Wordpress admin.

			</div>

<?php }

/*******************************

Disable Gravity forms - to allow single page load

********************************/

// Disable GF CSS + JS everywhere EXCEPT the target page
add_filter( 'gform_disable_css', function() {
    // Only allow CSS on this page
    return ! is_page( 'complaint-pathway' );
});

add_filter( 'gform_disable_js', function() {
    // Only allow JS on this page
    return ! is_page( 'complaint-pathway' );
});

// Enqueue Gravity Forms scripts for the form ID (optional, ensures proper load)
add_action( 'wp_enqueue_scripts', function() {
    if ( is_page( 'complaint-pathway' ) ) { 
        gravity_form_enqueue_scripts( 7, true ); // Replace 7 with your form ID
    }
});



/*******************************

 Gutenberg blocks

********************************/



acf_register_block_type([
    'name'              => 'anchor-nav',
    'title'             => 'Anchor Navigation',
    'render_template'   => 'template-parts/blocks/anchor-nav.php',
    'category'          => 'formatting',
    'icon'              => 'menu',
    'keywords'          => ['anchor','navigation','menu'],
]);


add_action('acf/init', function() {

    acf_register_block_type([
        'name'            => 'breakout',
        'title'           => 'Breakout',
        'render_template' => 'template-parts/blocks/breakout.php', // simple relative path
        'category'        => 'layout',
        'icon'            => 'align-full-width',
        'keywords'        => ['breakout','box','highlight'],
    ]);

});


/*******************************

GUTENBERG BLOCKS

********************************/


/**
 * Theme Setup
 */
function mytheme_setup() {

    // Core Gutenberg supports
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'appearance-tools' ); // modern WP features

    // Add editor stylesheet
    add_editor_style( 'assets/css/editor-style.css' );

    // Custom font sizes
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __( 'Small', 'mytheme' ),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => __( 'Regular', 'mytheme' ),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => __( 'Large', 'mytheme' ),
            'size' => 22,
            'slug' => 'large'
        ),
    ));

    // Color palette removed as requested
}
add_action( 'after_setup_theme', 'mytheme_setup' );




/**
 * Load Editor + Front-End Styles
 */
function mytheme_enqueue() {

    // Front-end styles
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'mytheme_enqueue' );


/**
 * Editor-only CSS (to match Gutenberg editor with theme styles)
 */
function mytheme_editor_styles() {
    add_editor_style( 'assets/css/editor-style.css' ); // Create this file
}
add_action( 'admin_init', 'mytheme_editor_styles' );



/**
 * Register Block Patterns (optional)
 */
function mytheme_block_patterns() {
    register_block_pattern_category(
        'mytheme',
        array( 'label' => __( 'My Theme Patterns', 'mytheme' ) )
    );

    register_block_pattern(
        'mytheme/hero-banner',
        array(
            'title'   => __( 'Hero Banner', 'mytheme' ),
            'content' => '<!-- wp:group {"align":"full"} --><div class="wp-block-group"><h1>Your Hero Title</h1></div><!-- /wp:group -->',
        )
    );
}
add_action( 'init', 'mytheme_block_patterns' );


/*******************************

 THUMBNAIL SUPPORT

********************************/


add_theme_support('post-thumbnails');
add_image_size('news', 565, 367, true );

/*******************************

 EXCERPT LENGTH ADJUST

********************************/


function home_excerpt_length($length) {
	return 32;
}
add_filter('excerpt_length', 'home_excerpt_length');

// Replaces the excerpt "more" text by a link

function custom_excerpt($text) {  // custom 'read more' link
   if (strpos($text, '[...]')) {
      $excerpt = strip_tags(str_replace('[...]', '...&nbsp;<a href="'.get_permalink().'" class="read&nbsp;more">Read more&nbsp;<i class="fa-solid fa-arrow-right"></i></a>', $text), "<a>");
   } else {
      $excerpt = '' . strip_tags($text) . '&nbsp;<a href="'.get_permalink().'" class="readmore">Read&nbsp;more&nbsp;<i class="fa-solid fa-arrow-right"></i></a>';
   }
   return $excerpt;
}
add_filter('the_excerpt', 'custom_excerpt');

add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}


/*******************************

ADD CUSTOM POST TO CATEGORY

********************************/
 
add_filter( 'pre_get_posts', 'my_get_posts' );

		function my_get_posts( $query ) {

			if ( ( is_home() && $query->is_main_query() ) || is_feed() )
			$query->set( 'post_type', array( 'post', 'my_articles' ) );

		return $query;
		}



/*******************************

 WIDGETS AREAS

********************************/



if ( function_exists('register_sidebar') )

register_sidebar(array(

	'name' => 'sidebar',
    
    'id' => 'site-sidebar',

	'before_widget' => '<div class="rightBox">',

	'after_widget' => '</div>',

	'before_title' => '<h2>',

	'after_title' => '</h2>',

));



register_sidebar(array(

	'name' => 'footer',
    
    'id' => 'footer-sidebar',

	'before_widget' => '<div class="boxFooter">',

	'after_widget' => '</div>',

	'before_title' => '<h2>',

	'after_title' => '</h2>',

));

 
/* REGISTER POSTS PAGINATION */

function kriesi_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == '') { global $wp_query; $pages = $wp_query->max_num_pages; if(!$pages) { $pages = 1; } }
     if(1 != $pages) {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
         for ($i=1; $i <= $pages; $i++) {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }
         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}



 

function emm_paginate($args = null) {

	$defaults = array(

		'page' => null, 'pages' => null, 

		'range' => 3, 'gap' => 3, 'anchor' => 1,

		'before' => '<div class="emm-paginate">', 'after' => '</div>',

		'title' => __('Pages:'),

		'nextpage' => __('&raquo;'), 'previouspage' => __('&laquo'),

		'echo' => 1

	);



	$r = wp_parse_args($args, $defaults);

	extract($r, EXTR_SKIP);



	if (!$page && !$pages) {

		global $wp_query;



		$page = get_query_var('paged');

		$page = !empty($page) ? intval($page) : 1;



		$posts_per_page = intval(get_query_var('posts_per_page'));

		$pages = intval(ceil($wp_query->found_posts / $posts_per_page));

	}

	

	$output = "";

	if ($pages > 1) {	

		$output .= "$before<span class='emm-title'>$title</span>";

		$ellipsis = "<span class='emm-gap'>...</span>";



		if ($page > 1 && !empty($previouspage)) {

			$output .= "<a href='" . get_pagenum_link($page - 1) . "' class='emm-prev'>$previouspage</a>";

		}

		

		$min_links = $range * 2 + 1;

		$block_min = min($page - $range, $pages - $min_links);

		$block_high = max($page + $range, $min_links);

		$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;

		$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;



		if ($left_gap && !$right_gap) {

			$output .= sprintf('%s%s%s', 

				emm_paginate_loop(1, $anchor), 

				$ellipsis, 

				emm_paginate_loop($block_min, $pages, $page)

			);

		}

		else if ($left_gap && $right_gap) {

			$output .= sprintf('%s%s%s%s%s', 

				emm_paginate_loop(1, $anchor), 

				$ellipsis, 

				emm_paginate_loop($block_min, $block_high, $page), 

				$ellipsis, 

				emm_paginate_loop(($pages - $anchor + 1), $pages)

			);

		}

		else if ($right_gap && !$left_gap) {

			$output .= sprintf('%s%s%s', 

				emm_paginate_loop(1, $block_high, $page),

				$ellipsis,

				emm_paginate_loop(($pages - $anchor + 1), $pages)

			);

		}

		else {

			$output .= emm_paginate_loop(1, $pages, $page);

		}



		if ($page < $pages && !empty($nextpage)) {

			$output .= "<a href='" . get_pagenum_link($page + 1) . "' class='emm-next'>$nextpage</a>";

		}



		$output .= $after;

	}



	if ($echo) {

		echo $output;

	}



	return $output;

}



/**

 * Helper function for pagination which builds the page links.

 *

 * @access private

 *

 * @author Eric Martin <eric@ericmmartin.com>

 * @copyright Copyright (c) 2009, Eric Martin

 * @version 1.0

 *

 * @param int $start The first link page.

 * @param int $max The last link page.

 * @return int $page Optional, default is 0. The current page.

 */

function emm_paginate_loop($start, $max, $page = 0) {

	$output = "";

	for ($i = $start; $i <= $max; $i++) {

		$output .= ($page === intval($i)) 

			? "<span class='emm-page emm-current'>$i</span>" 

			: "<a href='" . get_pagenum_link($i) . "' class='emm-page'>$i</a>";

	}

	return $output;

}


/******************
ACF options page
*******************/

if(function_exists('acf_add_options_page')) { 

	acf_add_options_page('');
	acf_add_options_sub_page('Collection Statement');
	acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Site wide options');
}

/*********************
INCLUDE NEEDED FILES
*********************/

require_once('includes/gravity-incs.php');



/*******************************
 excerpt html filter
********************************/

add_filter( 'get_the_content_limit_allowedtags', 'get_the_content_limit_custom_allowedtags' );
/**
* @author Brad Dalton
* @example http://wp.me/p1lTu0-a5w
*/
function get_the_content_limit_custom_allowedtags() {
// Add custom tags to this string
return '<script>,<style>,<br>,<span>,<em>,<i>,<ul>,<ol>,<li>,<a>';
}


?>
