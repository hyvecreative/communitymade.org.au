<?php

/**
 * Theme assets
 */
if (file_exists(get_template_directory() . '/dist/assets.json')) {
  add_action('wp_enqueue_scripts', function () {

      $manifest = json_decode(file_get_contents('dist/assets.json', true));
      $main = $manifest->main;
      wp_enqueue_style('theme-css', get_template_directory_uri() . "/dist/" . $main->css,  false, null);
      wp_enqueue_script('theme-js', get_template_directory_uri() . "/dist/" . $main->js, ['jquery'], null, true);
  }, 100);
}


// Add support for responsive embedded content.
add_theme_support( 'responsive-embeds' );

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
      $excerpt = strip_tags(str_replace('[...]', '...&nbsp;<a href="'.get_permalink().'" class="readmore">Read more <i class="fas fa-chevron-right"></i></a>', $text), "<a>");
   } else {
      $excerpt = '' . strip_tags($text) . '&nbsp;<a href="'.get_permalink().'" class="readmore">Read more <i class="fas fa-chevron-right"></i></a>';
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

 

	

/*******************************

 PAGINATION

********************************

 * Retrieve or display pagination code.

 *

 * The defaults for overwriting are:

 * 'page' - Default is null (int). The current page. This function will

 *      automatically determine the value.

 * 'pages' - Default is null (int). The total number of pages. This function will

 *      automatically determine the value.

 * 'range' - Default is 3 (int). The number of page links to show before and after

 *      the current page.

 * 'gap' - Default is 3 (int). The minimum number of pages before a gap is 

 *      replaced with ellipses (...).

 * 'anchor' - Default is 1 (int). The number of links to always show at begining

 *      and end of pagination

 * 'before' - Default is '<div class="emm-paginate">' (string). The html or text 

 *      to add before the pagination links.

 * 'after' - Default is '</div>' (string). The html or text to add after the

 *      pagination links.

 * 'title' - Default is '__('Pages:')' (string). The text to display before the

 *      pagination links.

 * 'next_page' - Default is '__('&raquo;')' (string). The text to use for the 

 *      next page link.

 * 'previous_page' - Default is '__('&laquo')' (string). The text to use for the 

 *      previous page link.

 * 'echo' - Default is 1 (int). To return the code instead of echo'ing, set this

 *      to 0 (zero).

 *

 * @author Eric Martin <eric@ericmmartin.com>

 * @copyright Copyright (c) 2009, Eric Martin

 * @version 1.0

 *

 * @param array|string $args Optional. Override default arguments.

 * @return string HTML content, if not displaying.

 */

 

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



/*******************************

 CUSTOM COMMENTS

********************************/



function mytheme_comment($comment, $args, $depth) {

   $GLOBALS['comment'] = $comment; ?>

   <li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">

   	<div class="gravatar">

	 <?php echo get_avatar($comment,$size='40',$default='http://www.gravatar.com/avatar/61a58ec1c1fba116f8424035089b7c71?s=32&d=&r=G' ); ?>

	 <div class="gravatar_mask"></div>

	</div>

     <div id="comment-<?php comment_ID(); ?>">

	  <div class="comment-meta commentmetadata clearfix">

	    <?php printf(__('<strong>%s</strong>'), get_comment_author_link()) ?><?php edit_comment_link(__('(Edit)'),'  ','') ?> <span><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>

	  </span>

	  </div>

	  

      <div class="text">

		  <?php comment_text() ?>

	  </div>

	  

	  <?php if ($comment->comment_approved == '0') : ?>

         <em><?php _e('Your comment is awaiting moderation.') ?></em>

         <br />

      <?php endif; ?>



      <div class="reply">

         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

      </div>

     </div>

<?php }

/******************
ACF options page
*******************/

if(function_exists('acf_add_options_page')) { 

	acf_add_options_page('');
	acf_add_options_sub_page('Collection Statement');
	acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Footer Signup');
	
}

/*********************
INCLUDE NEEDED FILES
*********************/

require_once('includes/gravity-incs.php');



/*******************************

  THEME OPTIONS PAGE

********************************/



add_action('admin_menu', 'simplo_theme_page');

function simplo_theme_page ()

{

	if ( count($_POST) > 0 && isset($_POST['simplo_settings']) )

	{

		$options = array ('style','logo_img', 'logo_alt','contact_email','contact_text','cufon','linkedin_link','twitter_link','facebook_link','delicious_link','flickr_link','keywords','description','analytics','copyright');

		

		foreach ( $options as $opt )

		{

			delete_option ( 'simplo_'.$opt, $_POST[$opt] );

			add_option ( 'simplo_'.$opt, $_POST[$opt] );	

		}			

		 

	}

	add_menu_page(__('Simplo Options'), __('Simplo Options'), 'edit_themes', basename(__FILE__), 'simplo_settings');

	add_submenu_page(__('Simplo Options'), __('Simplo Options'), 'edit_themes', basename(__FILE__), 'simplo_settings');

}

function simplo_settings()

{?>

<div class="wrap">

	<h2>Simplo Options Panel</h2>

	

<form method="post" action="">



	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">

	<legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>General Settings</strong></legend>

	<table class="form-table">

		<!-- General settings -->

		<tr valign="top">

			<th scope="row"><label for="style">Theme Color Scheme</label></th>

			<td>

				<select name="style" id="style">	

					<option value="blue.css" <?php if(get_option('simplo_style') == 'blue.css'){?>selected="selected"<?php }?>>Blue</option>		

					<option value="pink.css" <?php if(get_option('simplo_style') == 'pink.css'){?>selected="selected"<?php }?>>Pink</option>

					<option value="red.css" <?php if(get_option('simplo_style') == 'red.css'){?>selected="selected"<?php }?>>Red</option>

					<option value="green.css" <?php if(get_option('simplo_style') == 'green.css'){?>selected="selected"<?php }?>>Green</option>

					<option value="maroon.css" <?php if(get_option('simplo_style') == 'maroon.css'){?>selected="selected"<?php }?>>Maroon</option>

					<option value="lightgreen.css" <?php if(get_option('simplo_style') == 'lightgreen.css'){?>selected="selected"<?php }?>>Light Green</option>

                   

				</select> 

			</td>

		</tr>

		<tr valign="top">

			<th scope="row"><label for="logo_img">Change logo (full path to logo image)</label></th>

			<td>

				<input name="logo_img" type="text" id="logo_img" value="<?php echo get_option('simplo_logo_img'); ?>" class="regular-text" /><br />

				<em>current logo:</em> <br /> <img src="<?php echo get_option('simplo_logo_img'); ?>" alt="<?php echo get_option('simplo_logo_alt'); ?>" />

			</td>

		</tr>

		<tr valign="top">

			<th scope="row"><label for="logo_alt">Logo ALT Text</label></th>

			<td>

				<input name="logo_alt" type="text" id="logo_alt" value="<?php echo get_option('simplo_logo_alt'); ?>" class="regular-text" />

			</td>

		</tr>

        

		 <tr valign="top">

			<th scope="row"><label for="cufon">Cufon Font Replacement</label></th>

			<td>

				<select name="cufon" id="cufon">

					<option value="yes" <?php if(get_option('simplo_cufon') == 'yes'){?>selected="selected"<?php }?>>Yes</option>		

					<option value="no" <?php if(get_option('simplo_cufon') == 'no'){?>selected="selected"<?php }?>>No</option>

				</select>

			</td>

		</tr>

	</table>

	</fieldset>

	

	<p class="submit">

		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />

		<input type="hidden" name="simplo_settings" value="save" style="display:none;" />

		</p>

	

	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">

	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Social Links</strong></legend>

		<table class="form-table">

		<tr valign="top">

			<th scope="row"><label for="twitter_link">Twitter Link</label></th>

			<td>

				<input name="twitter_link" type="text" id="twitter_user" value="<?php echo get_option('simplo_twitter_link'); ?>" class="regular-text" />

			</td>

		</tr>

        <tr valign="top">

			<th scope="row"><label for="facebook_link">Facebook link</label></th>

			<td>

				<input name="facebook_link" type="text" id="facebook_link" value="<?php echo get_option('simplo_facebook_link'); ?>" class="regular-text" />

			</td>

		</tr>

        <tr valign="top">

			<th scope="row"><label for="linkedin_link">LinkedIn link</label></th>

			<td>

				<input name="linkedin_link" type="text" id="linkedin_link" value="<?php echo get_option('simplo_linkedin_link'); ?>" class="regular-text" />

			</td>

		</tr>

		<tr valign="top">

			<th scope="row"><label for="delicious_link">Delicious link</label></th>

			<td>

				<input name="delicious_link" type="text" id="delicious_link" value="<?php echo get_option('simplo_delicious_link'); ?>" class="regular-text" />

			</td>

		</tr>

        </table>

        </fieldset>

		<p class="submit">

		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />

		<input type="hidden" name="simplo_settings" value="save" style="display:none;" />

		</p>

		

		

	

    <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">

	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Contact Page Settings</strong></legend>

		<table class="form-table">	

        <tr>

        	<td colspan="2"></td>

        </tr>

         <tr valign="top">

			<th scope="row"><label for="contact_text">Contact Page Text</label></th>

			<td>

				<textarea name="contact_text" id="contact_text" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('simplo_contact_text')); ?></textarea>

			</td>

		</tr>

        <tr valign="top">

			<th scope="row"><label for="contact_email">Email Address for Contact Form</label></th>

			<td>

				<input name="contact_email" type="text" id="contact_email" value="<?php echo get_option('simplo_contact_email'); ?>" class="regular-text" />

			</td>

		</tr>

        </table>

     </fieldset>

	 <p class="submit">

		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />

		<input type="hidden" name="simplo_settings" value="save" style="display:none;" />

	</p>

	

	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">

	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Footer</strong></legend>

		<table class="form-table">

		

		<tr>

			<th colspan="2"><strong>Copyright Info</strong></th>

		</tr>

        <tr>

			<th><label for="copyright">Copyright Text</label></th>

			<td>

				<textarea name="copyright" id="copyright" rows="4" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('simplo_copyright')); ?></textarea><br />

				<em>You can use HTML for links etc.</em>

			</td>

		</tr>

		

		

	</table>

	</fieldset>

	<p class="submit">

		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />

		<input type="hidden" name="simplo_settings" value="save" style="display:none;" />

	</p>

        

      <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">

	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>SEO</strong></legend>

		<table class="form-table">

        <tr>

			<th><label for="keywords">Meta Keywords</label></th>

			<td>

				<textarea name="keywords" id="keywords" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('simplo_keywords'); ?></textarea><br />

                <em>Keywords comma separated</em>

			</td>

		</tr>

        <tr>

			<th><label for="description">Meta Description</label></th>

			<td>

				<textarea name="description" id="description" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('simplo_description'); ?></textarea>

			</td>

		</tr>

		<tr>

			<th><label for="ads">Google Analytics code:</label></th>

			<td>

				<textarea name="analytics" id="analytics" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('simplo_analytics')); ?></textarea>

			</td>

		</tr>

		

	</table>

	</fieldset>

	<p class="submit">

		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />

		<input type="hidden" name="simplo_settings" value="save" style="display:none;" />

	</p>

