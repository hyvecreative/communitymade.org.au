<?php
/*
 * @package ActionNetwork
 * @version 1.8.5
 *
 * Plugin Name: Action Network
 * Description: Provides Action Network (actionnetwork.org) action embed codes as shortcodes and a calendar and signup widget
 * Author: Concerted Action
 * Text Domain: wp-action-network
 * Domain Path: /languages
 * Version: 1.8.5
 * License: GPLv3
 * Author URI: http://concertedaction.consulting
 *
 * phpcs:disable WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- Using spread operator with dynamic IN clauses
 * phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Dynamic IN clause placeholders are pre-built with correct format
 */

/**
 * Plugin version constant
 */
define( 'ACTIONNETWORK_VERSION', '1.8.5' );

/**
 * Includes
 */

if (!class_exists('ActionNetwork')) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/actionnetwork.class.php' );
}
if (!class_exists('ActionNetwork_Sync')) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/actionnetwork-sync.class.php' );
}

/**
 * Set up options
 */
add_option( 'actionnetwork_api_key', null );

/**
 * Installation, database setup
 */
global $actionnetwork_version;
$actionnetwork_version = '1.5.0';
global $actionnetwork_db_version;
$actionnetwork_db_version = '1.0.8';

function actionnetwork_install() {

	global $wpdb;
	global $actionnetwork_version;
	global $actionnetwork_db_version;
	global $actionnetwork_update_sync;
	$installed_version = get_option( 'actionnetwork_version' );
	$installed_db_version = get_option( 'actionnetwork_db_version' );

	$notices = get_option('actionnetwork_deferred_admin_notices', array());

	if ($installed_version != $actionnetwork_version) {

		// test for particular updates here
		if ($actionnetwork_version == '1.4.3') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.4.4.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}


		// test for particular updates here
		if ($actionnetwork_version == '1.4.2') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.4.3.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}

				// test for particular updates here
		if ($actionnetwork_version == '1.4.1') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.4.2. This update is a quick bug fix to support Action Network URLs up to version 4.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}

				// test for particular updates here
		if ($actionnetwork_version == '1.4.1') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.4.1. This update fixes a bug with widget hCaptcha protection when hCaptcha keys are not provided. The hCaptcha verification will require both hCaptcha keys in the plugin settings and the "Spam protection" checkbox be enabled. If either are not provided, hCaptcha protection will be disabled, allowing the form to be submitted without verification.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}

				// test for particular updates here
		if ($actionnetwork_version == '1.2.1') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.2.1. This update provides a Gutenberg Editor button as well as a bug fix related to hCaptcha.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}

		if ($actionnetwork_version == '1.2') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.2. This major update includes the following updates: - hCaptcha ability added for API based forms. - Bug fixes related too multiple embeds on a single page, and the API sync. - shortcode button for tinymce WYSIWYG. - additional documentation on setting page. Backing up site before upgrading is recommended.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}


				// test for particular updates here
		if ($actionnetwork_version == '1.1.3') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.1.3. This update confirms WordPress compatibility and plugin maintainers', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}

		// test for particular updates here
		if ($actionnetwork_version == '1.1.2') {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('The %s has been updated to version 1.1.2. This update fixes a problem where Action Network dates (both for events and modified_date for all actions), which are in local time, were being compared to UTC time. Now they are compared to the local timezone of the website.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				);
		}
        
		if ( ($actionnetwork_version == '1.1.0') || ($actionnetwork_version == '1.1.1') ) {
			$notices[] = sprintf(
				/* translators: %s is a link to https://wordpress.org/plugins/wp-action-network/ */
				__('Welcome to version 1.1 of the %s. This version is chock full of new features, including new widgets, shortcodes, and shortcode options, as well as ajax submission of the signup form.', 'wp-action-network'),
				'<a href="https://wordpress.org/plugins/wp-action-network/">Action Network plugin</a>'
				) . ' <a href="https://jonathankissam.wordpress.com/2017/12/27/new-version-of-my-action-network-plugin/" target="_blank">' . __('Read more','wp-action-network') . ' &raquo;</a>';
		}

		// on first installation
		if (!$installed_version) {
			$notices[] = sprintf(
				/* translators: %s is link to text "settings page" */
				__('Thank for you installing the Action Network plugin. If you are an Action Network partner and have an API key, please visit the plugin %s and enter your API key.', 'wp-action-network'),
				'<a href="admin.php?page=wp-action-network&actionnetwork_tab=settings">' . __('settings page','wp-action-network') . '</a>'
			);
		}

		update_option( 'actionnetwork_version', $actionnetwork_version );
	}

	if ($installed_db_version != $actionnetwork_db_version) {
		
		// test for particular updates
		if ( $installed_db_version && ($actionnetwork_db_version == '1.0.8') ) {
			// 1.0.8: fix table name (was incorrectly set to wp-action-network in 1.8.2/1.8.3)
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.SchemaChange
			$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wp-action-network");
		}

		if ( $installed_db_version && version_compare($installed_db_version, '1.0.7', '<') ) {
			$notices[] = __('Database updated to add description and location fields to actionnetwork table, and remove end_date', 'wp-action-network');
			// force updating all actions in the database
			update_option('actionnetwork_cache_timestamp', 0 );
		}
		
		// test for particular updates
		if ( $installed_db_version && ($actionnetwork_db_version == '1.0.6') ) {
			$notices[] = __('Database updated to add "end_date" field to actionnetwork table', 'wp-action-network');
		}
		
		if ( $installed_db_version && ($actionnetwork_db_version == '1.0.5') ) {
			$notices[] = __('Database updated to add "hidden" field to actionnetwork table', 'wp-action-network');
		}
		
		if ( $installed_db_version && ($actionnetwork_db_version == '1.0.4') ) {
			$notices[] = __('Database updated to add table actionnetwork_queue', 'wp-action-network');
		}

		$table_name = $wpdb->prefix . 'actionnetwork';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			wp_id mediumint(9) NOT NULL AUTO_INCREMENT,
			an_id varchar(64) DEFAULT '' NOT NULL,
			type varchar(24) DEFAULT '' NOT NULL, 
			name varchar(255) DEFAULT '' NOT NULL,
			title varchar (255) DEFAULT '' NOT NULL,
			created_date bigint DEFAULT NULL,
			modified_date bigint DEFAULT NULL,
			start_date bigint DEFAULT NULL,
			browser_url varchar(255) DEFAULT '' NOT NULL,
			embed_standard_default_styles text NOT NULL,
			embed_standard_layout_only_styles text NOT NULL,
			embed_standard_no_styles text NOT NULL,
			embed_full_default_styles text NOT NULL,
			embed_full_layout_only_styles text NOT NULL,
			embed_full_no_styles text NOT NULL,
			description text NOT NULL,
			location text NOT NULL,
			enabled tinyint(1) DEFAULT 0 NOT NULL,
			hidden tinyint(1) DEFAULT 0 NOT NULL,
			PRIMARY KEY  (wp_id)
		) $charset_collate;";
		
		$table_name_queue = $wpdb->prefix . 'actionnetwork_queue';
		$sql_queue = "CREATE TABLE $table_name_queue (
			resource_id bigint(2) NOT NULL AUTO_INCREMENT,
			resource text NOT NULL,
			endpoint varchar(255) DEFAULT '' NOT NULL,
			processed tinyint(1) DEFAULT 0 NOT NULL,
			PRIMARY KEY  (resource_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		dbDelta( $sql );
		dbDelta( $sql_queue );

		update_option( 'actionnetwork_db_version', $actionnetwork_db_version );

	}
	
	if ( !wp_next_scheduled( 'actionnetwork_cron_daily' ) ) {
		wp_schedule_event( time(), 'daily', 'actionnetwork_cron_daily' );
	}

	update_option('actionnetwork_deferred_admin_notices', $notices);

}
register_activation_hook( __FILE__, 'actionnetwork_install' );

function actionnetwork_update_version_check() {
	global $actionnetwork_version;
	global $actionnetwork_db_version;
	$installed_version = get_option( 'actionnetwork_version' );
	$installed_db_version = get_option( 'actionnetwork_db_version' );
	if ( ($installed_version != $actionnetwork_version) || ($installed_db_version != $actionnetwork_db_version) ) {
		actionnetwork_install();
	}
}
add_action( 'plugins_loaded', 'actionnetwork_update_version_check' );

/**
 * Uninstall
 */
function actionnetwork_uninstall() {

	global $wpdb;

	// remove options
	$actionnetwork_options = array(
		'actionnetwork_version',
		'actionnetwork_db_version',
		'actionnetwork_deferred_admin_notices',
		'actionnetwork_api_key',
		'actionnetwork_cache_timestamp',
		'actionnetwork_queue_status',
		'actionnetwork_cron_token',
		'actionnetwork_ajax_token',
		'actionnetwork_show_sync_notice',
		'actionnetwork_last_sync_inserted',
		'actionnetwork_last_sync_updated',
		'actionnetwork_last_sync_deleted',
		'actionnetwork_hcaptcha_site_key',
		'actionnetwork_hcaptcha_secret_key',
	);
	foreach ($actionnetwork_options as $option) {
		delete_option( $option );
	}

	// remove database tables
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}actionnetwork");
	
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}actionnetwork_queue");

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}actionnetwork_cron_log");

}
register_uninstall_hook( __FILE__, 'actionnetwork_uninstall' );

/**
 * Administrative notices
 */
function actionnetwork_admin_notices() {
	if ($notices = get_option( 'actionnetwork_deferred_admin_notices' ) ) {
		foreach ($notices as $key => $notice) {
			// Determine notice type based on key prefix or default to success
			$is_error = ( strpos( $key, 'error_' ) === 0 || in_array( $key, array( 'sync_in_progress' ), true ) );
			$class = $is_error ? 'error' : 'updated';
			echo '<div class="' . esc_attr( $class ) . ' notice is-dismissible"><p>' . wp_kses_post( $notice ) . '</p></div>';
		}
		delete_option( 'actionnetwork_deferred_admin_notices' );
	}
}
add_action( 'admin_notices', 'actionnetwork_admin_notices' );



/**
 * Widgets
 */
if (!class_exists('ActionNetwork_Action_Widget')) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/actionnetwork-widgets.class.php' );
}
add_action( 'widgets_init', function(){
	register_widget( 'ActionNetwork_Action_Widget' );
	register_widget( 'ActionNetwork_List_Widget' );
	register_widget( 'ActionNetwork_Calendar_Widget' );
	register_widget( 'ActionNetwork_Signup_Widget' );
});



/**
 * Shortcode for embeds
 * Since the way Action Network's embed codes work
 * does not support multiple embeds on a single page,
 * only allow the first shortcode on a given page load
 */
global $actionnetwork_shortcode_count;
$actionnetwork_shortcode_count = 0;

function actionnetwork_shortcode( $atts ) {
	global $wpdb;
	global $actionnetwork_shortcode_count;

	// only embed a single shortcode on any given page
	if ($actionnetwork_shortcode_count) { return; }

	$id = isset($atts['id']) ? (int) $atts['id'] : null;
	$size = isset($atts['size']) ? $atts['size'] : 'standard';
	$style = isset($atts['style']) ? $atts['style'] : 'layout_only';
	$thank_you = isset($atts['thank_you']) ? $atts['thank_you'] : '';
	$help_us = isset($atts['help_us']) ? $atts['help_us'] : '';
	$hide_social = isset($atts['hide_social']) ? $atts['hide_social'] : null;
	$hide_email = isset($atts['hide_email']) ? $atts['hide_email'] : null;
	$hide_embed = isset($atts['hide_embed']) ? $atts['hide_embed'] : null;

	if (!$id) { return; }

	// validate size and style
	if (!in_array($size, array('standard', 'full'))) { $size = 'standard'; }
	if (!in_array($style, array('default', 'layout_only', 'no'))) { $style = 'layout_only'; }
	
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
	$action = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}actionnetwork WHERE wp_id=%d", $id), ARRAY_A );

	$embed_style = 'embed_'.$size.'_'.$style.'_styles';
	
	$output = actionnetwork_get_embed_code( $action, $embed_style );
	
	if ($output) {
		$actionnetwork_shortcode_count++;
		
		if ($thank_you || $help_us || $hide_social || $hide_email || $hide_embed) {
			
			preg_match("/id='([-a-z]+)'/", $output, $matches);
			$div_id = is_array($matches) && isset($matches[1]) ? $matches[1] : false;
			
			if ($div_id) {
			
				wp_register_script( 'actionnetwork-customize-action-js', plugins_url('customize-action.js', __FILE__), array( 'jquery' ), ACTIONNETWORK_VERSION, true );
				$options = array(
					'thank_you' => $thank_you,
					'help_us' => $help_us,
				);
				if ( $hide_social ) { $options['hide_social'] = true; }
				if ( $hide_email ) { $options['hide_email'] = true; }
				if ( $hide_embed ) { $options['hide_embed'] = true; }
				$actionnetwork_customizations = array(
					$div_id => $options
				);
				wp_localize_script( 'actionnetwork-customize-action-js', 'actionNetworkCustomizations', $actionnetwork_customizations );
				wp_enqueue_script( 'actionnetwork-customize-action-js' );
			
			}
		}
		
		return $output;
	}

}
add_shortcode( 'actionnetwork', 'actionnetwork_shortcode' );
// Backward compatibility: also register as wp-action-network
add_shortcode( 'wp-action-network', 'actionnetwork_shortcode' );

