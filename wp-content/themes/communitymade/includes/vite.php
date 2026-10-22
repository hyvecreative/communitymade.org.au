<?php
/**
 * Vite asset loading.
 *
 * Replaces the old dist/assets.json lookup that paired with webpack 2.
 *
 * Two modes:
 *
 *   Development  `npm run dev` writes dist/hot. Assets are loaded from the
 *                Vite dev server so SCSS and JS hot-reload in the browser.
 *
 *   Production   Assets are read from dist/.vite/manifest.json. Filenames are
 *                content-hashed by Vite, so the URL changes whenever the file
 *                changes — cachebusting without version query strings.
 *
 * @package CommunityMade
 */

namespace CommunityMade\Vite;

defined( 'ABSPATH' ) || exit;

const OUT_DIR       = 'dist';
const ENTRY         = 'src/index.js';
const MANIFEST_PATH = 'dist/.vite/manifest.json';
const HOT_PATH      = 'dist/hot';

/** Handle used for the bundle, so other code can depend on it. */
const HANDLE = 'communitymade-bundle';

/**
 * Absolute filesystem path inside the theme.
 */
function theme_path( string $relative = '' ): string {
	return get_template_directory() . ( $relative ? '/' . ltrim( $relative, '/' ) : '' );
}

/**
 * Public URL inside the theme.
 */
function theme_url( string $relative = '' ): string {
	return get_template_directory_uri() . ( $relative ? '/' . ltrim( $relative, '/' ) : '' );
}

/**
 * Is this a local development environment?
 *
 * The dev server is never consulted on a live site, so a dist/hot file
 * accidentally deployed to production cannot break it.
 */
function is_dev_environment(): bool {
	if ( function_exists( 'wp_get_environment_type' ) && 'local' === wp_get_environment_type() ) {
		return true;
	}

	return defined( 'WP_DEBUG' ) && WP_DEBUG;
}

/**
 * The running Vite dev server origin, or null if we should use built files.
 *
 * A stale dist/hot — left behind by a crash, a force-quit, or a laptop going
 * to sleep — would otherwise point the site at a dead server and leave it
 * unstyled. So the file is treated as a hint, and confirmed with a quick
 * reachability check cached for a few seconds.
 */
function dev_server_url(): ?string {
	static $resolved = false;
	static $origin   = null;

	if ( $resolved ) {
		return $origin;
	}

	$resolved = true;

	if ( ! is_dev_environment() ) {
		$origin = null;
		return $origin;
	}

	$hot_file = theme_path( HOT_PATH );

	if ( ! file_exists( $hot_file ) ) {
		$origin = null;
		return $origin;
	}

	$candidate = trim( (string) file_get_contents( $hot_file ) );

	if ( ! $candidate ) {
		$origin = null;
		return $origin;
	}

	$candidate = untrailingslashit( $candidate );
	$cache_key = 'communitymade_vite_up_' . md5( $candidate );
	$cached    = get_transient( $cache_key );

	if ( false !== $cached ) {
		$origin = ( '1' === $cached ? $candidate : null );
		return $origin;
	}

	$response = wp_remote_get(
		$candidate . '/@vite/client',
		array(
			'timeout'   => 1,
			'sslverify' => false,
		)
	);

	$is_up = ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response );

	// Short TTL: starting the dev server should take effect almost immediately.
	set_transient( $cache_key, $is_up ? '1' : '0', 10 );

	$origin = ( $is_up ? $candidate : null );
	return $origin;
}

/**
 * Read and cache the build manifest.
 */
function manifest(): array {
	static $manifest = null;

	if ( null !== $manifest ) {
		return $manifest;
	}

	$path = theme_path( MANIFEST_PATH );

	if ( ! file_exists( $path ) ) {
		$manifest = array();
		return $manifest;
	}

	$decoded  = json_decode( (string) file_get_contents( $path ), true );
	$manifest = is_array( $decoded ) ? $decoded : array();

	return $manifest;
}

/**
 * Enqueue the theme bundle. Hooked from functions.php.
 */
function enqueue_assets(): void {
	$dev_server = dev_server_url();

	if ( $dev_server ) {
		enqueue_dev_assets( $dev_server );
		return;
	}

	enqueue_built_assets();
}

/**
 * Development: load modules straight from the Vite server.
 *
 * No stylesheet is enqueued — in dev, Vite injects the CSS through JS so it
 * can hot-swap it without a page reload.
 */
function enqueue_dev_assets( string $origin ): void {
	wp_enqueue_script( HANDLE . '-client', $origin . '/@vite/client', array(), null, false );
	wp_enqueue_script( HANDLE, $origin . '/' . ENTRY, array( 'jquery' ), null, true );
}

/**
 * Production: read hashed filenames from the manifest.
 */
function enqueue_built_assets(): void {
	$manifest = manifest();

	if ( empty( $manifest[ ENTRY ] ) ) {
		if ( is_dev_environment() ) {
			trigger_error( // phpcs:ignore WordPress.PHP.DevelopmentFunctions
				'Community Made: no Vite build found. Run `npm run build` (or `npm run dev`) in the theme directory.',
				E_USER_WARNING
			);
		}
		return;
	}

	$entry = $manifest[ ENTRY ];

	// Stylesheets first so they are in the head before the bundle runs.
	$css_files = isset( $entry['css'] ) ? (array) $entry['css'] : array();

	foreach ( $css_files as $index => $css_file ) {
		wp_enqueue_style(
			HANDLE . '-css' . ( $index ? '-' . $index : '' ),
			theme_url( OUT_DIR . '/' . $css_file ),
			array(),
			null // Hashed filename already busts the cache.
		);
	}

	if ( ! empty( $entry['file'] ) ) {
		wp_enqueue_script(
			HANDLE,
			theme_url( OUT_DIR . '/' . $entry['file'] ),
			array( 'jquery' ),
			null,
			true
		);
	}
}

/**
 * Vite emits ES modules, so the bundle needs type="module".
 *
 * Module scripts are deferred by spec, which means they execute after the
 * document is parsed — and therefore after the classic jQuery script in the
 * footer has run.
 */
function add_module_type( string $tag, string $handle, string $src ): string {
	$module_handles = array( HANDLE, HANDLE . '-client' );

	if ( ! in_array( $handle, $module_handles, true ) ) {
		return $tag;
	}

	// Only needed in development, where the modules come from the Vite
	// origin rather than the WordPress one.
	$crossorigin = dev_server_url() ? ' crossorigin' : '';

	return sprintf(
		'<script type="module"%s src="%s" id="%s"></script>' . "\n",
		$crossorigin,
		esc_url( $src ),
		esc_attr( $handle . '-js' )
	);
}

add_filter( 'script_loader_tag', __NAMESPACE__ . '\add_module_type', 10, 3 );