</form>

</div>

<?php }



// THEME STYLE META ICONS

function styleswitch($element) {

	$selection = explode(".css", $element);

	echo $selection[0];

	}



// This is the hook that is triggered after the form submission

// It assumes that form is form with ID = 1, if it isn't change	'gform_post_submission_1' to what ever it is.

add_action("gform_post_submission_2", "send_friend_email", 10, 2);	

function send_friend_email($entry, $form) {

	$emailfrom = $entry["3"];

	$emailsubject = $form["notification"]["subject"];

	$message = $form["notification"]["message"];

	$yourname = $entry["2"];

	

	$message = str_replace("{Your Name:2}", $yourname, $message);

	$message = str_replace("\n", "<br/>", $message);

	

	// iterate through fields

	// The id of the first friend email field, fields must be contiguous.

	$firstIndex = 19;

	$numFields = 5;

	$lastIndex = $firstIndex + $numFields;

	for ($i= $firstIndex; $i < $lastIndex; $i++) {

		$emailto = $entry[strval($i)];		

		if (validateEmailCustom($emailto) == 1) {

			// Get all the stuff and send the email

			sendEmail($emailto, $emailsubject, $message, $emailfrom);

			usleep(500000);	

		}

	}

}









function validateEmailCustom($email){

	 // Create the syntactical validation regular expression

	$regexp = "^([a-z0-9!#$%&'*+/=?^_`{|}~-]+)(\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";



	// Presume that the email is invalid

	$valid = 0;



	// Validate the syntax

	if (eregi($regexp, $email))

	{

		//list($username,$domaintld) = split("@",$email);

		// Validate the domain

		//if (getmxrr($domaintld,$mxrecords)){

			$valid = 1;

		//}

	} else {

		$valid = 0;

	}

	return $valid;

}