/**
 * Shortcode for action list
 */
function actionnetwork_list_shortcode ( $atts, $content = null ) {
	global $wpdb, $wp;
	
	$n = isset($atts['n']) ? (int) $atts['n'] : 5;
	$action_types = isset($atts['action_types']) ? sanitize_text_field($atts['action_types']) : 'petition,advocacy_campaign,fundraising_page,form';
	$link_format = isset($atts['link_format']) ? sanitize_text_field($atts['link_format']) : '{{ action.link }}';
	$link_text = isset($atts['link_text']) ? $atts['link_text'] : '{{ action.title }}';
	$container_element = isset($atts['container_element']) ? sanitize_key($atts['container_element']) : 'ul';
	$container_class = isset($atts['container_class']) ? sanitize_html_class($atts['container_class']) : 'actionnetwork-list';
	$item_element = isset($atts['item_element']) ? sanitize_key($atts['item_element']) : 'li';
	$item_class = isset($atts['item_class']) ? sanitize_html_class($atts['item_class']) : 'actionnetwork-list-item';
	$no_actions = isset($atts['no_actions']) ? $atts['no_actions'] : __( 'No current actions', 'wp-action-network' );
	$no_actions_hide = isset($atts['no_actions_hide']) ? $atts['no_actions_hide'] : false;
	
	// template
	$add_wpautop = false;
	if (trim($content)) {
		$content = preg_replace('#</?p>|<br ?/?>#','',$content);
		$add_wpautop = true;
	} else {
		$content = '<' . esc_attr($container_element) . ' class="' . esc_attr($container_class) . '">' . "\n";
		$content .= '{% for action in actions %}' . "\n";
		$content .= '  <' . esc_attr($item_element) . ' class="' . esc_attr($item_class) . '">' . "\n";
		$content .= '    <a href="{{ action.link }}">' . esc_html($link_text) . '</a>' . "\n";
		$content .= '  </' . esc_attr($item_element) . '>' . "\n";
		$content .= '{% else %}' . "\n";
		$content .= '  <' . esc_attr($item_element) . ' class="' . esc_attr($item_class) . '">' . esc_html($no_actions) . '</' . esc_attr($item_element) . '>' . "\n";
		$content .= '{% endfor %}' . "\n";
		$content .= '</' . esc_attr($container_element) . '>';
	}
	
	// parse template into $pre, $row, $else and $post
	list ($pre,$content) = explode('{% for action in actions %}', $content);
	list ($row,$content) = explode('{% else %}', $content);
	list ($no_actions,$post) = explode('{% endfor %}', $content);
	
	// load events
	$action_types = preg_replace('/[^a-z_,]/', '', $action_types);
	$action_types_array = array_filter( array_map( 'sanitize_key', explode(',', $action_types ) ) );
	$allowed_action_types = array(
		'petition',
		'advocacy_campaign',
		'fundraising_page',
		'form',
		'event',
		'ticketed_event',
		'letter',
		'phone',
		'survey',
	);
	$action_types_array = array_values( array_intersect( $action_types_array, $allowed_action_types ) );
	$actions = array();

	if ( $action_types_array ) {
		$placeholders = implode( ', ', array_fill( 0, count( $action_types_array ), '%s' ) );
		$params = array_merge( $action_types_array, array( 1, 0 ) );

		if ( $n ) {
			$limit = absint( $n );
			if ( $limit > 0 ) {
				$params[] = $limit;
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber,WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Dynamic IN clause with whitelisted types, spread operator used for variable parameter count
				$actions = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * FROM {$wpdb->prefix}actionnetwork WHERE type IN ($placeholders) AND enabled = %d AND hidden = %d ORDER BY created_date DESC LIMIT %d",
						...$params
					),
					ARRAY_A
				);
			}
		} else {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber,WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Dynamic IN clause with whitelisted types, spread operator used for variable parameter count
			$actions = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}actionnetwork WHERE type IN ($placeholders) AND enabled = %d AND hidden = %d ORDER BY created_date DESC",
					...$params
				),
				ARRAY_A
			);
		}
	}
	
	// if json="1" attribute is set, render as JSON object
	if (isset($atts['json']) && $atts['json']) {
		foreach($actions as $index => $action) {
			$action['link']= isset($action['browser_url']) ? $action['browser_url'] : site_url();
			$action['id'] = isset($action['wp_id']) ? $action['wp_id'] : 0;
			$action['link'] = $link_format ? actionnetwork_twig_render( $link_format, $action, 'action') : $action['link'];
			$actions[$index] = $action;
		}
		$json = wp_json_encode($actions);
		$output = '<script type="text/javascript">';
		$output .= "\n";
		$output .= 'actionNetworkActions = '.$json;
		$output .= ";\n";
		$output .= '</script>';
		return $output;
	}
	
	$output = $pre;
	if (count($actions)) {
		foreach ($actions as $action) {
			$action_data['id'] = isset($action['wp_id']) ? $action['wp_id'] : 0;
			$action_data['title'] = isset($action['title']) ? $action['title'] : '(Action Title)';
			$action_data['link'] = isset($action['browser_url']) ? $action['browser_url'] : site_url();
			$action_data['link'] = $link_format ? actionnetwork_twig_render( $link_format, $action_data, 'action') : $action_data['link'];
			$output .= actionnetwork_twig_render( $row, $action_data, 'action' );
		}
	} else {
		if ( $no_actions_hide ) { return ''; }
		$output .= $no_actions;
	}
	$output .= $post;
	
	// $output .= '<pre>' . print_r($wp,1) . '</pre>';
	
	if ($add_wpautop) { $output = wpautop($output); }
	
	return $output;
	
}
add_shortcode( 'actionnetwork_list', 'actionnetwork_list_shortcode' );

/**
 * Shortcode for calendar
 */
function actionnetwork_calendar_shortcode ( $atts, $content = null ) {
	global $wpdb, $wp;
	
	$n = isset($atts['n']) ? (int) $atts['n'] : 0;
	// $page = isset($atts['page']) ? (int) $atts['page'] : 10;
	$date_format = isset($atts['date_format']) ? sanitize_text_field($atts['date_format']) : 'F j, Y';
	$link_format = isset($atts['link_format']) ? sanitize_text_field($atts['link_format']) : '{{ event.link }}';
	$link_text = isset($atts['link_text']) ? $atts['link_text'] : '{{ event.date }}: {{ event.title }}';
	$container_element = isset($atts['container_element']) ? sanitize_key($atts['container_element']) : 'ul';
	$container_class = isset($atts['container_class']) ? sanitize_html_class($atts['container_class']) : 'actionnetwork-calendar';
	$item_element = isset($atts['item_element']) ? sanitize_key($atts['item_element']) : 'li';
	$item_class = isset($atts['item_class']) ? sanitize_html_class($atts['item_class']) : 'actionnetwork-calendar-item';
	$no_events = isset($atts['no_events']) ? $atts['no_events'] : __( 'No upcoming events', 'wp-action-network' );
	$location = (isset($atts['location']) && $atts['location']) ? '<div class="actionnetwork-calendar-location">{{ event.location }}</div>' : '';
	$description = (isset($atts['description']) && $atts['description']) ? '<div class="actionnetwork-calendar-description">{{ event.description }}</div>' : '';
	
	$embed_style = isset($atts['embed_style']) ? 'embed_'.sanitize_text_field($atts['embed_style']).'_styles' : 'embed_standard_layout_only_styles';
	
	/*
	$embed_fields = array(
		'embed_standard_layout_only_styles',
		'embed_full_layout_only_styles',
		'embed_standard_no_styles',
		'embed_full_no_styles',
		'embed_standard_default_styles',
		'embed_full_default_styles',
	);
	
	// validate embed_style
	if (!in_array( $embed_style, $embed_fields )) { $embed_style = 'embed_standard_layout_only_styles'; }
	*/
	
	// check if we have an id that matches an existing event
	$event_id = ( isset($wp->query_vars['page']) && (!isset($atts['ignore_url_id']) || !$atts['ignore_url_id']) ) ? (int) $wp->query_vars['page'] : 0;
	if ($event_id) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$event = $wpdb->get_row( 
			$wpdb->prepare("SELECT * FROM {$wpdb->prefix}actionnetwork WHERE type IN ('event','ticketed_event') AND wp_id=%d AND enabled=1 AND hidden=0 AND start_date > %d", [$event_id, (int)current_time('timestamp')]), 
			ARRAY_A 
		);
		if (count($event)) {
			return actionnetwork_get_embed_code( $event, $embed_style );
		}
	}
	
	// template
	if (trim($content)) {
		$content = preg_replace('#</?p>|<br ?/?>#','',$content);
	} else {
		$content = '<' . esc_attr($container_element) . ' class="' . esc_attr($container_class) . '">' . "\n";
		$content .= '{% for event in events %}' . "\n";
		$content .= '  <' . esc_attr($item_element) . ' class="' . esc_attr($item_class) . '">' . "\n";
		$content .= '    <a href="{{ event.link }}">' . esc_html($link_text) . '</a>' . "\n";
		$content .= '  	' . $location . "\n";
		$content .= '  	' . $description . "\n";
		$content .= '  </' . esc_attr($item_element) . '>' . "\n";
		$content .= '{% else %}' . "\n";
		$content .= '  <' . esc_attr($item_element) . ' class="' . esc_attr($item_class) . '">' . esc_html($no_events) . '</' . esc_attr($item_element) . '>' . "\n";
		$content .= '{% endfor %}' . "\n";
		$content .= '</' . esc_attr($container_element) . '>';
	}
	
	// parse template into $pre, $row, $else and $post
	list ($pre,$content) = explode('{% for event in events %}', $content);
	list ($row,$content) = explode('{% else %}', $content);
	list ($no_events,$post) = explode('{% endfor %}', $content);
	
	// load events
	$start_date = (int) current_time('timestamp');
	$sql = $wpdb->prepare(
		"SELECT * FROM {$wpdb->prefix}actionnetwork WHERE type IN ('event','ticketed_event') AND enabled=1 AND hidden=0 AND start_date > %d ORDER BY start_date ASC",
		$start_date
	);
	if ($n) { 
		$n = absint($n);
		$sql .= " LIMIT 0,$n"; 
	}
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.NotPrepared -- LIMIT clause added after prepare
	$events = $wpdb->get_results( $sql, ARRAY_A );
	
	// if json="1" attribute is set, render as JSON object
	if (isset($atts['json']) && $atts['json']) {
		foreach($events as $index => $event) {
			$event['date'] = isset($event['start_date']) ? date_i18n($date_format, $event['start_date']) : '(No Date)';
			$event['link']= isset($event['browser_url']) ? $event['browser_url'] : site_url();
			$event['id'] = isset($event['wp_id']) ? $event['wp_id'] : 0;
			$location_json = isset($event['location']) ? unserialize( $event['location'] ) : new stdClass();
			$event['location'] = isset($event['location']) ? actionnetwork_render_location( $event['location'] ) : '';
			$event['link'] = $link_format ? actionnetwork_twig_render( $link_format, $event, 'event') : $event['link'];
			$event['location_json'] = $location_json;
			$events[$index] = $event;
		}
		$json = wp_json_encode($events);
		$output = '<script type="text/javascript">';
		$output .= "\n";
		$output .= 'actionNetworkEvents = '.$json;
		$output .= ";\n";
		$output .= '</script>';
		return $output;
	}
	
	$output = $pre;
	if (count($events)) {
		foreach ($events as $event) {
			$event_data['id'] = isset($event['wp_id']) ? $event['wp_id'] : 0;
			$event_data['title'] = isset($event['title']) ? $event['title'] : '(Event Title)';
			$event_data['date'] = isset($event['start_date']) ? date_i18n($date_format, $event['start_date']) : '(Date)';
			$event_data['link'] = isset($event['browser_url']) ? $event['browser_url'] : site_url();
			$event_data['link'] = $link_format ? actionnetwork_twig_render( $link_format, $event_data, 'event') : $event_data['link'];
			$event_data['location'] = isset($event['location']) ? actionnetwork_render_location($event['location']) : '';
			$event_data['description'] = isset($event['description']) ? $event['description'] : '';
			$output .= actionnetwork_twig_render( $row, $event_data, 'event' );
		}
	} else {
		$output .= $no_events;
	}
	$output .= $post;
	
	// $output .= '<pre>' . print_r($wp,1) . '</pre>';
	
	return $output;
	
}
add_shortcode( 'actionnetwork_calendar', 'actionnetwork_calendar_shortcode' );

