<?php
/**
 * UnderStrap functions and definitions
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = get_template_directory() . '/inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
	'/gutenberg.php',                      	// Load Gutenberg functions.
	'/gutenberg-blocks.php',               	// Predefined Gutenberg block.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once $understrap_inc_dir . $file;
}

// Array of custom post types.
$understrap_cpt_includes = array(
	'/carousel.php',                  // Initialize theme default settings.
);

// Include files.
foreach ( $understrap_cpt_includes as $cpt ) {
	require_once $understrap_inc_dir . '/post-types' . $cpt;
}

/**
 * Remove jQuery migrate.
 * 
 * @param Object $scripts 
 */ 
function understrap_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		
		if ( $script->deps ) { // Check whether the script has any dependencies.
			$script->deps = array_diff(
				$script->deps,
				array(
					'jquery-migrate',
				)
			);
		}
	}
}
add_action( 'wp_default_scripts', 'understrap_remove_jquery_migrate' );

/**
 * Lets move jQeury from head to footer.
 */ 
function understrap_move_jquery_to_footer() {
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'understrap_move_jquery_to_footer' );

/**
 * Removes block editor css from frontend. Instead this will be added in webpack.mix.js to theme bundle.
 */ 
function understrap_remove_wp_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
} 
add_action( 'wp_enqueue_scripts', 'understrap_remove_wp_block_library_css', 100 );