function sendEmail ($emailto, $emailsubject, $message, $emailfrom )

{

	$ishtml = 1;	

	if ($ishtml ==1)

	{

		

		$emailheaders = "MIME-Version: 1.0\n"; 

		$emailheaders .= "Content-type: text/html; \n\t	charset=\"iso-8859-1\"\n"; 

		$emailheaders .= "Content-Transfer-Encoding: 7bit\n";



	}

	elseif($ismultipart) // then use multipart alternative

	{

		

		$emailheaders  = "MIME-Version: 1.0\n"; 

		$emailheaders  .= "Content-type: multipart/alternative; \n\t	boundary=\"$boundary\"\n"; 

	}

	

	$emailheaders .= "From: " . $emailfrom ."\n"; 

	$emailheaders .= "Reply-To: ".$emailfrom."\n"; 

	$emailheaders .= "Sender: ".$emailfrom."\n"; 

	$emailheaders .= "Errors-To: " . $emailfrom."\n"; 

	$emailheaders .= "X-Priority: 3\n"; 

	$emailheaders .= "X-MSMail-Priority: Normal\n"; 

	$emailheaders .= "X-Mailer: Web Server"; 

	

	if (mail($emailto, $emailsubject, $message, $emailheaders ))

	{

		return 1;

	}

	else

	{

		return 0;

	}

}




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