/**
 * Helper function for calendar shortcode
 * Renders a very simplistic version of twig (http://twig.sensiolabs.org/)
 */
function actionnetwork_twig_render( $twig, $event, $object ) {
	$output = $twig;
	foreach ($event as $k => $v) {
		$output = str_replace('{{ '.$object.'.'.$k.' }}', $v, $output);
	}
	return $output;
}

/**
 * Helper function to render a location hash
 */
function actionnetwork_render_location( $location_hash ) {
	$location = unserialize( $location_hash );
	if ( isset( $location->html ) && $location->html ) { return wpautop( $location->html ); }
	$location_string = '';
	$location_string .= ( isset( $location->venue ) && $location->venue ) ? $location->venue . "\n" : '';
	$location_string .= ( isset( $location->address_lines ) && is_array( $location->address_lines ) && count ( $location->address_lines ) ) ? $location->address_lines[0] . "\n" : '';
	$location_string .= ( isset( $location->locality ) && $location->locality ) ? $location->locality . ', ' : '';
	$location_string .= isset( $location->region ) ? $location->region . ' ' : '';
	$location_string .= isset( $location->postal_code ) ? $location->postal_code : '';
	return wpautop( $location_string );
}

/**
 * Helper function to get embed code by style
 */
function actionnetwork_get_embed_code( $action, $embed_style = '', $autop = true ) {
	$embed_fields = array(
		'embed_standard_layout_only_styles',
		'embed_full_layout_only_styles',
		'embed_standard_no_styles',
		'embed_full_no_styles',
		'embed_standard_default_styles',
		'embed_full_default_styles',
	);
	
	$output = null;
	
	// validate embed_style
	if (!in_array( $embed_style, $embed_fields )) { $embed_style = 'embed_standard_layout_only_styles'; }

	if (isset($action[$embed_style]) && $action[$embed_style]) {
		$output = $action[$embed_style];
	} else {
		foreach( $embed_fields as $embed_field_name) {
			if (isset($action[$embed_field_name]) && $action[$embed_field_name]) {
				$output = $action[$embed_field_name];
			}
		}
	}
	
	if ($output && (strpos($output, '<script') === FALSE) && $autop) {
		$output = wpautop($output);
	}
	
	// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet,WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Outputting Action Network embed code HTML which contains third-party link/script tags
	return $output;
}

/**
 * Set up admin menu structure
 * https://developer.wordpress.org/reference/functions/add_menu_page/
 */
function actionnetwork_admin_menu() {
	$actionnetwork_admin_menu_hook = add_menu_page( __('Administer Action Network', 'wp-action-network'), 'Action Network', 'manage_options', 'wp-action-network', 'actionnetwork_admin_page', plugins_url('icon-action-network.png', __FILE__), 21);
	add_action( 'load-' . $actionnetwork_admin_menu_hook, 'actionnetwork_admin_add_help' );
	/*
	// customize the first sub-menu link
	$actionnetwork_admin_menu_hook = add_submenu_page( __('Administer Action Network', 'wp-action-network'), __('Administer', 'wp-action-network'), 'manage_options', 'actionnetwork-menu', 'actionnetwork_admin_page');
	add_action( 'load-' . $actionnetwork_admin_menu_hook, 'actionnetwork_admin_add_help' );
	*/
}
add_action( 'admin_menu', 'actionnetwork_admin_menu' );

/**
 * Handle form submissions early (before headers are sent)
 */
