<?php
/**
 * The sidebar containing the main widget area
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'woocommerce-sidebar' ) ) {
	return;
}

// when both sidebars turned on reduce col size to 3 from 4.
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<div class="col-md-3 order-2 order-md-1 widget-area mt-md-5" id="woocommerce-sidebar" role="complementary">

<?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>

</div><!-- #woocommerce-sidebar -->