// SHORT CODE
	
	add_shortcode( 'member', 'member_check_shortcode' );

function member_check_shortcode( $atts, $content = null ) {
	 if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
}

// Filter Gravity Views edit success message

add_filter( 'gravityview/edit_entry/success', 'gv_edit_entry_success', 10, 4 );
function gv_edit_entry_success(  $entry_updated_message , $view_id, $entry, $back_link ) {
	$message = 'Your directory listing is updated. Continue editing or <a href="'.$back_link .'">return to the page view (Directory Launches January 31st)</a>';
	return $message;
}

// Prepopulate forms

// define the fields we'll be populating
$fields = array('applicant_name', 'postcode');
 
// loop through fields and add the Gravity Forms filters
foreach($fields as $field)
  add_filter('gform_field_value_'.$field, 'my_populate_field');
 
 
// the callback that gets called to populate each field
function my_populate_field($value){
  // we have to wrestle the field name out of the filter name,
  // since GF doesn't pass it to us
  $filter = current_filter();
  if(!$filter) return '';
  $field = str_replace('gform_field_value_', '', $filter);
  if(!$field) return '';
 
  // get the current logged in user object
  $user = wp_get_current_user();
 
  // We'll just return the user_meta value for the key we're given.
  // In most cases, we'd want to do some checks and/or apply some special
  // case logic before returning.
  return get_user_meta($user->ID, $field, true);
}

// allow uploading of xml files for mapping purposes
function iwp_example_allow_xml_uploads($mime_types)
{
    $mime_types['xml'] = 'text/xml';
    $mime_types['json'] = 'application/json';
    $mime_types['csv'] = 'text/csv';

    return $mime_types;
}
add_filter('upload_mimes', 'iwp_example_allow_xml_uploads', 1);

?>