function actionnetwork_handle_form_submission() {
	// Only process on our admin page
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Checking page parameter before nonce verification
	if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'wp-action-network' ) {
		return;
	}

	// Only process if we have an admin action
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Checking for action parameter before nonce verification
	if ( ! isset( $_REQUEST['actionnetwork_admin_action'] ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verified inside actionnetwork_admin_handle_actions
	$admin_action = sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_admin_action'] ) );

	// Only handle update_sync action here (needs redirect)
	if ( $admin_action === 'update_sync' ) {
		if ( ! check_admin_referer( 'actionnetwork_update_sync', 'actionnetwork_nonce_field' ) ) {
			wp_die( esc_html__( 'Security check failed', 'wp-action-network' ) );
		}

		$queue_status = get_option( 'actionnetwork_queue_status', 'empty' );
		if ( $queue_status !== 'empty' ) {
			// Store error message for display after redirect
			$notices = get_option( 'actionnetwork_deferred_admin_notices', array() );
			$notices['sync_in_progress'] = __( 'Sync currently in progress', 'wp-action-network' );
			update_option( 'actionnetwork_deferred_admin_notices', $notices );
		} else {
			// Directly initialize the sync queue without HTTP loopback.
			// The original wp_remote_post() to admin-ajax.php is blocked (403) on
			// some server/WAF configurations (e.g. OpenLiteSpeed + ModSecurity).
			// Instead: run init() here to populate the queue, then let the JS
			// polling calls to actionnetwork_get_queue_status() drive processing.
			@set_time_limit( 300 );
			$sync = new Actionnetwork_Sync();
			$sync->init();
			update_option( 'actionnetwork_queue_status', 'processing' );

			// Set a flag to show sync started notice
			update_option( 'actionnetwork_show_sync_notice', true );
		}

		// Redirect to avoid form resubmission
		wp_safe_redirect( admin_url( 'admin.php?page=wp-action-network' ) );
		exit;
	}
}
add_action( 'admin_init', 'actionnetwork_handle_form_submission' );


function actionnetwork_create_sync_log(){
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'actionnetwork_cron_log';
	$sql = "CREATE TABLE $table_name (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  inserted text NOT NULL,
	  updated text NOT NULL,
	  new_only text NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	// $wpdb->insert( 
	// 	$table_name, 
	// 	array( 
	// 		'time' => current_time( 'mysql' )
	// 	) 
	// );
}

function actionnetwork_update_cron_log($inserted,$updated,$new_only){
	global $wpdb;
	$table_name = $wpdb->prefix . 'actionnetwork_cron_log';
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
	$wpdb->insert( 
		$table_name, 
		array( 
			'time' => current_time( 'mysql' ),
			'inserted'=>$inserted,
			'updated'=>$updated,
			'new_only'=>$new_only
		) 
	);
}


/**
 * Update sync daily via cron
 */
function actionnetwork_cron_sync() {

	actionnetwork_create_sync_log();

	// Directly run the full sync without HTTP loopback.
	// The original wp_remote_post() to admin-ajax.php is blocked (403) on
	// some server/WAF configurations (e.g. OpenLiteSpeed + ModSecurity).
	@set_time_limit( 300 );
	$sync = new Actionnetwork_Sync();
	$sync->init();
	update_option( 'actionnetwork_queue_status', 'processing' );

	while ( true ) {
		$status = $sync->getQueueStatus();
		if ( $status['status'] === 'complete' ) {
			$sync->cleanUp();
			break;
		}
		if ( $status['status'] === 'empty' ) {
			break;
		}
		$sync->processResource();
	}

	actionnetwork_update_cron_log( $sync->inserted, $sync->updated, 0 );

}
add_action( 'actionnetwork_cron_daily', 'actionnetwork_cron_sync' );

function actionnetwork_get_queue_status(){
	try {
		check_ajax_referer( 'actionnetwork_get_queue_status', 'actionnetwork_ajax_nonce' );
		$sync = new Actionnetwork_Sync();

		// Process the entire queue to completion on the first poll call that finds it.
		// Since the loopback HTTP approach is removed, the JS polling now drives
		// the sync work. Processing everything in one call avoids a race condition
		// where setInterval fires overlapping poll requests that compete for the
		// same unprocessed queue items.
		if ( get_option( 'actionnetwork_queue_status', 'empty' ) === 'processing' ) {
			@set_time_limit( 300 );
			while ( true ) {
				$batch_status = $sync->getQueueStatus();
				if ( $batch_status['status'] === 'complete' ) {
					$sync->cleanUp();
					break;
				}
				if ( $batch_status['status'] === 'empty' ) {
					break;
				}
				$sync->processResource();
			}
		}

		$status = $sync->getQueueStatus();
		$status['text'] = 'API Sync queue is '.$status['status'].'.';
		if ($status['status'] == 'processing') {
			$status['text'] .= ' ' . sprintf('%d of %d items processed.', $status['processed'], $status['total']);
		}
		
		// Add debugging information
		$status['debug'] = array(
			'timestamp' => current_time('mysql'),
			'queue_status_option' => get_option( 'actionnetwork_queue_status', 'not_set' ),
			'api_key_set' => !empty( get_option( 'actionnetwork_api_key', '' ) ),
		);
		
		// if status is "complete" or "empty," check if an admin notice has been set;
		// if it has, return the admin notice as status.text & clear in options
		if ( ($status['status'] == 'complete') || ($status['status'] == 'empty') ) {
			$notices = get_option('actionnetwork_deferred_admin_notices', array());
			if (isset($notices['api_sync_completed'])) {
				$status['text'] = $notices['api_sync_completed'];
				$status['status'] = 'complete';
				// unset($notices['api_sync_completed']);
				// update_option('actionnetwork_deferred_admin_notices', $notices);
			}
		}
		
		wp_send_json($status);
	} catch (Exception $e) {
		// Log error for debugging
		if (defined('WP_DEBUG') && WP_DEBUG) {
			error_log('Action Network sync status error: ' . $e->getMessage());
		}
		wp_send_json(array(
			'status' => 'error',
			'text' => 'Error checking sync status',
			'error' => array(
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
			),
			'debug' => array(
				'timestamp' => current_time('mysql'),
			)
		));
	} catch (Error $e) {
		// Log fatal errors
		if (defined('WP_DEBUG') && WP_DEBUG) {
			error_log('Action Network sync status fatal error: ' . $e->getMessage());
		}
		wp_send_json(array(
			'status' => 'error',
			'text' => 'Fatal error checking sync status',
			'error' => array(
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
			),
			'debug' => array(
				'timestamp' => current_time('mysql'),
			)
		));
	}
	wp_die();
}
add_action( 'wp_ajax_actionnetwork_get_queue_status', 'actionnetwork_get_queue_status' );

/**
 * Helper function to handle administrative actions
 */
function actionnetwork_admin_handle_actions(){

	global $wpdb;
	$return = array();
	
	// Check if we have an admin action
	if ( !isset($_REQUEST['actionnetwork_admin_action']) ) {
		return false;
	}
	
	$admin_action = sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_admin_action'] ) );
	
	// Verify nonce - the nonce action name is 'actionnetwork_' + the admin action name
	if ( !check_admin_referer( 'actionnetwork_' . $admin_action, 'actionnetwork_nonce_field' ) ) {
		// If nonce check fails, it might be because the page parameter is wrong
		// Try to be more lenient with the referer check for add_embed action
		if ( $admin_action === 'add_embed' ) {
			// For add_embed, check nonce without strict referer validation
			$nonce = isset( $_REQUEST['actionnetwork_nonce_field'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_nonce_field'] ) ) : '';
			if ( !wp_verify_nonce( $nonce, 'actionnetwork_add_embed' ) ) {
				wp_die( esc_html__( 'Security check failed. Please try again.', 'wp-action-network' ) );
			}
		} else {
			return false;
		}
	}
	
	switch ($admin_action) {

		case 'update_spam_keys':
			$hcaptcha_site_key = isset( $_REQUEST['actionnetwork_hcaptcha_site_key'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_hcaptcha_site_key'] ) ) : '';
			$hcaptcha_secret_key = isset( $_REQUEST['actionnetwork_hcaptcha_secret_key'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_hcaptcha_secret_key'] ) ) : '';
			update_option('actionnetwork_hcaptcha_site_key', $hcaptcha_site_key);
			update_option('actionnetwork_hcaptcha_secret_key', $hcaptcha_secret_key);
		break;
	
		case 'update_api_key':
		
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
		// $debug = "update_api_key case matched\n";
		
		$actionnetwork_api_key = isset( $_REQUEST['actionnetwork_api_key'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_api_key'] ) ) : '';
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
		// $debug .= "actionnetwork_api_key: $actionnetwork_api_key\n";
		
		$queue_status = get_option( 'actionnetwork_queue_status', 'empty' );
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
		// $debug .= "queue_status: $queue_status\n";
		
		if (get_option('actionnetwork_api_key', null) !== $actionnetwork_api_key) {
			
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
			// $debug .= "get_option did not match actionnetwork_api_key\n";
			
            // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
            // echo "---\n";
			// don't allow API Key to be changed if a sync queue is processing
			if ($queue_status != 'empty') {
				$return['notices']['error'] = __( 'Cannot change API key while a sync queue is processing', 'wp-action-network' );
			} else {
				
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
				// $debug .= "trying to change api key\n";
				
				$actionnetwork_api_key_is_valid = false;
				
				// empty API key is "valid"
				if (!$actionnetwork_api_key) {
					$actionnetwork_api_key_is_valid = true;
				} else {
				
					// validate API key
					$ActionNetwork = new ActionNetwork($actionnetwork_api_key);
					$validate = $ActionNetwork->call('petitions');
				
					// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
					// $debug .= "validation returned:\n\n" . print_r($validate,1) . "\n\n";
					
					if (isset($validate->error)) {
						if (substr($validate->error,0,30) == 'API Key invalid or not present') {
							$return['notices']['error'][] = __( 'Invalid API key:', 'wp-action-network' ).' '.$actionnetwork_api_key;
						} else {
							$return['notices']['error'][] = __( 'Error validating API key:', 'wp-action-network' ).' '.$actionnetwork_api_key;
						}
					} else {
						$actionnetwork_api_key_is_valid = true;
					}
					
				}
				
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
				// $debug .= $actionnetwork_api_key_is_valid ? "actionnetwork_api_key is valid\n" : "actionnetwork_api_key is not valid\n";
				//echo "---\n";
                
				if ($actionnetwork_api_key_is_valid) {
			
					update_option('actionnetwork_api_key', $actionnetwork_api_key);
					update_option('actionnetwork_cache_timestamp', 0);
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
					$deleted = $wpdb->query("DELETE FROM {$wpdb->prefix}actionnetwork WHERE an_id != ''");

					if ($actionnetwork_api_key) {
						
						// Directly initialize the sync queue (no HTTP loopback)
						@set_time_limit( 300 );
						$sync = new Actionnetwork_Sync();
						$sync->init();
						update_option( 'actionnetwork_queue_status', 'processing' );
						update_option( 'actionnetwork_show_sync_notice', true );
						
						$queue_status = 'processing';
						$return['queue_status'] = $queue_status;
						
						$return['notices']['updated']['sync-started'] = $deleted ? __('API key has been updated, actions synced via previous API key have been removed, and sync with new API key has been started', 'wp-action-network') : __('API key has been updated and sync with new API key has been started', 'wp-action-network');
						
					} else {
						
						$return['notices']['updated'][] = $deleted ? __('API key and actions synced via API have been removed', 'wp-action-network') : __('API key has been removed', 'wp-action-network');
						
					}
				
				}
			
			}
		}
        // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code removed in production
        //echo $debug. "\n";
        
		break;

	case 'update_sync':
		// This case is now handled in actionnetwork_handle_form_submission()
		// which runs on admin_init hook (before headers are sent)
		// If we reach here, something went wrong - just break
	break;
	
	case 'reset_sync':
		// Clear the queue status and allow a fresh sync to start
		update_option('actionnetwork_queue_status', 'empty');
		delete_option('actionnetwork_show_sync_notice');
		
		$table_name_queue = $wpdb->prefix . 'actionnetwork_queue';
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$queue_table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_queue)) == $table_name_queue;
		if ($queue_table_exists) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->query("DELETE FROM {$table_name_queue}");
		}
		
		$return['notices']['updated'][] = __('Sync status has been reset. You can now start a new sync.', 'wp-action-network');
		$return['tab'] = 'sync-status';
	break;
		
		case 'edit_event':
		$embed_wp_id = isset($_REQUEST['actionnetwork_event_wp_id']) ? (int) $_REQUEST['actionnetwork_event_wp_id'] : 0;
		if ($embed_wp_id) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$event = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}actionnetwork WHERE wp_id=%d", $embed_wp_id), ARRAY_A );
			
			// only edit if wp_id refers to an existing event or tickted_event which is not API-synced
			if ( ($event == null) || $event['an_id'] ||
					(!in_array($event['type'],array('event','ticketed_event')))) {
				break;
			}
			
			// if we're posting, then get the title, date & code from $_POST
			$update = false;
			if (isset($_POST['postback']) && sanitize_text_field( wp_unslash( $_POST['postback'] ) )) {
				
				$update = true;
				
				$embed_title = isset($_REQUEST['actionnetwork_add_embed_title']) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_add_embed_title'] ) ) : '';
				$embed_date_string = isset($_REQUEST['actionnetwork_add_embed_date']) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_add_embed_date'] ) ) : '';
				$embed_date_time_hour = isset($_REQUEST['actionnetwork_add_embed_date_time_hour']) ? absint( wp_unslash( $_REQUEST['actionnetwork_add_embed_date_time_hour'] ) ) : 12;
				$embed_date_time_minutes = isset($_REQUEST['actionnetwork_add_embed_date_time_minutes']) ? absint( wp_unslash( $_REQUEST['actionnetwork_add_embed_date_time_minutes'] ) ) : 0;
				if ($embed_date_time_minutes < 10) { $embed_date_time_minutes = '0' . $embed_date_time_minutes; }
				$embed_date_time_ampm = isset($_REQUEST['actionnetwork_add_embed_date_time_ampm']) ? actionnetwork_validate_ampm( sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_add_embed_date_time_ampm'] ) ) ) : 'am';
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Embed code must preserve <script> tags; admin-only, capability-gated
			$embed_code = isset($_REQUEST['actionnetwork_add_embed_code']) ? wp_unslash( $_REQUEST['actionnetwork_add_embed_code'] ) : '';
			$location = isset($_REQUEST['actionnetwork_add_location']) ? wp_kses_post( wp_unslash( $_REQUEST['actionnetwork_add_location'] ) ) : '';
			
			// make sure title & embed_code are not empty, add error messages;
				if (!$embed_title) {
					$return['notices']['error'][] = __('You must give your action a title', 'wp-action-network');
					$return['errors']['#actionnetwork_add_embed_title'] = true;
					$update = false;
				}
				if (!$embed_code) {
					$return['notices']['error'][] = __('You must enter an embed code or description', 'wp-action-network');
					$return['errors']['#actionnetwork_add_embed_code'] = true;
					$update = false;
				}
				
			} else {
				
				$embed_title = esc_attr($event['title']);
				$embed_date_string = date_i18n('Y-m-d', $event['start_date']);
				$embed_date_time_hour = date_i18n('h', $event['start_date']);
				$embed_date_time_minutes = date_i18n('i', $event['start_date']);
				$embed_date_time_ampm = date_i18n('a', $event['start_date']);
				$embed_code = actionnetwork_get_embed_code( $event, '', false );
				$location_object = unserialize( $event['location'] );
				$location = isset( $location_object->html ) ? $location_object->html : '';
				
			}
			
			if ($update) {	
				
				$event['title'] = $embed_title;
				$embed_date_string .= ' '.$embed_date_time_hour.':'.$embed_date_time_minutes.' '.$embed_date_time_ampm;
				$event['start_date'] = strtotime($embed_date_string);
				$event['modified_date'] = (int) current_time('timestamp');
				
				// parse embed code
				// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet,WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Parsing Action Network embed code HTML, not outputting
				$embed_style_matched = preg_match_all("/<link href='https:\/\/actionnetwork\.org\/css\/style-embed(-whitelabel)?(-v3)?\.css' rel='stylesheet' type='text\/css' \/>/", $embed_code, $embed_style_matches, PREG_SET_ORDER);
				// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Parsing Action Network embed code HTML, not outputting
			$embed_script_matched = preg_match_all("|<script src='https://actionnetwork\.org/widgets/v\d+/([a-z_]+)/([-a-z0-9]+)\?format=js&source=widget(&style=full)?'>|", $embed_code, $embed_script_matches, PREG_SET_ORDER);
			$embed_style = $embed_style_matched ? ( isset($embed_style_matches[0][1]) && $embed_style_matches[0][1] ? 'layout_only' : 'default' ) : 'no';
				$embed_size = isset($embed_script_matches[0][3]) && $embed_script_matches[0][3] ? 'full' : 'standard';
				$embed_field_name = 'embed_'.$embed_size.'_'.$embed_style.'_styles';
				
				// clear out all possible embed codes, in case it has changed
				$event['embed_standard_layout_only_styles'] = '';
				$event['embed_full_layout_only_styles'] = '';
				$event['embed_standard_no_styles'] = '';
				$event['embed_full_no_styles'] = '';
				$event['embed_standard_default_styles'] = '';
				$event['embed_full_default_styles'] = '';
				$event[$embed_field_name] = $embed_code;
				
				// serialize location
				$location_object = new stdClass();
				$location_object->html = $location;
				$event['location'] = serialize($location_object);
				
				// Define table name
				$table_name = $wpdb->prefix . 'actionnetwork';
				
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->update($table_name, $event, array( 'wp_id' => $embed_wp_id ) );
				$return['notices']['updated'][] = sprintf(
					/* translators: %s is title of event */
					__('%s has been updated', 'wp-action-network'), $embed_title
				);
				// $return['notices']['error'][] = '$embed_date_string: '.$embed_date_string.'<br /><br />$_REQUEST:<br /><br /><pre>'.print_r($_REQUEST,1).'</pre>';
				
			// otherwise, build an edit form	
			} else {
				
				$admin_url = admin_url('admin.php?page=wp-action-network');
				
				$text_actions = __('Actions', 'wp-action-network');
				$text_edit_event = __('Edit Event', 'wp-action-network');
				$text_settings = __('Settings', 'wp-action-network');
				$text_sync_status = __('Sync Status', 'wp-action-network');
				
				$form_action = admin_url('admin.php?page=wp-action-network');
				$nonce_field = wp_nonce_field( 'actionnetwork_edit_event', 'actionnetwork_nonce_field', true, false );
				$text_title = __('Title', 'wp-action-network');
				$text_required = __('This field is required', 'wp-action-network');
				$error_title_required = isset($return['errors']['#actionnetwork_add_embed_title']) && $return['errors']['#actionnetwork_add_embed_title'] ? ' error' : '';
				$text_date = __('Date (if event)', 'wp-action-network');
				$input_time = actionnetwork_build_time_input( $embed_date_time_hour, $embed_date_time_minutes, $embed_date_time_ampm );
				
				$text_embed_code = __('Embed Code/Event Description', 'wp-action-network');
				$error_embed_code_required = isset($return['errors']['#actionnetwork_add_embed_code']) && $return['errors']['#actionnetwork_add_embed_code'] ? ' error' : '';
				
				$text_location = __('Event location', 'wp-action-network');
				$text_location_description = __('If you are entering a description above (instead of an embed code), make sure the title, date and location (if relevant) are included in the description as well.', 'wp-action-network');
				
				$text_update_event = __('Update event', 'wp-action-network');
				
				// phpcs:ignore Squiz.PHP.Heredoc.NotAllowed -- Complex HTML form with variables, heredoc is most readable
				$return['edit_event_form'] = <<<EOHTML
				
				
			<h2 class="nav-tab-wrapper">
				<a href="$admin_url#actionnetwork-actions" class="nav-tab">
					$text_actions
				</a>
				<span class="nav-tab nav-tab-active">
					$text_edit_event
				</span>
				<a href="$admin_url#actionnetwork-settings" class="nav-tab">
					$text_settings
				</a>
                <a href="$admin_url#actionnetwork-sync-status" class="nav-tab">$text_sync_status</a>
			</h2>
			
				<h2>$text_edit_event</h2>
				<form method="post" action="$form_action">

					$nonce_field

					<input type="hidden" name="actionnetwork_admin_action" value="edit_event" />
					<input type="hidden" name="actionnetwork_event_wp_id" value="$embed_wp_id" />
					<input type="hidden" name="postback" value="1" />
 					<table class="form-table"><tbody>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_add_embed_title">$text_title <span class="required" title="$text_required">*</span></label></th>
							<td>
								<input id="actionnetwork_add_embed_title" name="actionnetwork_add_embed_title" class="required$error_title_required" type="text" value="$embed_title" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_add_embed_date">$text_date</label></th>
							<td>
								<input id="actionnetwork_add_embed_date" name="actionnetwork_add_embed_date" type="date" value="$embed_date_string" /> $input_time
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_add_embed_code">$text_embed_code <span class="required" title="$text_required">*</span></label></th>
							<td>
								<textarea id="actionnetwork_add_embed_code" name="actionnetwork_add_embed_code" class="required$error_embed_code_required">$embed_code</textarea>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_add_location">$text_location</label></th>
							<td>
								<textarea id="actionnetwork_add_location" name="actionnetwork_add_location">$location</textarea>
								<p>$text_location_description</p>
							</td>
						</tr>
					</tbody></table>
					<p class="submit"><input type="submit" id="actionnetwork-add-embed-form-submit" class="button-primary" value="$text_update_event" /></p>
				</form>
EOHTML;
			
			}
			
			// update
			
		}
		break;
		
	case 'add_embed':
		$embed_title = isset($_REQUEST['actionnetwork_add_embed_title']) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_add_embed_title'] ) ) : '';
		$embed_date_string = isset($_REQUEST['actionnetwork_add_embed_date']) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_add_embed_date'] ) ) : '';
		$embed_date_time_hour = isset($_REQUEST['actionnetwork_add_embed_date_time_hour']) ? absint( wp_unslash( $_REQUEST['actionnetwork_add_embed_date_time_hour'] ) ) : 12;
		$embed_date_time_minutes = isset($_REQUEST['actionnetwork_add_embed_date_time_minutes']) ? absint( wp_unslash( $_REQUEST['actionnetwork_add_embed_date_time_minutes'] ) ) : 0;
		if ($embed_date_time_minutes < 10) { $embed_date_time_minutes = '0' . $embed_date_time_minutes; }
		$embed_date_time_ampm = isset($_REQUEST['actionnetwork_add_embed_date_time_ampm']) ? actionnetwork_validate_ampm( sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_add_embed_date_time_ampm'] ) ) ) : 'am';
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Embed code must preserve <script> tags; admin-only, capability-gated
	$embed_code = isset($_REQUEST['actionnetwork_add_embed_code']) ? wp_unslash( $_REQUEST['actionnetwork_add_embed_code'] ) : '';
	$location = isset($_REQUEST['actionnetwork_add_location']) ? wp_kses_post( wp_unslash( $_REQUEST['actionnetwork_add_location'] ) ) : '';
	$embed_wp_id = isset($_REQUEST['actionnetwork_embed_wp_id']) ? absint( wp_unslash( $_REQUEST['actionnetwork_embed_wp_id'] ) ) : 0;
		
		$embed_valid = true;

		// parse embed code
		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet,WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Parsing Action Network embed code HTML, not outputting
		$embed_style_matched = preg_match_all("/<link href='https:\/\/actionnetwork\.org\/css\/style-embed(-whitelabel)?(-v3)?\.css' rel='stylesheet' type='text\/css' \/>/", $embed_code, $embed_style_matches, PREG_SET_ORDER);
		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Parsing Action Network embed code HTML, not outputting
		$embed_script_matched = preg_match_all("|<script src='https://actionnetwork\.org/widgets/v\d+/([a-z_]+)/([-a-z0-9]+)\?format=js&source=widget(&style=full)?'>|", $embed_code, $embed_script_matches, PREG_SET_ORDER);

		$embed_style = $embed_style_matched ? ( isset($embed_style_matches[0][1]) && $embed_style_matches[0][1] ? 'layout_only' : 'default' ) : 'no';
		$embed_type = isset($embed_script_matches[0][1]) ? $embed_script_matches[0][1] : '';
		if ($embed_type == 'letter') { $embed_type = 'advocacy_campaign'; }
		if ($embed_type == 'fundraising') { $embed_type = 'fundraising_page'; }
		$embed_size = isset($embed_script_matches[0][3]) && $embed_script_matches[0][3] ? 'full' : 'standard';

		if (!$embed_title) {
			if (isset($embed_script_matches[0][2]) && $embed_script_matches[0][2]) {
				$embed_title = ucwords(str_replace('-',' ',$embed_script_matches[0][2]));
			} else {
				$return['notices']['error'][] = __('You must give your action a title', 'wp-action-network');
				$return['errors']['#actionnetwork_add_embed_title'] = true;
				$return['actionnetwork_add_embed_date'] = $embed_date_string;
				$return['actionnetwork_add_embed_date_time_hour'] = $embed_date_time_hour;
				$return['actionnetwork_add_embed_date_time_minutes'] = $embed_date_time_minutes;
				$return['actionnetwork_add_embed_date_time_ampm'] = $embed_date_time_ampm;
				$return['actionnetwork_add_embed_code'] = $embed_code;
				$return['actionnetwork_add_location'] = $location;
				$embed_valid = false;
			}
		}
		if (!$embed_code) {
			$return['notices']['error'][] = __('You must enter an embed code or description', 'wp-action-network');
			$return['errors']['#actionnetwork_add_embed_code'] = true;
			$return['actionnetwork_add_embed_date'] = $embed_date_string;
			$return['actionnetwork_add_embed_date_time_hour'] = $embed_date_time_hour;
			$return['actionnetwork_add_embed_date_time_minutes'] = $embed_date_time_minutes;
			$return['actionnetwork_add_embed_date_time_ampm'] = $embed_date_time_ampm;
			$return['actionnetwork_add_embed_title'] = $embed_title;
			$return['actionnetwork_add_location'] = $location;
			$embed_valid = false;
		}
		
		// if there is an $embed_date, but no embed type, treat as an event
		if ($embed_date_string && !$embed_type) {
			$embed_type = 'event';
		}
		
		// if there's no valid embed type, then the embed code is not valid
		if (!in_array( $embed_type, array(
				'petition','advocacy_campaign','event','ticketed_event','fundraising_page','form'
		))) {
			$return['notices']['error'][] = __('This does not seem to be a valid Action Network embed code', 'wp-action-network');
			$return['actionnetwork_add_embed_date'] = $embed_date_string;
			$return['actionnetwork_add_embed_date_time_hour'] = $embed_date_time_hour;
			$return['actionnetwork_add_embed_date_time_minutes'] = $embed_date_time_minutes;
			$return['actionnetwork_add_embed_date_time_ampm'] = $embed_date_time_ampm;
			$return['actionnetwork_add_embed_title'] = $embed_title;
			$return['actionnetwork_add_embed_code'] = $embed_code;
			$return['actionnetwork_add_location'] = $location;
			$return['errors']['#actionnetwork_add_embed_code'] = true;
			$embed_valid = false;
		}
		
		if ($embed_valid) {
			
			// if the type is event or ticketed_event, give a warning if there is no start_date
			if ( ($embed_type == 'event' || $embed_type == 'ticketed_event') && !$embed_date_string) {
				$return['notices']['updated'][] = __('Notice: if you do not add a start date to your event, it will not display on the calendar widget', 'wp-action-network');
			}
		
			// if the type is *not* event or ticketed_event, and there is a date, give a warning that it won't be used
			if ( ($embed_type != 'event') && ($embed_type != 'ticketed_event') && $embed_date_string) {
				$embed_date_string = '';
				$return['notices']['updated'][] = __('Notice: the date entered in the "start date" field is not used for actions that are not events or ticketed events', 'wp-action-network');
			}
			
			// serialize location
			$location_object = new stdClass();
			$location_object->html = $location;
			$location_serialized = serialize($location_object);
			
			// save to action
			$table_name = $wpdb->prefix . 'actionnetwork';
			$embed_field_name = 'embed_'.$embed_size.'_'.$embed_style.'_styles';

			$data = array(
				'type' => $embed_type,
				'title' => $embed_title,
				$embed_field_name => $embed_code,
				'location' => $location_serialized,
				'enabled' => 1,
				'created_date' => (int) current_time('timestamp'),
				'modified_date' => (int) current_time('timestamp'),
			);
			if ($embed_date_string) {
				$embed_date_string .= ' '.$embed_date_time_hour.':'.$embed_date_time_minutes.' '.$embed_date_time_ampm;
				$data['start_date'] = strtotime($embed_date_string);
			}

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->insert($table_name, $data, array ( '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d' ) );
			
			$__copy = __('Copy', 'wp-action-network');
			// phpcs:ignore Squiz.PHP.Heredoc.NotAllowed -- Simple HTML with variable, heredoc is most readable
			$shortcode_copy = <<<EOHTML
<span class="copy-wrapper">
<input type="text" class="copy-text" readonly="readonly" id="shortcode-new-{$wpdb->insert_id}" value="[actionnetwork id={$wpdb->insert_id}]" /><button data-copytarget="#shortcode-new-{$wpdb->insert_id}" class="copy">$__copy</button>
</span>
EOHTML;

			$return['notices']['updated'][] = sprintf(
				/* translators: %s: The shortcode for the saved embed code */
				__('Action saved. Shortcode: %s', 'wp-action-network'),
				$shortcode_copy
			);

			$return['actionnetwork_add_embed_title'] = '';
			$return['actionnetwork_add_embed_code'] = '';
		}
		break;
		
	}
	
	return $return;
}

/**
 * Helper functions for dealing with time
 */
function actionnetwork_validate_ampm($text) {
	return (strtolower($text) == 'pm') ? 'pm' : 'am';
}

function actionnetwork_build_time_input($hour = 12, $minutes = 0, $ampm = 'am') {
	
	if (strlen($minutes) < 2) { $minutes = '0' . $minutes; }
	
	$am_selected = selected( $ampm, 'am', false );
	$pm_selected = selected( $ampm, 'pm', false );
	
	// phpcs:ignore Squiz.PHP.Heredoc.NotAllowed -- HTML form inputs with variables, heredoc is most readable
	return <<<EOHTML
	<input name="actionnetwork_add_embed_date_time_hour" id="actionnetwork_add_embed_date_time_hour" type="number" min="1" max="12" step="1" value="$hour" />
	:
	<input name="actionnetwork_add_embed_date_time_minutes" id="actionnetwork_add_embed_date_time_minutes" type="number" min="0" max="55" step="5" value="$minutes" onchange="if((this.value.length<2)&&(parseInt(this.value,10)<10))this.value='0'+this.value;" />
	<select name="actionnetwork_add_embed_date_time_ampm" id="actionnetwork_add_embed_date_time_ampm">
		<option value="am" $am_selected>am</option>
		<option value="pm" $pm_selected>pm</option>
	</select>
EOHTML;
}

/**
 * Administrative page
 */
function actionnetwork_admin_page() {

	global $actionnetwork_version;
	
	// defines Actionnetwork_Action_List class, which extends WP_List_Table
	require_once( plugin_dir_path( __FILE__ ) . 'includes/actionnetwork-action-list.class.php' );

	// load scripts and stylesheets
	wp_enqueue_style( 'actionnetwork-admin-css', plugins_url('admin.css', __FILE__), array(), ACTIONNETWORK_VERSION );
	wp_register_script( 'actionnetwork-admin-js', plugins_url('admin.js', __FILE__), array(), ACTIONNETWORK_VERSION, true );

	// localize script
	$translation_array = array(
		'copied' => __( 'Copied!', 'wp-action-network' ),
		'pressCtrlCToCopy' => __( 'please press Ctrl/Cmd+C to copy', 'wp-action-network' ),
		'clearResults' => __( 'clear results', 'wp-action-network' ),
		'changeAPIKey' => __( 'Change or delete API key', 'wp-action-network' ),
		'confirmChangeAPIKey' => __( 'Are you sure you want to change or delete the API key? Doing so means any actions you have synced via the API will be deleted.', 'wp-action-network' ),
		/* translators: %s: date of last sync */
		'lastSynced' => __( 'Last synced %s', 'wp-action-network' ),
	);
	wp_localize_script( 'actionnetwork-admin-js', 'actionnetworkText', $translation_array );
	wp_enqueue_script( 'actionnetwork-admin-js' ); // Version and footer already set in wp_register_script
	
	// This checks which tab we should display
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Tab selection is display-only, no data modification
	$tab = isset($_REQUEST['actionnetwork_tab']) ? sanitize_text_field( wp_unslash( $_REQUEST['actionnetwork_tab'] ) ) : 'actions';

	// This handles form submissions and prints any relevant notices from them
	$notices_html = '';
	$action_returns = array();
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification handled in actionnetwork_admin_handle_actions()
	if (isset($_REQUEST['actionnetwork_admin_action'])) {
		$action_returns = actionnetwork_admin_handle_actions();
		if (isset($action_returns['notices'])) {
			if (isset($action_returns['notices']['error']) && is_array($action_returns['notices']['error'])) {
				foreach ($action_returns['notices']['error'] as $index => $notice) {
					$notices_html .= '<div class="error notice is-dismissible" id="actionnetwork-error-notice-'.$index.'"><p>'.$notice.'</p></div>';
				}
			}
			if (isset($action_returns['notices']['updated']) && is_array($action_returns['notices']['updated'])) {
				foreach ($action_returns['notices']['updated'] as $index => $notice) {
					$notices_html .= '<div class="updated notice is-dismissible" id="actionnetwork-update-notice-'.$index.'"><p>'.$notice.'</p></div>';
				}
			}

		}
		if (isset($action_returns['tab'])) { $tab = $action_returns['tab']; }
	}

	// This prepares this list
	$action_list = new Actionnetwork_Action_List();
	$action_list->prepare_items();
	if (isset($action_list->notices)) {
		if (isset($action_list->notices['error']) && is_array($action_list->notices['error'])) {
			foreach ($action_list->notices['error'] as $index => $notice) {
				$notices_html .= '<div class="error notice is-dismissible" id="actionnetwork-list-error-notice-'.$index.'"><p>'.$notice.'</p></div>';
			}
		}
		if (isset($action_list->notices['updated']) && is_array($action_list->notices['updated'])) {
			foreach ($action_list->notices['updated'] as $index => $notice) {
				$notices_html .= '<div class="updated notice is-dismissible" id="actionnetwork-list-update-notice-'.$index.'"><p>'.$notice.'</p></div>';
			}
		}
	}

	// get API Key
	$actionnetwork_api_key = get_option('actionnetwork_api_key');

	// get hCaptcha keys
	$hcaptcha_site_key = get_option('actionnetwork_hcaptcha_site_key');
	$hcaptcha_secret_key = get_option('actionnetwork_hcaptcha_secret_key');
	
	// get queue status - allow action_returns to override the option because
	// we've started the queue processing in a separate process, which might not
	// have reset the option yet
	$queue_status = isset($action_returns['queue_status']) ? $action_returns['queue_status'] : get_option('actionnetwork_queue_status', 'empty');

	?>
	
	<div class='wrap'>
		
		<h1><img src="<?php echo esc_url( plugins_url('logo-action-network.png', __FILE__) ); ?>" /> Action Network
			<?php if (strpos($actionnetwork_version,'beta')): ?>
				<span class="subtitle">BETA</span>
			<?php endif; ?>
		</h1>
		
		<div class="wrap-inner">

			<?php if ($notices_html) { echo wp_kses_post( $notices_html ); } ?>
			
			<?php
			// Check if we should show the sync started notice with AJAX polling
			if ( get_option( 'actionnetwork_show_sync_notice', false ) ) {
				// Output the AJAX nonce for polling
				wp_nonce_field( 'actionnetwork_get_queue_status', 'actionnetwork_ajax_nonce', false );
				
				echo '<div class="updated notice is-dismissible" id="actionnetwork-update-notice-sync-started"><p>' . esc_html__( 'Sync started', 'wp-action-network' ) . '</p></div>';
				
				// Clear the flag
				delete_option( 'actionnetwork_show_sync_notice' );
			}
			?>

				<?php if ($actionnetwork_api_key) : ?>
				<form method="post" action="" id="actionnetwork-update-sync" class="alignright">
					<?php
						// nonce field for form submission
						wp_nonce_field( 'actionnetwork_update_sync', 'actionnetwork_nonce_field' );
						
						// nonce field for ajax requests
						wp_nonce_field( 'actionnetwork_get_queue_status', 'actionnetwork_ajax_nonce', false );
					?>
					<input type="hidden" name="actionnetwork_admin_action" id="actionnetwork-sync-action" value="update_sync" />
					<input type="submit" id="actionnetwork-update-sync-submit" class="button" value="<?php esc_attr_e('Full API Sync', 'wp-action-network'); ?>" <?php
						// if we're currently processing a queue, disable this button
						if ($queue_status == 'processing') { echo 'disabled="disabled" ';}
					?>/>
					<div class="last-sync"><?php
						$last_updated = get_option('actionnetwork_cache_timestamp', 0);
						if ($queue_status == 'processing') {
							esc_html_e('API Sync queue is processing', 'wp-action-network');
						} elseif ($last_updated) {
							printf(
								/* translators: %s: date of last sync */
								esc_html__('Last synced %s', 'wp-action-network'),
								esc_html( date_i18n('n/j/Y g:ia', $last_updated) )
							);
						} else {
							esc_html_e('This API key has not been synced', 'wp-action-network');
						}
					?></div>
				</form>
				<?php endif; ?>
				
			<?php 	// if there is an edit form, just display that and quit
				if (isset($action_returns['edit_event_form']) && $action_returns['edit_event_form']) {
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- edit_event_form contains pre-escaped HTML form
					echo $action_returns['edit_event_form'];
					echo "</div> <!-- /.wrap-inner -->\n";
					echo "</div> <!-- /.wrap -->\n";
					return;
				}
			?>
			
			<h2 class="nav-tab-wrapper">
				<a href="#actionnetwork-actions" class="nav-tab<?php echo ($tab == 'actions') ? ' nav-tab-active' : ''; ?>">
					<?php esc_html_e('Actions', 'wp-action-network'); ?>
				</a>
				<a href="#actionnetwork-settings" class="nav-tab<?php echo ($tab == 'settings') ? ' nav-tab-active' : ''; ?>">
					<?php esc_html_e('Settings', 'wp-action-network'); ?>
				</a>
                
				<a href="#actionnetwork-sync-status" class="nav-tab<?php echo ($tab == 'sync-status' || $tab == 'cron-updates') ? ' nav-tab-active' : ''; ?>">
					<?php esc_html_e('Sync Status', 'wp-action-network'); ?>
				</a>
                
				<a href="#actionnetwork-about" class="nav-tab<?php echo ($tab == 'about') ? ' nav-tab-active' : ''; ?>">
					<?php esc_html_e('About', 'wp-action-network'); ?>
				</a>
			</h2>
			
			<?php /* list actions */ ?>
			<div class="actionnetwork-admin-tab<?php echo ($tab == 'actions') ? ' actionnetwork-admin-tab-active' : ''; ?>" id="actionnetwork-actions">
				<h2>
					<?php esc_html_e('Your Actions', 'wp-action-network'); ?>
					<?php
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Search is display-only, will be sanitized on next line
					$search_raw = isset($_GET['search']) ? wp_unslash( $_GET['search'] ) : '';
					if (!empty($search_raw)) {
						$search_term = sanitize_text_field( $search_raw );
						echo '<span class="subtitle search-results-title">';
						/* translators: %s: the term being searched for */
						printf( esc_html__('Search results for test "%s"', 'wp-action-network'), esc_html( $search_term ) );
						echo '</span>';
					} ?>
				</h2>

				<?php
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter is display-only
					$filter_type = isset($_GET['type']) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : '';
					$searchtype = !empty($filter_type) && isset($action_list->action_type_plurals[$filter_type]) ? $action_list->action_type_plurals[$filter_type] : __('Actions', 'wp-action-network');
					$searchtext = sprintf(
						/* translators: %s: "actions", or plural of action type, which will be searched) */
						esc_html__('Search %s', 'wp-action-network'),
						esc_html($searchtype)
					);
				?>

				<p class="search-box">
					<button type="button" id="actionnetwork-toggle-add-form" class="button"><?php esc_html_e('Add Action', 'wp-action-network'); ?></button>
					<span class="dashicons dashicons-editor-help actionnetwork-add-help-icon" title="<?php esc_attr_e('Use this to manually add Action Network embed codes. This is useful for: (1) Ticketed Events (not available via API), (2) Users without an API key, or (3) Adding individual actions without running a full sync.', 'wp-action-network'); ?>"></span>
				</p>
				
				<!-- Add Action Form (collapsible) -->
				<div id="actionnetwork-add-action-form" style="display: none; margin-bottom: 20px;">
						<h3><?php esc_html_e('Add action', 'wp-action-network'); ?></h3>
						<p class="description">
							<?php esc_html_e('Use this form to manually add Action Network embed codes to your WordPress site. This is useful for Ticketed Events (which are not available through the Action Network API), or for adding individual actions without running a full API sync.', 'wp-action-network'); ?>
						</p>
						<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=wp-action-network' ) ); ?>">
							<?php
								$actionnetwork_add_embed_title =
									isset($action_returns['actionnetwork_add_embed_title']) ?
									$action_returns['actionnetwork_add_embed_title'] : '';
								$actionnetwork_add_embed_date =
									isset($action_returns['actionnetwork_add_embed_date']) ?
									$action_returns['actionnetwork_add_embed_date'] : '';
								$actionnetwork_add_embed_date_time_hour =
									isset($action_returns['actionnetwork_add_embed_date_time_hour']) ?
									$action_returns['actionnetwork_add_embed_date_time_hour'] : 12;
								$actionnetwork_add_embed_date_time_minutes =
									isset($action_returns['actionnetwork_add_embed_date_time_minutes']) ?
									$action_returns['actionnetwork_add_embed_date_time_minutes'] : '00';
								$actionnetwork_add_embed_date_time_ampm =
									isset($action_returns['actionnetwork_add_embed_date_time_ampm']) ?
									$action_returns['actionnetwork_add_embed_date_time_ampm'] : 'am';
								$actionnetwork_add_embed_code =
									isset($action_returns['actionnetwork_add_embed_code']) ?
									$action_returns['actionnetwork_add_embed_code'] : '';
								$actionnetwork_add_location =
									isset($action_returns['actionnetwork_add_location']) ?
									$action_returns['actionnetwork_add_location'] : '';
								wp_nonce_field( 'actionnetwork_add_embed', 'actionnetwork_nonce_field' );
							?>
							<input type="hidden" name="actionnetwork_admin_action" value="add_embed" />
							<table class="form-table"><tbody>
								<tr valign="top">
									<th scope="row"><label for="actionnetwork_add_embed_title"><?php esc_html_e('Title', 'wp-action-network'); ?> <span class="required" title="<?php esc_attr_e('This field is required', 'wp-action-network'); ?>">*</span></label></th>
									<td>
										<input id="actionnetwork_add_embed_title" name="actionnetwork_add_embed_title" class="required<?php
											echo (isset($action_returns['errors']['#actionnetwork_add_embed_title']) && $action_returns['errors']['#actionnetwork_add_embed_title']) ? ' error' : '';
										?>" type="text" value="<?php echo esc_attr($actionnetwork_add_embed_title); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="actionnetwork_add_embed_date"><?php esc_html_e('Date (if event)', 'wp-action-network'); ?></label></th>
									<td>
										<input id="actionnetwork_add_embed_date" name="actionnetwork_add_embed_date" type="date" class="<?php
											echo (isset($action_returns['errors']['#actionnetwork_add_embed_date']) && $action_returns['errors']['#actionnetwork_add_embed_date']) ? 'error' : '';
										?>" value="<?php echo esc_attr($actionnetwork_add_embed_date); ?>" /> <?php echo wp_kses_post( actionnetwork_build_time_input( $actionnetwork_add_embed_date_time_hour, $actionnetwork_add_embed_date_time_minutes, $actionnetwork_add_embed_date_time_ampm ) ); ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="actionnetwork_add_embed_code"><?php esc_html_e('Embed Code/Event Description', 'wp-action-network'); ?> <span class="required" title="<?php esc_attr_e('This field is required', 'wp-action-network'); ?>">*</span></label></th>
									<td>
										<textarea id="actionnetwork_add_embed_code" name="actionnetwork_add_embed_code" class="required<?php
											echo (isset($action_returns['errors']['#actionnetwork_add_embed_code']) && $action_returns['errors']['#actionnetwork_add_embed_code']) ? ' error' : '';
										?>"><?php echo esc_textarea($actionnetwork_add_embed_code); ?></textarea>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="actionnetwork_add_location"><?php esc_html_e('Event location', 'wp-action-network'); ?></label></th>
									<td>
										<textarea id="actionnetwork_add_location" name="actionnetwork_add_location"><?php echo esc_textarea($actionnetwork_add_location); ?></textarea>
										<p><?php esc_html_e('Event location will only display on the upcoming events list; if you are entering a description above (instead of an embed code), make sure the location is included in the description as well', 'wp-action-network'); ?></p>
									</td>
								</tr>
							</tbody></table>
							<p class="submit">
								<input type="submit" id="actionnetwork-add-embed-form-submit" class="button-primary" value="<?php esc_attr_e('Add Action', 'wp-action-network'); ?>" />
								<button type="button" class="button" id="actionnetwork-cancel-add-form"><?php esc_html_e('Cancel', 'wp-action-network'); ?></button>
							</p>
						</form>
					</div>
					
				<form id="actionnetwork-actions-filter" method="get">
					<input type="hidden" name="page" value="wp-action-network" />
					<p class="search-box">
						<label class="screen-reader-text" for="action-search-input"><?php echo esc_html( $searchtext ); ?>:</label>					
						<?php
						// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Search form is display-only
						$search_value = isset($_GET['search']) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['search'] ) ) ) : '';
						?>
						<input type="search" id="action-search-input" name="search" value="<?php echo esc_attr( $search_value ); ?>" placeholder="<?php esc_attr_e('Search','wp-action-network'); ?>" />
						<input type="submit" id="action-search-submit" class="button" value="<?php echo esc_attr( $searchtext ); ?>">
					</p>
					<?php $action_list->display(); ?>
				</form>
				<div id="shortcode-options">
					<p><?php esc_html_e('Actionnetwork shortcodes for actions synced via the API can take two additional attributes besides the required id attribute:', 'wp-action-network'); ?></p>
					<ul><li><?php esc_html_e('The size attribute can be set to full or standard (standard is the default)', 'wp-action-network'); ?></li>
					<li><?php esc_html_e('The style attribute can be set to default, layout_only, or no (layout_only is the default)', 'wp-action-network'); ?></li></ul>
				</div>
			</div>
		
			<?php /* settings tab */ ?>
			<div class="actionnetwork-admin-tab<?php echo ($tab == 'settings') ? ' actionnetwork-admin-tab-active' : ''; ?>" id="actionnetwork-settings">
				<h2><?php esc_html_e('Plugin Settings', 'wp-action-network'); ?></h2>
				<form method="post" action="">
					<?php
						wp_nonce_field( 'actionnetwork_update_api_key', 'actionnetwork_nonce_field' );
					?>
					<input type="hidden" name="actionnetwork_admin_action" value="update_api_key" />
					<input type="hidden" name="actionnetwork_tab" value="settings" />

					<table class="form-table"><tbody>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_api_key"><?php esc_html_e('Action Network API Key', 'wp-action-network'); ?></label></th>
							<td>
								<input id="actionnetwork_api_key" name="actionnetwork_api_key" type="text" value="<?php echo esc_attr($actionnetwork_api_key); ?>" />
							</td>
						</tr>
					</tbody></table>
					<p class="submit"><input type="submit" id="actionnetwork-options-form-submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wp-action-network'); ?>" /></p>
				</form>
				<h2><?php esc_html_e('Plugin Captcha Settings', 'wp-action-network'); ?></h2>
				<p><?php esc_html_e('In order to be able to activate anti-spam challenges you have to fill up the forms bellow. In order to get the keys all you have to do is create an account on', 'wp-action-network'); ?> <a href="https://hcaptcha.com" target="_blank">hcaptcha.com</a>.</p>
				<form method="post" action="">
					<?php
						wp_nonce_field( 'actionnetwork_update_spam_keys', 'actionnetwork_nonce_field' );
					?>
					<input type="hidden" name="actionnetwork_admin_action" value="update_spam_keys" />
					<input type="hidden" name="actionnetwork_tab" value="settings" />

					<table class="form-table"><tbody>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_hcaptcha_site_key"><?php esc_html_e('hCaptcha Site Key', 'wp-action-network'); ?></label></th>
							<td>
								<input id="actionnetwork_hcaptcha_site_key" style="min-width: 400px" name="actionnetwork_hcaptcha_site_key" type="text" value="<?php echo esc_attr($hcaptcha_site_key); ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="actionnetwork_hcaptcha_secret_key"><?php esc_html_e('hCaptcha Secret Key', 'wp-action-network'); ?></label></th>
							<td>
								<input id="actionnetwork_hcaptcha_secret_key" style="min-width: 400px" name="actionnetwork_hcaptcha_secret_key" type="text" value="<?php echo esc_attr($hcaptcha_secret_key); ?>" />
							</td>
						</tr>
					</tbody></table>
					<p class="submit"><input type="submit" id="actionnetwork-options-form-submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wp-action-network'); ?>" /></p>
				</form>
			</div>

			<?php /* Sync Status tab */ ?>
			<div class="actionnetwork-admin-tab<?php echo ($tab == 'sync-status') ? ' actionnetwork-admin-tab-active' : ''; ?>" id="actionnetwork-sync-status">
				<h2><?php esc_html_e('Sync Status & Debugging', 'wp-action-network'); ?></h2>
				<?php
				global $wpdb;
				
				$queue_status = get_option('actionnetwork_queue_status', 'empty');
				$last_sync = get_option('actionnetwork_cache_timestamp', 0);
				$show_sync_notice = get_option('actionnetwork_show_sync_notice', false);
				$deferred_notices = get_option('actionnetwork_deferred_admin_notices', array());
				
				$table_name_queue = $wpdb->prefix . 'actionnetwork_queue';
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				$queue_table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_queue)) == $table_name_queue;
				
				$queue_total = 0;
				$queue_processed = 0;
				$queue_unprocessed = 0;
				
				if ($queue_table_exists) {
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
					$queue_total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table_name_queue}");
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
					$queue_processed = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table_name_queue} WHERE processed = 1");
					$queue_unprocessed = $queue_total - $queue_processed;
				}
				
				$is_stuck = ($queue_status == 'processing' && $queue_table_exists && $queue_unprocessed > 0);
				?>
				
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php esc_html_e('Current Sync Status', 'wp-action-network'); ?></th>
							<td>
								<strong><?php echo esc_html( ucfirst( $queue_status ) ); ?></strong>
								<?php if ($queue_status == 'processing' && $queue_total > 0): ?>
									<p><?php printf( esc_html__( '%d of %d items processed', 'wp-action-network' ), $queue_processed, $queue_total ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e('Last Successful Sync', 'wp-action-network'); ?></th>
							<td>
								<?php if ($last_sync): ?>
									<?php echo esc_html( date_i18n( 'F j, Y g:i a', $last_sync ) ); ?>
									<?php
									$last_inserted = get_option('actionnetwork_last_sync_inserted', 0);
									$last_updated = get_option('actionnetwork_last_sync_updated', 0);
									$last_deleted = get_option('actionnetwork_last_sync_deleted', 0);
									if ($last_inserted > 0 || $last_updated > 0 || $last_deleted > 0):
									?>
										<p style="margin-top: 5px; font-size: 12px; color: #666;">
											<?php printf( esc_html__( 'Inserted: %d, Updated: %d, Deleted: %d', 'wp-action-network' ), $last_inserted, $last_updated, $last_deleted ); ?>
										</p>
									<?php endif; ?>
								<?php else: ?>
									<?php esc_html_e('Never', 'wp-action-network'); ?>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e('Queue Information', 'wp-action-network'); ?></th>
							<td>
								<?php if ($queue_table_exists): ?>
									<ul>
										<li><?php esc_html_e('Total items in queue:', 'wp-action-network'); ?> <strong><?php echo esc_html( $queue_total ); ?></strong></li>
										<li><?php esc_html_e('Processed:', 'wp-action-network'); ?> <strong><?php echo esc_html( $queue_processed ); ?></strong></li>
										<li><?php esc_html_e('Unprocessed:', 'wp-action-network'); ?> <strong><?php echo esc_html( $queue_unprocessed ); ?></strong></li>
									</ul>
								<?php else: ?>
									<?php esc_html_e('Queue table does not exist', 'wp-action-network'); ?>
								<?php endif; ?>
							</td>
						</tr>
						<?php if (!empty($deferred_notices)): ?>
						<tr>
							<th scope="row"><?php esc_html_e('Recent Messages', 'wp-action-network'); ?></th>
							<td>
								<?php foreach ($deferred_notices as $key => $notice): ?>
									<div class="notice notice-info inline">
										<p><?php echo wp_kses_post( $notice ); ?></p>
									</div>
								<?php endforeach; ?>
							</td>
						</tr>
						<?php endif; ?>
						<?php if ($is_stuck || ($queue_status == 'processing' && $queue_unprocessed == 0 && $queue_total > 0)): ?>
						<tr>
							<th scope="row"><?php esc_html_e('Reset Stuck Sync', 'wp-action-network'); ?></th>
							<td>
								<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=wp-action-network&actionnetwork_tab=sync-status' ) ); ?>">
									<?php wp_nonce_field('actionnetwork_reset_sync', 'actionnetwork_nonce_field'); ?>
									<input type="hidden" name="actionnetwork_admin_action" value="reset_sync" />
									<input type="hidden" name="actionnetwork_tab" value="sync-status" />
									<p><?php esc_html_e('If the sync appears to be stuck, you can reset it here. This will clear the queue and allow you to start a new sync.', 'wp-action-network'); ?></p>
									<p><input type="submit" class="button" value="<?php esc_attr_e('Reset Sync Status', 'wp-action-network'); ?>" onclick="return confirm('<?php esc_attr_e('Are you sure you want to reset the sync? This will clear any pending sync operations.', 'wp-action-network'); ?>');" /></p>
								</form>
							</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
				
				<h3><?php esc_html_e('Cron Update History', 'wp-action-network'); ?></h3>
				<?php
				$table_name_cron = $wpdb->prefix . "actionnetwork_cron_log";
				$table_name_cron_escaped = esc_sql( $table_name_cron );
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				if($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_cron)) == $table_name_cron):
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
					$cron_logs = $wpdb->get_results( "SELECT * FROM `{$table_name_cron_escaped}` ORDER BY id DESC LIMIT 50" );
					if(count($cron_logs) != 0):
				?>
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th><?php esc_html_e('ID', 'wp-action-network'); ?></th>
							<th><?php esc_html_e('Time', 'wp-action-network'); ?></th>
							<th><?php esc_html_e('Inserted', 'wp-action-network'); ?></th>
							<th><?php esc_html_e('Updated', 'wp-action-network'); ?></th>
							<th><?php esc_html_e('New Only', 'wp-action-network'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($cron_logs as $row): ?>
						<tr>
							<td><?php echo esc_html( $row->id ); ?></td>
							<td><?php echo esc_html( $row->time ); ?></td>
							<td><?php echo esc_html( $row->inserted ); ?></td>
							<td><?php echo esc_html( $row->updated ); ?></td>
							<td><?php echo esc_html( $row->new_only ); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php else: ?>
					<p><?php esc_html_e('No cron updates have been logged.', 'wp-action-network'); ?></p>
				<?php endif; else: ?>
					<p><?php esc_html_e('The cron log table does not exist.', 'wp-action-network'); ?></p>
				<?php endif; ?>
				
				<h3><?php esc_html_e('Information to Share for Support', 'wp-action-network'); ?></h3>
				<p><?php esc_html_e('If you need help with sync issues, copy the information below and share it with support:', 'wp-action-network'); ?></p>
				<textarea readonly style="width: 100%; height: 200px; font-family: monospace; font-size: 12px;"><?php
				echo esc_textarea( "Sync Status Information:\n" );
				echo esc_textarea( "=====================\n\n" );
				echo esc_textarea( "Queue Status: " . $queue_status . "\n" );
				echo esc_textarea( "Last Sync: " . ( $last_sync ? date_i18n( 'Y-m-d H:i:s', $last_sync ) : 'Never' ) . "\n" );
				echo esc_textarea( "Queue Total: " . $queue_total . "\n" );
				echo esc_textarea( "Queue Processed: " . $queue_processed . "\n" );
				echo esc_textarea( "Queue Unprocessed: " . $queue_unprocessed . "\n" );
				echo esc_textarea( "Show Sync Notice Flag: " . ( $show_sync_notice ? 'Yes' : 'No' ) . "\n" );
				if (!empty($deferred_notices)) {
					echo esc_textarea( "\nDeferred Notices:\n" );
					foreach ($deferred_notices as $key => $notice) {
						echo esc_textarea( "- " . $key . ": " . $notice . "\n" );
					}
				}
				echo esc_textarea( "\nWordPress Version: " . get_bloginfo('version') . "\n" );
				echo esc_textarea( "PHP Version: " . PHP_VERSION . "\n" );
				echo esc_textarea( "Plugin Version: " . ACTIONNETWORK_VERSION . "\n" );
				?></textarea>
				<p><button type="button" class="button" onclick="this.previousElementSibling.select(); document.execCommand('copy'); alert('Copied to clipboard!');"><?php esc_html_e('Copy to Clipboard', 'wp-action-network'); ?></button></p>
			</div>

			<?php /* options about */ ?>
			<div class="actionnetwork-admin-tab<?php echo ($tab == 'about') ? ' actionnetwork-admin-tab-active' : ''; ?>" id="actionnetwork-about">
				<h2><?php esc_html_e('About the Plugin', 'wp-action-network'); ?></h2>
				<p><a href="<?php echo esc_url( 'https://concertedaction.consulting' ); ?>" target="_blank"><img src="<?php echo esc_url( 'https://concertedaction.consulting/wp-content/uploads/2023/08/logo-red.svg' ); ?>" alt="<?php echo esc_attr( 'Concerted Action Logo' ); ?>" class="logo" /></a></p>
								<style type="text/css">
					#can-form-area-wordpress-plugin-users-list h2 {text-align: center; border-bottom: none !important;}
					#can-form-area-wordpress-plugin-users-list h4, #can-form-area-wordpress-plugin-users-list #action_info, #can-form-area-wordpress-plugin-users-list #d_sharing {display: none !important;}
				</style>
				<div style="width: 64%; float: left;"><p>This plugin is maintained by <a href="https://concertedaction.consulting/" target="_blank">Concerted Action</a> a one-stop consulting firm specializing in advocacy, organizing and the digital tools that power grassroots movements.</p>

				<p>Learn more about us on our <a href="https://concertedaction.consulting/" target="_blank">website</a>, <a href="https://www.facebook.com/concertedaction" target="_blank">Facebook</a>, <a href="https://twitter.com/ConcertedAct" target="_blank">Twitter</a> or <a href="https://www.linkedin.com/company/concertedaction" target="_blank">LinkedIn</a>.</p>
				<p>Sign up using the form to stay informed about future updates to the Action Network WordPress plugin, and have opportunities to provide feedback and make suggestions about the plugin's development roadmap.</p>

			</div>

				<div style="width: 35%; float: right;">
					<?php
					// Enqueue external Action Network stylesheet and script
					// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- External resource version controlled by Action Network
					wp_enqueue_style( 'actionnetwork-embed-whitelabel', 'https://actionnetwork.org/css/style-embed-whitelabel-v3.css', array(), null );
					// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- External resource version controlled by Action Network
					wp_enqueue_script( 'actionnetwork-widget-form', 'https://actionnetwork.org/widgets/v3/form/wordpress-plugin-users-list?format=js&source=widget', array(), null, false );
					?>
					<div id='can-form-area-wordpress-plugin-users-list' style='width: 100%'><!-- this div is the target for our HTML insertion --></div>
			</div>
			</div>
		</div> <!-- /.wrap-inner -->


	</div> <!-- /.wrap -->
	<?php
}

