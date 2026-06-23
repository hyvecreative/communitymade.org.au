jQuery(document).ready(function($){

	/**
	 * Admin tabs
	 */
	 
	 if (jQuery(window.location.hash).hasClass('actionnetwork-admin-tab')) {
		$('.wrap .nav-tab-wrapper .nav-tab-active').removeClass('nav-tab-active');
		$('.wrap .nav-tab-wrapper .nav-tab[href="'+window.location.hash+'"]').addClass('nav-tab-active');
	}
	
	if (!$('.wrap .nav-tab-wrapper .nav-tab-active').length) {
		$('.wrap .nav-tab-wrapper .nav-tab:eq(0)').addClass('nav-tab-active');
	}

	var currentTab = $('.wrap .nav-tab-wrapper .nav-tab-active').attr('href');
	$(currentTab).show();

	$('.wrap .nav-tab-wrapper .nav-tab, .wrap h1 .page-title-action').click(function(event){
		var showTab = $(this).attr('href');
		$('.wrap .nav-tab-wrapper .nav-tab-active').removeClass('nav-tab-active');
		if ($(this).hasClass('nav-tab')) {
			$(this).addClass('nav-tab-active');
		} else {
			$('.wrap .nav-tab-wrapper .nav-tab[href="'+showTab+'"]').addClass('nav-tab-active');
		}
		if ($(showTab).length && $(showTab).hasClass('actionnetwork-admin-tab')) {
			event.preventDefault();
			$('.actionnetwork-admin-tab').hide();
			$(showTab).show();
			window.location.hash = '';
		}
	});
	
	/**
	 * Form validation
	 */
	
	$('form .error').focus(function(){
		$(this).removeClass('error');
	});

	/**
	 * Copy to clipboard
	 */
	$('button.copy').click(function(event){
		event.preventDefault();
		var $self = $(this);
		var $input = $($self.attr('data-copytarget'));
		if ($input.length && ( $input.is('input') || $input.is('textarea') ) ) {
			$input.select();
			try {
				// copy text
				document.execCommand('copy');
				var copyText = $self.text();
				$self.addClass('copied').text(actionnetworkText.copied);
				setTimeout(function() { $self.removeClass('copied').text(copyText); }, 400);
				$input.blur();
			}
			catch (err) {
				alert(actionnetworkText.pressCtrlCToCopy);
			}
		}
	});

	/**
	 * Append clear search results link to search results subtitle
	 */
	$('.search-results-title').append(' (<a class="search-results-clear" href="#">'+actionnetworkText.clearResults+'</a>)');
	$('a.search-results-clear').click(function(event){
		event.preventDefault();
		$('#action-search-input').val('');
		$('#actionnetwork-actions-filter').submit();
	});

	/**
	 * Toggle "Add Action" form
	 */
	$('#actionnetwork-toggle-add-form').click(function(event){
		event.preventDefault();
		$('#actionnetwork-add-action-form').slideToggle(300);
	});
	
	$('#actionnetwork-cancel-add-form').click(function(event){
		event.preventDefault();
		$('#actionnetwork-add-action-form').slideUp(300);
		// Clear form fields
		$('#actionnetwork_add_embed_title').val('');
		$('#actionnetwork_add_embed_date').val('');
		$('#actionnetwork_add_embed_code').val('');
		$('#actionnetwork_add_location').val('');
		// Remove error classes
		$('#actionnetwork-add-action-form .error').removeClass('error');
	});
	
	// If there are errors in the add action form, show it automatically
	if ($('#actionnetwork-add-action-form .error').length) {
		$('#actionnetwork-add-action-form').show();
	}

	/**
	 * Inline shortcode options editor
	 */
	$('#shortcode-options').hide();
	$('.shortcode-options-toggle').click(function(event){
		event.preventDefault();
		var $toggle = $(this);
		var wpId = $toggle.data('wp-id');
		var $editor = $('#shortcode-options-editor-' + wpId);
		var $allEditors = $('.shortcode-options-editor');
		
		// Close all other editors
		$allEditors.not($editor).slideUp(200);
		$('.shortcode-options-toggle').not($toggle).removeClass('active');
		
		// Toggle this editor
		$editor.slideToggle(200);
		$toggle.toggleClass('active');
	});
	
	// Update shortcode when options change
	$('.shortcode-option-size, .shortcode-option-style').change(function(){
		var $select = $(this);
		var wpId = $select.data('wp-id');
		var $input = $('#shortcode-' + wpId);
		var size = $('#shortcode-options-editor-' + wpId + ' .shortcode-option-size').val();
		var style = $('#shortcode-options-editor-' + wpId + ' .shortcode-option-style').val();
		
		// Build shortcode
		var shortcode = '[actionnetwork id=' + wpId;
		if (size !== 'standard' || style !== 'layout_only') {
			if (size !== 'standard') {
				shortcode += ' size="' + size + '"';
			}
			if (style !== 'layout_only') {
				shortcode += ' style="' + style + '"';
			}
		}
		shortcode += ']';
		
		// Update input
		$input.val(shortcode);
	});

	/**
	 * If there is an existing API Key, make sure user is sure they want to change it
	 */
	if ($('#actionnetwork_api_key').length && $('#actionnetwork_api_key').val().length) {
		$('#actionnetwork_api_key').attr('readonly','readonly');
		$('#actionnetwork_api_key').after('<button id="actionnetwork_api_key_change">'+actionnetworkText.changeAPIKey+'</button>');
		$('#actionnetwork_api_key_change').click(function(event){
			event.preventDefault();
			if ( confirm( actionnetworkText.confirmChangeAPIKey ) ) {
				$('#actionnetwork_api_key_change').remove();
				$('#actionnetwork_api_key').removeAttr('readonly').focus();
			}
		});
	}
	
	/**
	 * If there is a "sync-started" notice, update it via ajax
	 */
	console.log('Checking for sync notice element...');
	console.log('Element found:', $('#actionnetwork-update-notice-sync-started').length);
	if ($('#actionnetwork-update-notice-sync-started').length) {
		console.log('Starting sync status polling...');
		$('#actionnetwork-update-notice-sync-started p').append('<img src="images/loading.gif" class="loading" />');
		$('#actionnetwork-actions-filter').hide();
		
		var errorCount = 0;
		var maxErrors = 5; // Stop polling after 5 consecutive errors
		var pollStartTime = Date.now();
		var maxPollTime = 30 * 60 * 1000; // 30 minutes max polling time
		
		updateSyncStatus = setInterval(
			function(){
				// Check if we've exceeded max polling time
				if (Date.now() - pollStartTime > maxPollTime) {
					var timeoutDetails = {
						error: 'Sync polling timeout',
						timeoutDuration: maxPollTime / 1000 / 60 + ' minutes',
						elapsedTime: ((Date.now() - pollStartTime) / 1000 / 60).toFixed(2) + ' minutes',
						timestamp: new Date().toISOString(),
						errorCount: errorCount
					};
					console.error('Sync polling timeout details:', timeoutDetails);
					clearInterval( updateSyncStatus );
					$('#actionnetwork-update-notice-sync-started').removeClass('updated').addClass('error');
					var timeoutHtml = '<strong>' + (actionnetworkText.syncTimeout || 'Sync timeout') + '</strong>: ' + (actionnetworkText.syncTimeoutMessage || 'The sync process has taken too long. Please refresh the page and check if the sync completed.');
					timeoutHtml += ' <a href="#" class="actionnetwork-show-error-details" style="text-decoration: underline;">Show error details</a>';
					timeoutHtml += '<div class="actionnetwork-error-details" style="display:none; margin-top: 10px; padding: 10px; background: #f0f0f0; border-left: 4px solid #d63638; font-family: monospace; font-size: 12px; white-space: pre-wrap;">' + JSON.stringify(timeoutDetails, null, 2) + '</div>';
					$('#actionnetwork-update-notice-sync-started p').html(timeoutHtml);
					$('#actionnetwork-actions-filter').show();
					// Re-enable the sync button
					$('#actionnetwork-update-sync-submit').prop('disabled', false);
					
					// Toggle error details
					$('.actionnetwork-show-error-details').on('click', function(e) {
						e.preventDefault();
						$('.actionnetwork-error-details').slideToggle();
						$(this).text($('.actionnetwork-error-details').is(':visible') ? 'Hide error details' : 'Show error details');
					});
					return;
				}
				
				var nonceValue = $('#actionnetwork_ajax_nonce').val();
				console.log('Polling sync status, nonce:', nonceValue);
				data = {
					action : 'actionnetwork_get_queue_status',
					actionnetwork_ajax_nonce : nonceValue
				}
				jQuery.get(ajaxurl,data,function(response){
					console.log('Sync status response:', response);
					// Reset error count on successful response
					errorCount = 0;
					
					// Check if response is valid
					if (!response || !response.status) {
						console.error('Invalid response format:', response);
						errorCount++;
						
						// Build detailed error message
						var errorDetails = {
							error: 'Invalid response format',
							response: response,
							timestamp: new Date().toISOString(),
							debug: response && response.debug ? response.debug : null
						};
						console.error('Sync error details:', errorDetails);
						
						if (errorCount >= maxErrors) {
							clearInterval( updateSyncStatus );
							$('#actionnetwork-update-notice-sync-started').removeClass('updated').addClass('error');
							var errorHtml = '<strong>' + (actionnetworkText.syncError || 'Sync Error') + '</strong>: ' + (actionnetworkText.syncErrorMessage || 'Unable to get sync status. Please refresh the page.');
							errorHtml += ' <a href="#" class="actionnetwork-show-error-details" style="text-decoration: underline;">Show error details</a>';
							errorHtml += '<div class="actionnetwork-error-details" style="display:none; margin-top: 10px; padding: 10px; background: #f0f0f0; border-left: 4px solid #d63638; font-family: monospace; font-size: 12px; white-space: pre-wrap;">' + JSON.stringify(errorDetails, null, 2) + '</div>';
							$('#actionnetwork-update-notice-sync-started p').html(errorHtml);
							$('#actionnetwork-actions-filter').show();
							$('#actionnetwork-update-sync-submit').prop('disabled', false);
							
							// Toggle error details
							$('.actionnetwork-show-error-details').on('click', function(e) {
								e.preventDefault();
								$('.actionnetwork-error-details').slideToggle();
								$(this).text($('.actionnetwork-error-details').is(':visible') ? 'Hide error details' : 'Show error details');
							});
						}
						return;
					}
					
					// Check for error status in response
					if (response.status === 'error') {
						console.error('Sync status returned error:', response);
						var errorDetails = {
							error: response.error || 'Unknown error',
							text: response.text,
							timestamp: new Date().toISOString(),
							debug: response.debug || null
						};
						console.error('Sync error details:', errorDetails);
						
						clearInterval( updateSyncStatus );
						$('#actionnetwork-update-notice-sync-started').removeClass('updated').addClass('error');
						var errorHtml = '<strong>' + (actionnetworkText.syncError || 'Sync Error') + '</strong>: ' + (response.text || 'An error occurred during sync.');
						errorHtml += ' <a href="#" class="actionnetwork-show-error-details" style="text-decoration: underline;">Show error details</a>';
						errorHtml += '<div class="actionnetwork-error-details" style="display:none; margin-top: 10px; padding: 10px; background: #f0f0f0; border-left: 4px solid #d63638; font-family: monospace; font-size: 12px; white-space: pre-wrap;">' + JSON.stringify(errorDetails, null, 2) + '</div>';
						$('#actionnetwork-update-notice-sync-started p').html(errorHtml);
						$('#actionnetwork-actions-filter').show();
						$('#actionnetwork-update-sync-submit').prop('disabled', false);
						
						// Toggle error details
						$('.actionnetwork-show-error-details').on('click', function(e) {
							e.preventDefault();
							$('.actionnetwork-error-details').slideToggle();
							$(this).text($('.actionnetwork-error-details').is(':visible') ? 'Hide error details' : 'Show error details');
						});
						return;
					}
					
					// Log debug info if available
					if (response.debug) {
						console.log('Sync debug info:', response.debug);
					}
					
					$('#actionnetwork-update-notice-sync-started p').text(response.text);
					if (response.status == 'complete' || response.status == 'empty') {
						console.log('Sync complete, refreshing page');
						clearInterval( updateSyncStatus );
						// Reload the page to show synced actions
						window.location.reload();
					}
				}).fail(function(xhr, status, error) {
					// Build comprehensive error details
					var errorDetails = {
						ajaxError: {
							status: status,
							error: error,
							statusCode: xhr.status,
							statusText: xhr.statusText,
							responseText: xhr.responseText,
							responseJSON: null
						},
						timestamp: new Date().toISOString(),
						url: ajaxurl,
						requestData: data
					};
					
					// Try to parse JSON response if available
					try {
						if (xhr.responseText) {
							errorDetails.ajaxError.responseJSON = JSON.parse(xhr.responseText);
						}
					} catch(e) {
						// Not JSON, that's okay
					}
					
					console.error('AJAX error details:', errorDetails);
					console.error('AJAX error summary:', status, error);
					console.log('XHR full object:', xhr);
					
					errorCount++;
					
					// Stop polling after max consecutive errors
					if (errorCount >= maxErrors) {
						clearInterval( updateSyncStatus );
						$('#actionnetwork-update-notice-sync-started').removeClass('updated').addClass('error');
						var errorMessage = (actionnetworkText.syncError || 'Sync Error') + ': ' + (actionnetworkText.syncConnectionError || 'Unable to connect to server. Please refresh the page and try again.');
						var errorHtml = '<strong>' + errorMessage + '</strong>';
						errorHtml += ' <a href="#" class="actionnetwork-show-error-details" style="text-decoration: underline;">Show error details</a>';
						errorHtml += '<div class="actionnetwork-error-details" style="display:none; margin-top: 10px; padding: 10px; background: #f0f0f0; border-left: 4px solid #d63638; font-family: monospace; font-size: 12px; white-space: pre-wrap;">' + JSON.stringify(errorDetails, null, 2) + '</div>';
						$('#actionnetwork-update-notice-sync-started p').html(errorHtml);
						$('#actionnetwork-actions-filter').show();
						// Re-enable the sync button
						$('#actionnetwork-update-sync-submit').prop('disabled', false);
						
						// Toggle error details
						$('.actionnetwork-show-error-details').on('click', function(e) {
							e.preventDefault();
							$('.actionnetwork-error-details').slideToggle();
							$(this).text($('.actionnetwork-error-details').is(':visible') ? 'Hide error details' : 'Show error details');
						});
					} else {
						// Show warning after first error
						if (errorCount === 1) {
							$('#actionnetwork-update-notice-sync-started p').append(' <span style="color: #d63638;">(' + (actionnetworkText.connectionIssues || 'Connection issues detected') + ')</span>');
							console.warn('First connection error detected. Error details:', errorDetails);
						}
					}
				});
			}, 3000
		);
	}
	
	/**
	 * Disable sync button on form submit to prevent double-submission
	 */
	$('#actionnetwork-update-sync').on('submit', function() {
		var $submitButton = $('#actionnetwork-update-sync-submit');
		if (!$submitButton.prop('disabled')) {
			$submitButton.prop('disabled', true).val($submitButton.data('disabled-text') || 'Syncing...');
		}
	});

});
