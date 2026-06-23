=== Action Network ===
Contributors: concertedaction
Tags: signup, events, action network, online organizing
Requires at least: 4.6
Tested up to: 6.9
Stable tag: 1.8.5
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

Provides Action Network (actionnetwork.org) action embed codes as shortcodes and a calendar and signup widget

== Description ==

A free Wordpress plugin for the [Action Network](https://actionnetwork.org) online organizing tools maintained by [Concerted Action](http://concertedaction.consulting/).

Features:

* Create a Wordpress shortcode or widget from any Action Network embed code.
* Manage your saved embed codes using the Wordpress backend. Supports sorting by title, type and last modified date, and provides a search function.
* Modify Action Network's default "thank you for your support" and "help us by using sharing tools" messages, and control which sharing options (social, email & embed codes) are displayed, using shortcode options or widget controls.
* Use `[actionnetwork_list]` shortcode or Action Network List widget to show a list of current actions.
* Use `[actionnetwork_calendar]` shortcode or Action Network Calendar widget to show a list of upcoming events. Optionally outputs upcoming events in JSON. Development of this feature was supported by [The People's Lobby](http://www.thepeopleslobbyusa.org/) - if you like it, please consider [making a donation to them](https://actionnetwork.org/fundraising/donate-to-the-peoples-lobby).
* If you are an [Action Network Partner](https://actionnetwork.org/partnerships), use your API key to sync all of your actions from Action Network to Wordpress.
* Create signup widgets which allow visitors to your site to sign up for your email list _without_ using Action Network javascript embeds. This allows you to place a signup form on every page (for example in the sidebar), and still load Action Network embed codes for actions on particular pages (since Action Network's scripts will only load one embed code per page).  This feature does require the API key, so you have to be an [Action Network Partner](https://actionnetwork.org/partnerships) to use it.

Detailed specs for shortcode attributes, widget options, etc. are available on the Help menu for the Action Network page on the backend.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. If you have an [Action Network API Key](https://actionnetwork.org/partnerships), go to the Action Network section and click on the "Settings" tab to enter your API key. Your actions will automatically be synced from Action Network to your Wordpress site.

== Frequently Asked Questions ==

= My ticketed events aren't showing up on the list =

Action Network does not currently provide access to Ticketed Events through its API. This plugin has ended support for ticketedevents.

== Screenshots ==

1. Provides a Wordpress-like interface for managing embed codes and shortcodes

== Changelog ==

= 1.8.5 =
* Bug fix: Embed code validation now accepts Action Network widget v6+ (regex updated from v2-4 to any version)
* Bug fix: Removed wp_kses_post() from embed code input so the required <script> tag is preserved for both validation and storage
* Bug fix: Prevent PHP warning "Trying to access array offset on null" in embed code display function
* Bug fix: Prevent potential PHP 8.1+ TypeError when no embed code is found for a given action

= 1.8.4 =
* Bug fix: Fixed incorrect database table name that prevented adding actions on new multisite subsites (table was created as wp-action-network instead of actionnetwork)
* Cleans up incorrectly-named table from 1.8.2/1.8.3 on upgrade

= 1.8.3 =
* Bug fix: Removed server-to-self (loopback) HTTP requests that were blocked by WAF/ModSecurity rules on some hosting configurations (e.g. OpenLiteSpeed, XCloud)
* Bug fix: Manual sync button and daily cron sync now run directly instead of relying on wp_remote_post() to admin-ajax.php
* Bug fix: Cron sync now logs actual inserted/updated counts instead of stale request parameters
* Enhancement: Replaced "Cron Updates" tab with "Sync Status" tab showing queue status, last sync results, and cron history
* Enhancement: Added "Reset Stuck Sync" button to recover from stuck sync states
* Enhancement: Added copyable support/debug information panel for troubleshooting
* Tested with WordPress 6.9

= 1.8.2 =
* Bug fix: Fixed issue where API sync button would get stuck disabled if sync failed
* Bug fix: Added error handling to prevent infinite polling when AJAX requests fail
* Enhancement: Added comprehensive debugging information for sync failures
* Enhancement: Added "Show error details" link in error messages for troubleshooting
* Enhancement: Added timeout protection (30 minutes) for sync polling
* Enhancement: Improved error recovery - sync button now re-enables on errors
* Enhancement: Added server-side error logging when WP_DEBUG is enabled

= 1.8.1 =
* Code quality: Prefixed helper functions to satisfy WordPress naming rules
* Security: Replaced raw SQL string concatenation with prepared statements where needed
* Housekeeping: Removed hidden macOS metadata file from the plugin root

= 1.8.0 =
* Code quality: Resolved all remaining plugin checker warnings
* Tested with WordPress 6.8

= 1.7.0 =
* Performance improvements: Added version parameters to all enqueued scripts and styles
* Performance improvements: Scripts now load in footer where appropriate
* Code quality: All assets now properly enqueued using WordPress functions
* Security: Fixed all XSS and CSRF vulnerabilities
* Security: Plugin checker compliant with all security and performance warnings resolved

= 1.6.0 =
* Security: Fixed all XSS vulnerabilities with proper escaping
* Security: Fixed CSRF vulnerability in admin filter form
* Code quality: All outputs properly escaped
* Code quality: Plugin checker compliant

= 1.5.0 =

* Security: Fixed CSRF vulnerability in admin actions filter form
* Security: Fixed multiple XSS vulnerabilities in admin pages and widget controls
* UI: Replaced alert popup with inline shortcode options editor
* Removed "Add Action" tab (actions should be synced via API)
* Improved input sanitization and escaping throughout admin interface

= 1.4.4 =

* Security updates. 
* Updated and tested with latest Wordpress version.

= 1.4.3 =

* Security updates. 
* Updated and tested with latest Wordpress version.

= 1.4.2 =

* Bug fix for to support embedded Action Network URLs up to version 4.

= 1.4.1 =

* Bug fix for widget hCaptcha protection when hCaptcha keys are not provided. The hCaptcha verification will require both hCaptcha keys in the plugin settings and the "Spam protection" checkbox be enabled. If either are not provided, hCaptcha protection will be disabled, allowing the form to be submitted without verification.

= 1.4.0 =

* Fixed hCaptcha checkbox.

= 1.3.0 =

* Updated automatic syncing of data from Action Network. 
* Added record of sync results.

= 1.2.2 =

* Revert of SVN issue.

= 1.2.1 =

* Added Gutenberg Editor button.
* Bug fix related to hCaptcha.

= 1.2 =

* This major update includes the following updates: 
* hCaptcha ability added for API based forms. 
* Bug fixes related too multiple embeds on a single page, and the API sync. 
* shortcode button for tinymce WYSIWYG. 
* additional documentation on setting page. 

= 1.1.3 =

* Updating developer information.

= 1.1.2 =
* Fixed problem where Action Network dates (both for events and modified_date for all actions), which are in local time, were being compared to UTC time. Now they are compared to the local timezone of the website.

= 1.1.1 =
* Fixed problem which would cause updates from wordpress.org to crash

= 1.1.0 =
* Added AJAX submission for signup form, new shortcode attributes to control thank-you displays, new widget to display actions, and new shortcode and widget to display lists of actions.

= 1.0.1 =
* Updated to recognize Action Network's v3 widgets

= 1.0 =
* First release on wordpress.org

Previous development versions can be found on [github](https://github.com/jkissam/actionnetwork/)

== Upgrade Notice ==

= 1.2.1 =

Added Gutenberg Editor button.

= 1.2 =

This major update includes the following updates: 
hCaptcha ability added for API based forms. 
shortcode button for tinymce WYSIWYG. 

= 1.1.1 =
Fixed problem which would cause updates from wordpress.org to crash

= 1.1.0 =
New features, including new widgets, shortcodes, and shortcode options, as well as ajax submission of the signup form.

= 1.0.1 =
Updated to recognize Action Network's v3 widgets

= 1.0 =
Install from wordpress.org to stay up-to-date