/**
 * Help for administrative page
 */
function actionnetwork_admin_add_help() {
	$screen = get_current_screen();
	
	$help = array(
		'actionnetwork-help-overview' => array(
			'title' => __( 'Overview', 'wp-action-network' ),
			'content' => __('
Manage your Action Network actions using the Wordpress backend. Supports sorting by title, type and last modified date, and provides a search function.

If you are an <a href="https://actionnetwork.org/partnerships">Action Network Partner</a>, use your API key to sync all of your actions from Action Network to Wordpress by entering it in the "Settings" tab. Actions are automatically synced from Action Network and can be used via shortcodes.
			', 'wp-action-network'),
		),
		
		'actionnetwork-help-shortcodes' => array(
			'title'    => __('Shortcodes and widgets', 'wp-action-network'),
			'content'  => __('
This plugin provides three shortcodes and four widgets:

The <code>[actionnetwork]</code> shortcode or Action Network Action widget displays a single Action Network action.

The <code>[actionnetwork_list]</code> shortcode or Action Network List widget displays a list of the titles of your most recently created Action Network actions, linked to those actions\'s URLs on actionnetwork.org

The <code>[actionnetwork_calendar]</code> shortcode or Action Network Calendar widget displays a list of upcoming Action Network events, linked to those actions\'s URLs on actionnetwork.org

The Action Network Signup widget provides a lightweight HTML form, optionally handled via AJAX, which allows site visitors to sign up for your Action Network list without using an Action Network javascript embed (requires API key).
', 'wp-action-network'),
		),
		
		'actionnetwork-help-shortcode-options' => array(
			'title'    => __( 'Action options', 'wp-action-network' ),
			'content'  => __('
The <code>id</code> attribute is required, to identify the action.

Use the <code>thank_you</code> and <code>help_us</code> options to modify the "Thank You for Your Support" and "help us using sharing tools" messages. Set <code>hide_social</code>, <code>hide_email</code>, or <code>hide_embed</code> options to <code>1</code> to hide specific sharing tools.

Shortcodes for actions synced via the API can take two additional attributes:

The <code>size</code> attribute can be set to <code>full</code> or <code>standard</code> (standard is the default)

The <code>style</code> attribute can be set to <code>default</code>, <code>layout_only</code>, or <code>no</code> (layout_only is the default)', 'wp-action-network'),
		),
	
		'actionnetwork-help-list-options' => array(
			'title'    => __( 'List options', 'wp-action-network' ),
			'content'  => __('
The [actionnetwork_list] shortcode or widgets will display a list of current actions, and can take the following attributes:

<code>n</code>: number of actions to list (defaults to five)
<code>action_types</code>: comma-separated list of types of actions to display. Defaults to <code>petition,advocacy_campaign,fundraising_page,form</code> (i.e., everything other than <code>event</code> and <code>ticketed_event</code>, which in most use cases would be handled by the <code>[actionnetwork_calendar]</code> shortcode & widgets - but it <em>can</em> handle events and ticketed events).
<code>link_format</code>: defaults to <code>{{ action.link }}</code> (i.e., the link to the action on actionnetwork.org) but could be modified, using {{ action.link }} or {{ action.id }}, to a custom URL.
<code>link_text</code>: defaults to <code>{{ action.title }}</code> (i.e., the public title of the action).
<code>container_element</code>: HTML element to wrap the list in. Defaults to <code>ul</code> to create an unordered list
<code>container_class</code>: Class to apply to container element. Defaults to <code>actionnetwork-list</code>
<code>item_element</code>: HTML element that contains each list item. Defaults to <code>li</code>.
<code>item_class</code>: Class to apply to list item element. Defaults to <code>actionnetwork-list-item</code>
<code>no_actions</code>: Text to display if there are no current actions. Defaults to "No current actions." Widget version can include HTML.
<code>no_actions_hide</code>: If set to 1, the shortcode/widget won\'t display at all if there are no current actions (especially useful for widgets)
<code>json</code>: If set to 1, will output as JSON rather than HTML (it is up to you to write script to use the JSON)', 'wp-action-network'),
		),
	
		'actionnetwork-help-calendar-options' => array(
			'title'    => __( 'Calendar options', 'wp-action-network' ),
			'content'  => __('
The [actionnetwork_calendar] shortcode or widget will display a list of upcoming events, and can take the following attributes:
			
<code>n</code>: number of events to list (defaults to all)
<code>date_format</code>: <a href="https://php.net/date">php date formatter</a> for date. Defaults to <code>F j, Y</code>.
<code>link_format</code>: defaults to <code>{{ event.link }}</code> (i.e., the link to the event on actionnetwork.org) but could be modified, using {{ event.link }} or {{ event.id }}, to a custom URL.
<code>link_text</code>: defaults to <code>{{ event.title }}</code> (i.e., the public title of the event).
<code>container_element</code>: HTML element to wrap the calendar in. Defaults to <code>ul</code> to create an unordered list
<code>container_class</code>: Class to apply to container element. Defaults to <code>actionnetwork-calendar</code>
<code>item_element</code>: HTML element that contains each list item. Defaults to <code>li</code>.
<code>item_class</code>: Class to apply to list item element. Defaults to <code>actionnetwork-calendar-item</code>
<code>no_events</code>: Text to display if there are no current events. Defaults to "No upcoming events." Widget version can include HTML.
<code>location</code>: Formatter for event location. Defaults to <code>&lt;div class="actionnetwork-calendar-location"&gt;{{ event.location }}&lt;/div&gt;</code>
<code>location</code>: Formatter for event description. Defaults to <code>&lt;div class="actionnetwork-calendar-description"&gt;{{ event.description }}&lt;/div&gt;</code>
<code>embed_style</code>: Embed style to use if the shortcode is displaying a single event. Defaults to <code>embed_standard_layout_only_styles</code>.
<code>ignore_url_id</code>: By default, the <code>[actionnetwork_calendar]</code> shortcode will display the full embed for a single event if that event\'s id is appended the the URL. If set to 1, this will be overridden.
<code>json</code>: If set to 1, will output as JSON rather than HTML (it is up to you to write script to use the JSON)', 'wp-action-network'),
		),
		
		'actionnetwork-help-signup-widget' => array(
			'title'    => __( 'Signup widget', 'wp-action-network' ),
			'content'  => __('
The signup widget, provides a lightweight non-Action-Network form which allows users to sign up for your list

The widget controls display checkboxes that allow you to add tags to anyone who signs up via the form (the tags need to be created in your Action Network backend).

If the "submit via <a href="https://en.wikipedia.org/wiki/Ajax_(programming)">AJAX</a>" option is checked, submissions are handled without a full page reload.

The CSS animations for AJAX submission are contained in the <code>signup.css</code> file. If the form is being submitted via ajax, the javascript in <code>signup.js</code> will add the <code>submitting</code> class to the form while it is being submitted and the <code>submitted</code> class when it has been submitted.

The javascript will also trigger custom javascript events on the <code>document</code> element: <code>actionnetwork_signup_submitted</code> when the form is submitted and <code>actionnetwork_signup_complete</code> when the submission is complete.', 'wp-action-network' ),
		),
	
		'actionnetwork-help-shortcode-template' => array(
			'title'    => __( 'List and calendar shortcode template', 'wp-action-network' ),
			'content'  => __('
The [actionnetwork_list] and [actionnetwork_calendar] shortcodes can be templated using a very simplified <a href="http://https//twig.symfony.com/">twig</a>-like format, by placing the template in between the opening and closing shortcodes. It <em>must</em> follow the following structure, because it doesn\'t actually use twig (yet):

<em>your container HTML...</em>
<code>{% for action in actions %}</code> <em>(for list)</em> OR <code>{% for event in events %}</code> <em>(for calendar)</em>
  <em>your iterated item HTML...</em>
<code>{% else %}</code>
  <em>your "no events" HTML...</em>
<code>{% endfor %}</code>
<em>your container-closing HTML...</em>

Twig variables available for <code>[actionnetwork_list]</code> are <code>{{ action.link }}</code>, <code>{{ action.id }}</code> and <code>{{ action.title }}</code>.

Twig variables available for <code>[actionnetwork_calendar]</code> are <code>{{ event.link }}</code>, <code>{{ event.id }}</code>, <code>{{ event.title }}</code>, <code>{{ event.date }}</code>, <code>{{ event.location }}</code>, and <code>{{ event.description }}</code>.

<code>{{ action.link }}</code> and <code>{{ event.link }}</code> are modified by the <code>link_format</code> attribute before being passed to the template. The <code>link_text</code> attribute is irrelevant if a custom template is used.', 'wp-action-network'),
		),
	
		'actionnetwork-help-ticketed-events' => array(
			'title'    => __( 'Ticketed Events', 'wp-action-network' ),
			'content'  => __('Ticketed events are not currently supported by Action Network\'s API, and so this plugin cannot sync them. Ticketed events are not available through this plugin.', 'wp-action-network'),
		),
	);
	
	foreach($help as $id => $tab) {
		$screen->add_help_tab( array(
			'id' => $id,
			'title' => $tab['title'],
			'content' => wpautop( $tab['content'] ),
		));
	}
	
}

// hooks your functions into the correct filters
function actionnetwork_add_mce_button() {

    global $wpdb;

    // check user permissions
    if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
        return;
    }

    global $wpdb;

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
    $results        = $wpdb->get_results ( "SELECT * FROM {$wpdb->prefix}actionnetwork WHERE enabled = '1'" );
    $results_array  = array();
    $results_count  = count( $results );
    $result_itr     = 0;

    if( $results ){
        foreach( $results as $result ){
            $result_itr++;
            $results_array[$result_itr] = array( $result->wp_id, $result->title ) ;
        }

    }

    $script_decode = wp_json_encode( $results_array );

    // phpcs:ignore Squiz.PHP.Heredoc.NotAllowed -- JavaScript code output, heredoc is appropriate
    $script = <<<EOF
   <script type = 'text/javascript'>
        var actionnetwork_shortcode = $script_decode;
   </script>
EOF;
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JavaScript code intentionally output
    echo $script;

    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'actionnetwork_add_tinymce_plugin', 22, 1 );
        add_filter( 'mce_buttons', 'actionnetwork_register_mce_button' );
    }
}
add_action('admin_head', 'actionnetwork_add_mce_button');

// register new button in the editor
function actionnetwork_register_mce_button( $buttons ) {
    array_push( $buttons, 'wdm_mce_button' );
    return $buttons;
}


// declare a script for the new button
// the script will insert the shortcode on the click event
function actionnetwork_add_tinymce_plugin( $plugin_array ) {

    $plugin_array['wdm_mce_button'] =  plugin_dir_url( __FILE__ ). 'admin-wsywyg.js';
    return $plugin_array;

}

function actionnetwork_register_blocks() {

	// Check if Gutenberg is active.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Add block script.
	wp_register_script(
		'embed-action-network',
		plugins_url( 'blocks/block.js', __FILE__ ),
		[ 'wp-blocks', 'wp-element', 'wp-editor' ],
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks/block.js' ),
		true
	);

	// Add block style.
	wp_register_style(
		'embed-action-network',
		plugins_url( 'blocks/block.css', __FILE__ ),
		[],
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks/block.css' )
	);

	wp_localize_script('embed-action-network', 'WPURLS', array( 'siteurl' => get_option('siteurl') ));

	// Register block script and style.
	register_block_type( 'actionnetwork/embed-action-network', [
		'style' => 'embed-action-network', // Loads both on editor and frontend.
		'editor_script' => 'embed-action-network', // Loads only on editor.
	] );
}

add_action( 'init', 'actionnetwork_register_blocks' );

add_action( 'wp_ajax_nopriv_getActionNetworks', 'actionnetwork_get_action_networks' );
add_action( 'wp_ajax_getActionNetworks', 'actionnetwork_get_action_networks' );

if ( ! function_exists( 'actionnetwork_get_action_networks' ) ) {
	function actionnetwork_get_action_networks() {
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$results        = $wpdb->get_results ( "SELECT * FROM {$wpdb->prefix}actionnetwork WHERE enabled = '1'" );
		$results_array  = array();

		if( !empty($results) ){
			foreach( $results as $result ){
				$results_array[] = array(
					'id' 	=>	$result->wp_id,
					'title'	=>	$result->title
				);
			}
		}

		$result = wp_json_encode( $results_array );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON output for AJAX response
		echo $result;
		wp_die();
	}
}