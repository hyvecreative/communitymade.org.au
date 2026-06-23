<?php
	
class Actionnetwork_Sync extends ActionNetwork {
	
	public $updated = 0;
	public $inserted = 0;
	public $deleted = 0;
	private $nestingLevel = 0;
	private $endpoints = array( 'petitions', 'events', 'fundraising_pages', 'advocacy_campaigns', 'forms' );
	
	function __construct() {
		$api_key = get_option( 'actionnetwork_api_key' );
		parent::__construct( $api_key );
	}
	
	function init() {
		global $wpdb;

		// error_log( "Actionnetwork_Sync::init called", 0 );

		try {
			// mark all existing API-synced actions for deletion
			// (any that are still synced will be un-marked)
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->query("UPDATE {$wpdb->prefix}actionnetwork SET enabled=-1 WHERE an_id != ''");
			
			// load actions from Action Network into the queue
			foreach ($this->endpoints as $endpoint) {
				try {
					$this->traverseFullCollection( $endpoint, 'addToQueue' );
				} catch (Exception $e) {
					// Log error for this endpoint but continue with others
					if (defined('WP_DEBUG') && WP_DEBUG) {
						error_log('Action Network sync error loading endpoint ' . $endpoint . ': ' . $e->getMessage());
					}
				} catch (Error $e) {
					// Log fatal errors
					if (defined('WP_DEBUG') && WP_DEBUG) {
						error_log('Action Network sync fatal error loading endpoint ' . $endpoint . ': ' . $e->getMessage());
					}
				}
			}
		} catch (Exception $e) {
			// Log initialization errors
			if (defined('WP_DEBUG') && WP_DEBUG) {
				error_log('Action Network sync initialization error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
			}
			throw $e; // Re-throw to let caller handle it
		} catch (Error $e) {
			// Log fatal errors
			if (defined('WP_DEBUG') && WP_DEBUG) {
				error_log('Action Network sync initialization fatal error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
			}
			throw $e; // Re-throw to let caller handle it
		}

	}
	
	function addToQueue( $resource, $endpoint, $index, $total ) {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$wpdb->insert(
			$wpdb->prefix.'actionnetwork_queue',
			array (
				'resource' => serialize($resource),
				'endpoint' => $endpoint,
				'processed' => 0,
			)
		);

		// error_log( "Actionnetwork_Sync::addToQueue called; endpoint: $endpoint, index: $index, total: $total", 0 );
	}
	
	function getQueueStatus() {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$total = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."actionnetwork_queue");
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$processed = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."actionnetwork_queue WHERE processed = 1");
		if ($total == 0) {
			$status = 'empty';
		} elseif ($total && ($total == $processed)) {
			$status = 'complete';
		} else {
			$status = 'processing';
		}
		
		update_option( 'actionnetwork_queue_status', $status );
		
		return array(
			'status' => $status,
			'total' => $total,
			'updated' => $this->updated,
			'inserted' => $this->inserted,
			'processed' => $processed,
		);
	}
	
	function processQueue() {
		$status = $this->getQueueStatus();

		if ($status['status'] == 'empty') { return; }
		if ($status['status'] == 'complete') {
			$this->cleanUp();
			return;
		}
		
		$this->processResource();
		
		$this->nestingLevel++;
		if ($this->nestingLevel > 100) { return; }
		$this->processQueue();
	}
	
