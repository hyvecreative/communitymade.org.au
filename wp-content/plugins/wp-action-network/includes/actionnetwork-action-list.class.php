<?php
/**
 * Create WP_List_Table for actions
 *
 * phpcs:disable PluginCheck.Security.DirectDB.UnescapedDBParameter -- WHERE clause fragments contain prepared statement placeholders that are safely escaped via wpdb::prepare()
 * phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- WHERE clause fragments are pre-prepared placeholders
 * phpcs:disable WordPress.DB.PreparedSQLPlaceholders.UnfinishedPrepare -- Using spread operator with variable parameter counts
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Actionnetwork_Action_List extends WP_List_Table {

	// Notices
	public $notices = array();
	public $action_types = array();
	public $action_type_plurals = array();

	// Class constructor
	function __construct() {

		parent::__construct( array(
			'singular' => __( 'Action', 'wp-action-network' ),
			'plural' => __( 'Actions', 'wp-action-network' ),
			'ajax' => false,
		) );

		$this->notices = array(
			'error' => array(),
			'updated' => array(),
		);

		$this->action_types = array(
			'petition' => __( 'Petition', 'wp-action-network' ),
			'advocacy_campaign' => __( 'Letter', 'wp-action-network' ),
			'event' => __( 'Event', 'wp-action-network' ),
			'ticketed_event' => __( 'Ticketed Event', 'wp-action-network' ),
			'fundraising_page' => __( 'Fundraiser', 'wp-action-network' ),
			'form' => __( 'Form', 'wp-action-network' ),
		);
		$this->action_type_plurals = array(
			'petition' => __( 'Petitions', 'wp-action-network' ),
			'advocacy_campaign' => __( 'Letters', 'wp-action-network' ),
			'event' => __( 'Events', 'wp-action-network' ),
			'ticketed_event' => __( 'Ticketed Events', 'wp-action-network' ),
			'fundraising_page' => __( 'Fundraisers', 'wp-action-network' ),
			'form' => __( 'Forms', 'wp-action-network' ),
		);

	}

	function get_columns() {

		$columns = array(
			'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			'title' => __( 'Title', 'wp-action-network' ),
			'type' => __( 'Type', 'wp-action-network' ),
			'modified_date' => __( 'Modified', 'wp-action-network' ),
			'shortcode' => __( 'Shortcode', 'wp-action-network' ),
		);

		if (get_option( 'actionnetwork_api_key', null )) {
			$columns['meta'] = __( 'Meta Information', 'wp-action-network' );
		}

		return $columns;
	}

    function get_sortable_columns() {
   	    $sortable_columns = array(
   	        'title'    => array('title',false),
   	        'type'     => array('type',false),
   	        'modified_date' => array('modified_date',true),
		);
        return $sortable_columns;
    }

	function single_row($item) {
		$show = $item['enabled'] && !$item['hidden'];
		echo '<tr class="actionnetwork-action-' . ($show ? 'enabled' : 'hidden') . '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

    function column_default($item, $column_name){
        switch($column_name){

			case 'type':
                return $this->action_types[$item[$column_name]];
			break;
			
			case 'modified_date':
				return $item[$column_name] ? date_i18n('n/j/Y g:ia', $item[$column_name]) : '';
			break;

            default:
                // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- Debug code for troubleshooting
                return print_r($item,true); //Show the whole array for troubleshooting purposes
			break;
        }
    }

    function column_cb($item){
		// we disable this for items which have an action network ID,
		// because they are controlled by the Action Network backend
		// and synced via API
        return sprintf(
            '<input type="checkbox" name="bulk-action[]" value="%1$s" %2$s/>',
            $item['wp_id'],
			$item['an_id'] ? 'class="actionnetwork-synced" title="'.__( 'Cannot bulk delete actions synced via API', 'wp-action-network' ).'" ' : ''
        );
    }

	function column_title($item) {
		if ($item['name'] && ($item['name'] != $item['title'])) {
			$title = $item['name'] . ' <div class="public-title"><span>' . __('Public Title', 'wp-action-network') . ':</span><br />'.$item['title'].'</div>';
		} else {
			$title = $item['title'];
		}
		$show = $item['enabled'] && !$item['hidden'];
		if (!$show) {
			$title = '<span class="dashicons dashicons-hidden" title="'.__('This action is hidden', 'wp-action-network').'"></span> '.$title;
		}
		return $title;
	}

	function column_shortcode($item) {
		$shortcode = "[actionnetwork id={$item['wp_id']}]";
		$__copy = __( 'Copy', 'wp-action-network' );
		$__options = __( 'Options', 'wp-action-network' );
		// phpcs:ignore Squiz.PHP.Heredoc.NotAllowed -- HTML with variables, heredoc is most readable
		$shortcode_html = <<<EOHTML
<div class="copy-wrapper">
<input type="text" class="copy-text" readonly="readonly" id="shortcode-{$item['wp_id']}" value="$shortcode" /><button data-copytarget="#shortcode-{$item['wp_id']}" class="copy">$__copy</button>
</div>
EOHTML;
		if ($item['an_id']) {
			$shortcode_html .= '<div class="shortcode-options-link"><a href="#" class="shortcode-options-toggle" data-wp-id="' . esc_attr($item['wp_id']) . '">' . $__options . '</a></div>';
			$shortcode_html .= '<div class="shortcode-options-editor" id="shortcode-options-editor-'.$item['wp_id'].'" style="display:none;">';
			$shortcode_html .= '<div class="shortcode-options-fields">';
			$shortcode_html .= '<label>' . __('Size:', 'wp-action-network') . ' <select class="shortcode-option-size" data-wp-id="' . esc_attr($item['wp_id']) . '"><option value="standard">' . __('Standard', 'wp-action-network') . '</option><option value="full">' . __('Full', 'wp-action-network') . '</option></select></label>';
			$shortcode_html .= '<label>' . __('Style:', 'wp-action-network') . ' <select class="shortcode-option-style" data-wp-id="' . esc_attr($item['wp_id']) . '"><option value="default">' . __('Default', 'wp-action-network') . '</option><option value="layout_only" selected>' . __('Layout Only', 'wp-action-network') . '</option><option value="no">' . __('No', 'wp-action-network') . '</option></select></label>';
			$shortcode_html .= '</div>';
			$shortcode_html .= '</div>';
		}
		return $shortcode_html;
	}

	function column_meta($item) {
		$info = '';
		if ($item['start_date']) {
			$info .= '<div><span class="dashicons dashicons-calendar"></span> ' . esc_html( date_i18n('n/j/Y g:ia', $item['start_date']) ) . '</div>';
		}
		if ($item['browser_url']) {
			$info .= '<div><a href="' . $item['browser_url'] . '" target="_blank"><span class="dashicons dashicons-external"></span> ' . __( 'View action', 'wp-action-network' ) . '</a></div>';
			$info .= '<div><a href="' . $item['browser_url'] . '/manage" target="_blank"><span class="dashicons dashicons-admin-tools"></span> ' . __( 'Manage action', 'wp-action-network' ) . '</a></div>';
		}
		$source = $item['an_id'] ? 'API' : __( 'User', 'wp-action-network' );
		$source_icon = $item['an_id'] ? '<img class="icon" src="'.plugins_url('../icon-action-network.png', __FILE__).'" /> ' : '<span class="dashicons dashicons-admin-users"></span> ';
		$info .= '<div>' . $source_icon . __('Source', 'wp-action-network') . ': '. $source . '</div>';
		if ($source != 'API' && (($item['type'] == 'event') || ($item['type'] == 'ticketed_event'))) {
			$info .= '<div><a href="';
			$info .= wp_nonce_url(
				admin_url('admin.php?page=wp-action-network&actionnetwork_admin_action=edit_event&actionnetwork_event_wp_id='.$item['wp_id']),
				'actionnetwork_edit_event',
				'actionnetwork_nonce_field'
			);
			$info .='"><span class="dashicons dashicons-edit"></span> '.__('Edit event','wp-action-network').'</a></div>';
		}
/*
		if ($item['created_date']) {
			$info .= '<div>' . esc_html( __('Created','wp-action-network') ) . ': ' . esc_html( date_i18n('n/j/Y', $item['created_date']) ) . '</div>';
		}
*/
		return $info;
	}

	function filter_sql() {
		global $wpdb;

		$filter_fragments = array();
		$params = array();

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
		if ( ! empty( $_GET['type'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
			$type = sanitize_text_field( wp_unslash( $_GET['type'] ) );

			if ( array_key_exists( $type, $this->action_types ) ) {
				$filter_fragments[] = 'type = %s';
				$params[] = $type;
			}
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
		if ( ! empty( $_GET['source'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
			$source = sanitize_text_field( wp_unslash( $_GET['source'] ) );

			if ( 'user' === $source ) {
				$filter_fragments[] = "an_id = ''";
			} elseif ( 'api' === $source ) {
				$filter_fragments[] = "an_id != ''";
			}
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
		if ( ! empty( $_GET['search'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
			$search = sanitize_text_field( wp_unslash( $_GET['search'] ) );
			$like = '%' . $wpdb->esc_like( $search ) . '%';
			$filter_fragments[] = '( (title LIKE %s) OR (name LIKE %s) )';
			$params[] = $like;
			$params[] = $like;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
		if ( empty( $_GET['show_hidden'] ) ) {
			$filter_fragments[] = 'enabled = %d';
			$params[] = 1;
			$filter_fragments[] = 'hidden = %d';
			$params[] = 0;
		}

		return array( $filter_fragments, $params );
	}

	function get_actions( $per_page = 20, $page_number = 1 ) {

		global $wpdb;
		list( $where_fragments, $where_params ) = self::filter_sql();

		$per_page = max( 1, absint( $per_page ) );
		$offset = absint( ( $page_number - 1 ) * $per_page );

		// Determine sort order with strict whitelisting
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Sort parameters are display-only, no data modification
		$orderby_param = ! empty( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : '';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Sort parameters are display-only, no data modification
		$order_param = ! empty( $_GET['order'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_GET['order'] ) ) ) : '';

		// Build complete queries with hardcoded ORDER BY combinations
		if ( $where_fragments ) {
			$where_sql = ' WHERE ' . implode( ' AND ', $where_fragments );
			$all_params = array_merge( $where_params, array( $per_page, $offset ) );
			
		// Switch on exact ORDER BY combinations
		if ( 'title' === $orderby_param && 'DESC' === $order_param ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork{$where_sql} ORDER BY title DESC LIMIT %d OFFSET %d", ...$all_params ), 'ARRAY_A' );
		} elseif ( 'title' === $orderby_param ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork{$where_sql} ORDER BY title ASC LIMIT %d OFFSET %d", ...$all_params ), 'ARRAY_A' );
		} elseif ( 'type' === $orderby_param && 'DESC' === $order_param ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork{$where_sql} ORDER BY type DESC LIMIT %d OFFSET %d", ...$all_params ), 'ARRAY_A' );
		} elseif ( 'type' === $orderby_param ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork{$where_sql} ORDER BY type ASC LIMIT %d OFFSET %d", ...$all_params ), 'ARRAY_A' );
		} elseif ( 'modified_date' === $orderby_param && 'ASC' === $order_param ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork{$where_sql} ORDER BY modified_date ASC LIMIT %d OFFSET %d", ...$all_params ), 'ARRAY_A' );
		} else {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork{$where_sql} ORDER BY modified_date DESC LIMIT %d OFFSET %d", ...$all_params ), 'ARRAY_A' );
		}
		} else {
			// Switch on exact ORDER BY combinations for no-filter queries
			if ( 'title' === $orderby_param && 'DESC' === $order_param ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Prepared statement, whitelisted sort
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork ORDER BY title DESC LIMIT %d OFFSET %d", $per_page, $offset ), 'ARRAY_A' );
			} elseif ( 'title' === $orderby_param ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Prepared statement, whitelisted sort
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork ORDER BY title ASC LIMIT %d OFFSET %d", $per_page, $offset ), 'ARRAY_A' );
			} elseif ( 'type' === $orderby_param && 'DESC' === $order_param ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Prepared statement, whitelisted sort
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork ORDER BY type DESC LIMIT %d OFFSET %d", $per_page, $offset ), 'ARRAY_A' );
			} elseif ( 'type' === $orderby_param ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Prepared statement, whitelisted sort
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork ORDER BY type ASC LIMIT %d OFFSET %d", $per_page, $offset ), 'ARRAY_A' );
			} elseif ( 'modified_date' === $orderby_param && 'ASC' === $order_param ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Prepared statement, whitelisted sort
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork ORDER BY modified_date ASC LIMIT %d OFFSET %d", $per_page, $offset ), 'ARRAY_A' );
			} else {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Prepared statement, whitelisted sort
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}actionnetwork ORDER BY modified_date DESC LIMIT %d OFFSET %d", $per_page, $offset ), 'ARRAY_A' );
			}
		}

		return $result;
	}

	function record_count() {
		global $wpdb;
		list( $where_fragments, $where_params ) = self::filter_sql();

	if ( $where_fragments ) {
		$where_clause = ' WHERE ' . implode( ' AND ', $where_fragments );
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber,WordPress.DB.PreparedSQLPlaceholders.UnfinishedPrepare -- WHERE clause contains prepared placeholders, spread operator used for variable parameter count
		return $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->prefix}actionnetwork{$where_clause}",
				...$where_params
			)
		);
	}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Static query with no user input
		return $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}actionnetwork" );
	}

	function delete_action( $wp_id ) {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->delete(
			"{$wpdb->prefix}actionnetwork",
			array( 'wp_id' => $wp_id ),
			array( '%d' )
		);
	}

	function hide_action( $wp_id ) {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->update(
			"{$wpdb->prefix}actionnetwork",
			array( 'hidden' => 1 ),
			array( 'wp_id' => $wp_id ),
			array( '%d' ),
			array( '%d' )
		);
	}

	function unhide_action( $wp_id ) {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->update(
			"{$wpdb->prefix}actionnetwork",
			array( 'hidden' => 0 ),
			array( 'wp_id' => $wp_id ),
			array( '%d' ),
			array( '%d' )
		);
	}

	function no_items() {
		esc_html_e( 'No actions available', 'wp-action-network' );
	}

    function get_bulk_actions() {
        $actions = array(
            'delete'    => __( 'Delete', 'wp-action-network' ),
            'hide'    => __( 'Hide', 'wp-action-network' ),
            'unhide'    => __( 'Unhide', 'wp-action-network' ),
        );
        return $actions;
    }

    function process_bulk_action() {
	    global $wpdb;
        
        if( 'delete'===$this->current_action() ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Bulk actions handled by WP_List_Table
			$delete_wp_ids = isset( $_REQUEST['bulk-action'] ) ? array_map( 'absint', wp_unslash( $_REQUEST['bulk-action'] ) ) : array();
			$deleted_actions = 0;
			$cannot_delete_synced_actions = 0;
			foreach ( $delete_wp_ids as $wp_id ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				if ($wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `{$wpdb->prefix}actionnetwork` WHERE an_id='' AND wp_id=%d", $wp_id))) {
					self::delete_action( $wp_id );
					$deleted_actions++;
				} else {
					$cannot_delete_synced_actions++;
				}
			}
			if ($cannot_delete_synced_actions) {
				$this->notices['error'][] = sprintf(
					/* translators: %d is number of actions that could not be deleted because they were synced from API */
					__('%d actions could not be deleted because they were synced via API', 'wp-action-network'),
					$cannot_delete_synced_actions);
			}
			if ($deleted_actions) {
				$this->notices['updated'][] = sprintf(
					/* translators: %d is number of actions successfully deleted */
					__('%d actions deleted', 'wp-action-network'),
					$deleted_actions);
			}
        }
        
        if( 'hide'===$this->current_action() ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Bulk actions handled by WP_List_Table
			$hide_wp_ids = isset( $_REQUEST['bulk-action'] ) ? array_map( 'absint', wp_unslash( $_REQUEST['bulk-action'] ) ) : array();
			foreach ( $hide_wp_ids as $wp_id ) {
				self::hide_action( $wp_id );
			}
			$this->notices['updated'][] = __('Actions hidden', 'wp-action-network');
        }
        
        if( 'unhide'===$this->current_action() ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Bulk actions handled by WP_List_Table
			$unhide_wp_ids = isset( $_REQUEST['bulk-action'] ) ? array_map( 'absint', wp_unslash( $_REQUEST['bulk-action'] ) ) : array();
			$cannot_unhide_synced_disabled_actions = 0;
			$unhidden_actions = 0;
			foreach ( $unhide_wp_ids as $wp_id ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				if ($wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `{$wpdb->prefix}actionnetwork` WHERE an_id != '' AND enabled=0 AND wp_id=%d", $wp_id))) {
					$cannot_unhide_synced_disabled_actions++;
				} else {
					self::unhide_action( $wp_id );
					$unhidden_actions++;
				}
			}
			if ($cannot_unhide_synced_disabled_actions) {
				$this->notices['updated'][] = sprintf(
					/* translators: %d is the number of actions which could not be unhidden */
					__('%d actions could not be unhidden because they are synced via API and have passed or are disabled in Action Network', 'wp-action-network'), $cannot_unhide_synced_disabled_actions);
			}
			if ($unhidden_actions) {
				$this->notices['updated'][] = sprintf(
					/* translators: %d is the number of actions unhidden */
					__('%d actions unhidden', 'wp-action-network'), $unhidden_actions);
			}
        }
        
    }

	function extra_tablenav( $which ) {

		global $wpdb;

		if ( $which == 'top' ) {

			$type_options = '';
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
			$type = isset($_GET['type']) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : '';
			foreach ($this->action_type_plurals as $key => $plural) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Using prepare() with placeholder
				$count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}actionnetwork WHERE type= %s", $key) );
				$type_options .= "<option value=\"".esc_attr($key)."\"";
				$type_options .= selected( $type, $key, false );
				$type_options .= disabled( ($count == 0), true, false );
				$type_options .= ">".esc_html($plural)."</option>\n";
			}

			?>
			<div class="alignleft actions">
				<label for="actionnetwork-filter-by-type" class="screen-reader-text"><?php esc_html_e('Filter by type', 'wp-action-network'); ?></label>
				<select name="type" id="actionnetwork-filter-by-type">
					<option value=""><?php esc_html_e('All Types', 'wp-action-network'); ?></option>
					<?php 
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Options are already escaped with esc_attr() and esc_html()
					echo $type_options; 
					?>
				</select>
				<?php if ( get_option( 'actionnetwork_api_key', null ) ):
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
					$source = isset($_GET['source']) ? sanitize_text_field( wp_unslash( $_GET['source'] ) ) : '';
				?>
				<label for="actionnetwork-filter-by-source" class="screen-reader-text"><?php esc_html_e('Filter by source', 'wp-action-network'); ?></label>
				<select name="source" id="actionnetwork-filter-by-source">
					<option value=""><?php esc_html_e('All Sources', 'wp-action-network'); ?></option>
					<option value="user"<?php selected( $source, 'user' ); ?>><?php esc_html_e('User', 'wp-action-network'); ?></option>
					<option value="api"<?php selected( $source, 'api' ); ?>>API</option>
				</select>
				<?php endif; ?>
				
				<label for="actionnetwork-show-hidden" class="checkbox-label">
					<?php
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Filter parameters are display-only, no data modification
					$show_hidden = isset($_GET['show_hidden']) ? absint( wp_unslash( $_GET['show_hidden'] ) ) : 0;
					?>
					<input type="checkbox" id="actionnetwork-show-hidden" name="show_hidden" value="1" <?php checked( $show_hidden, 1 ); ?> />
					<?php esc_html_e( 'Show hidden', 'wp-action-network' ); ?>
				</label>

				<input type="submit" name="filter_action" id="actionnetwork-filter-submit" class="button" value="<?php esc_attr_e('Filter', 'wp-action-network'); ?>">
			</div>
			<?php

		}

	}

	function prepare_items() {

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

		// process bulk action
		$this->process_bulk_action();

		$per_page = $this->get_items_per_page( 'actions_per_page', 20 );
		$current_page = $this->get_pagenum();
		$total_items = self::record_count();

		$this->set_pagination_args(array(
			'total_items' => $total_items,
			'per_page' => $per_page,
		));

		$this->items = self::get_actions( $per_page, $current_page );
	}

}