	function processResource() {
		global $wpdb;
		
		try {
			// get a resource out of the database
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$result = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."actionnetwork_queue WHERE processed = 0 LIMIT 0,1", ARRAY_A );
			
			// If no resource found, return early
			if (!$result) {
				return;
			}
			
			$resource = unserialize($result['resource']);
			$resource_id = $result['resource_id'];
			$endpoint = $result['endpoint'];
			
			$data = array();
			
			// load an_id, created_date, modified_date, name, title, start_date into $data
			$data['an_id'] = $this->getResourceId($resource);
			$data['created_date'] = isset($resource->created_date) ? strtotime($resource->created_date) : null;
			$data['modified_date'] = isset($resource->modified_date) ? strtotime($resource->modified_date) : null;
			$data['start_date'] = isset($resource->start_date) ? strtotime($resource->start_date) : null;
			$data['browser_url'] = isset($resource->browser_url) ? $resource->browser_url : '';
			$data['title'] = isset($resource->title) ? $resource->title : '';
			$data['name'] = isset($resource->name) ? $resource->name : '';
			$data['description'] = isset($resource->description) ? $resource->description : '';
			$data['location'] = isset($resource->location) ? serialize($resource->location) : '';
		
			// set $data['enabled'] to 0 if:
			// * action_network:hidden is true
			// * status is "cancelled"
			// * event has a start_date that is past
			$data['enabled'] = 1;
			if (isset($resource->{'action_network:hidden'}) && ($resource->{'action_network:hidden'} == true)) {
				$data['enabled'] = 0;
			}
			if (isset($resource->status) && ($resource->status == 'cancelled')) {
				$data['enabled'] = 0;
			}
			if ($data['start_date'] && ($data['start_date'] < (int) current_time('timestamp'))) {
				$data['enabled'] = 0;
			}
		
			// use endpoint (minus pluralizing s) to set $data['type']
			$data['type'] = substr($endpoint,0,strlen($endpoint) - 1);

			// check if action exists in database
			// if it does, we don't need to get embed codes, because those never change
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$count = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}actionnetwork WHERE an_id=%s", $data['an_id']) );
			if ($count) {
				// if modified_date is more recent than latest api sync, update
				$last_updated = get_option('actionnetwork_cache_timestamp', 0);
				if ($last_updated < $data['modified_date']) {
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
					$wpdb->update(
						$wpdb->prefix.'actionnetwork',
						$data,
						array( 'an_id' => $data['an_id'] )
					);
					$this->updated++;
				
				// otherwise just reset the 'enabled' field (to prevent deletion, and hide events whose start date has passed)
				} else {
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
					$wpdb->update(
						$wpdb->prefix.'actionnetwork',
						array( 'enabled' => $data['enabled'] ),
						array( 'an_id' => $data['an_id'] )
					);
				}

			} else {
				// if action *doesn't* exist in the database, get embed codes, insert
				$embed_codes = $this->getEmbedCodes($resource, true);
				$data = array_merge($data, $this->cleanEmbedCodes($embed_codes));
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
				$wpdb->insert(
					$wpdb->prefix.'actionnetwork',
					$data
				);
				$this->inserted++;
			}

			// mark resource as processed
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->update(
				$wpdb->prefix.'actionnetwork_queue',
				array( 'processed' => 1 ),
				array( 'resource_id' => $resource_id )
			);
		} catch (Exception $e) {
			// Log error but continue processing other resources
			if (defined('WP_DEBUG') && WP_DEBUG) {
				error_log('Action Network sync error processing resource: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
			}
			// Mark resource as processed even on error to prevent infinite loop
			if (isset($resource_id)) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->update(
					$wpdb->prefix.'actionnetwork_queue',
					array( 'processed' => 1 ),
					array( 'resource_id' => $resource_id )
				);
			}
		} catch (Error $e) {
			// Log fatal errors
			if (defined('WP_DEBUG') && WP_DEBUG) {
				error_log('Action Network sync fatal error processing resource: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
			}
			// Mark resource as processed even on error to prevent infinite loop
			if (isset($resource_id)) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->update(
					$wpdb->prefix.'actionnetwork_queue',
					array( 'processed' => 1 ),
					array( 'resource_id' => $resource_id )
				);
			}
		}
	}
	
	function cleanEmbedCodes($embed_codes_raw) {
		$embed_fields = array(
			'embed_standard_layout_only_styles',
			'embed_full_layout_only_styles',
			'embed_standard_no_styles',
			'embed_full_no_styles',
			'embed_standard_default_styles',
			'embed_full_default_styles',
		);
		foreach ($embed_fields as $embed_field) {
			$embed_codes[$embed_field] = isset($embed_codes_raw[$embed_field]) ? $embed_codes_raw[$embed_field] : '';
		}
		return $embed_codes;
	}
	
	function cleanUp() {
		global $wpdb;
		
		// clear the process queue
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query("DELETE FROM {$wpdb->prefix}actionnetwork_queue WHERE processed = 1");
		
		// remove all API-synced action that are still marked for deletion
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$this->deleted = $wpdb->query("DELETE FROM {$wpdb->prefix}actionnetwork WHERE an_id != '' AND enabled=-1");
		
		// update queue status and cache timestamps options
		update_option( 'actionnetwork_queue_status', 'empty' );
		update_option( 'actionnetwork_cache_timestamp', (int) current_time('timestamp') );
		
		// Store sync stats for display on sync status page
		update_option('actionnetwork_last_sync_inserted', $this->inserted);
		update_option('actionnetwork_last_sync_updated', $this->updated);
		update_option('actionnetwork_last_sync_deleted', $this->deleted);
		
		// set an admin notice
		$notices = get_option('actionnetwork_deferred_admin_notices', array());
		$notices['api_sync_completed'] = sprintf( 'Action Network API Sync Completed. %d actions inserted. %d actions updated. %s actions deleted.', $this->inserted, $this->updated, $this->deleted );
		update_option('actionnetwork_deferred_admin_notices', $notices);
	}
	
}
