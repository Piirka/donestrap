<?php
/**
 * Add WooCommerce support
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'understrap_woocommerce_support' );
if ( ! function_exists( 'understrap_woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function understrap_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		// Add Product Gallery support.
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add Bootstrap classes to form fields.
		add_filter( 'woocommerce_form_field_args', 'understrap_wc_form_field_args', 10, 3 );
		add_filter( 'woocommerce_quantity_input_classes', 'understrap_quantity_input_classes' );
		add_filter( 'wc_add_to_cart_message_html', 'understrap_custom_added_to_cart_message' );
		add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'understrap_dropdown_variation_classes' );
	}
}

// First unhook the WooCommerce content wrappers.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Then hook in your own functions to display the wrappers your theme requires.
add_action( 'woocommerce_before_main_content', 'understrap_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'understrap_woocommerce_wrapper_end', 10 );

if ( ! function_exists( 'understrap_woocommerce_wrapper_start' ) ) {
	/**
	 * Display the theme specific start of the page wrapper.
	 */
	function understrap_woocommerce_wrapper_start() {
		$container = get_theme_mod( 'understrap_container_type' );
		echo '<div class="wrapper" id="woocommerce-wrapper">';
		echo '<div class="' . esc_attr( $container ) . '" id="content" tabindex="-1">';
		echo '<div class="row">';
		if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {
			get_template_part( 'sidebar-templates/sidebar', 'woocommerce' );
			echo '<div class="col order-1 order-md-2 content-area" id="primary">';
		}
		echo '<main class="site-main" id="main">';
	}
}

if ( ! function_exists( 'understrap_woocommerce_wrapper_end' ) ) {
	/**
	 * Display the theme specific end of the page wrapper.
	 */
	function understrap_woocommerce_wrapper_end() {
		echo '</main><!-- #main -->';
		if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {
			echo '</div>';
		}
		echo '</div><!-- .row -->';
		echo '</div><!-- Container end -->';
		echo '</div><!-- Wrapper end -->';
	}
}

if ( ! function_exists( 'understrap_wc_form_field_args' ) ) {
	/**
	 * Filter hook function monkey patching form classes
	 * Author: Adriano Monecchi http://stackoverflow.com/a/367jkj24593/307826
	 *
	 * @param string $args Form attributes.
	 * @param string $key Not in use.
	 * @param null   $value Not in use.
	 *
	 * @return mixed
	 */
	function understrap_wc_form_field_args( $args, $key, $value = null ) {

		// Start field type switch case.
		switch ( $args['type'] ) {
			// Targets all select input type elements, except the country and state select input types.
			case 'select':
				/*
				 * Add a class to the field's html element wrapper - woocommerce
				 * input types (fields) are often wrapped within a <p></p> tag.
				 */
				$args['class'][] = 'form-group';
				// Add a class to the form input itself.
				$args['input_class'] = array( 'form-control' );
				// Add custom data attributes to the form input itself.
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;

			/*
			 * By default WooCommerce will populate a select with the country names - $args
			 * defined for this specific input type targets only the country select element.
			 */
			case 'country':
				$args['class'][] = 'form-group single-country';
				break;

			/*
			 * By default WooCommerce will populate a select with state names - $args defined
			 * for this specific input type targets only the country select element.
			 */
			case 'state':
				$args['class'][]           = 'form-group';
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			case 'password':
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control' );
				break;
			case 'textarea':
				$args['input_class'] = array( 'form-control' );
				break;
			case 'checkbox':
					$args['class'][] = 'form-group';
					// Wrap the label in <span> tag.
					$args['label'] = isset( $args['label'] ) ? '<span class="custom-control-label">' . $args['label'] . '<span>' : '';
					// Add a class to the form input's <label> tag.
					$args['label_class'] = array( 'custom-control custom-checkbox' );
					$args['input_class'] = array( 'custom-control-input' );
				break;
			case 'radio':
				$args['label_class'] = array( 'custom-control custom-radio' );
				$args['input_class'] = array( 'custom-control-input' );
				break;
			default:
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control' );
				break;
		} // End of switch ( $args ).
		return $args;
	}
}

if ( ! is_admin() && ! function_exists( 'wc_review_ratings_enabled' ) ) {
	/**
	 * Check if reviews are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_reviews_enabled() {
		return 'yes' === get_option( 'woocommerce_enable_reviews' );
	}

	/**
	 * Check if reviews ratings are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_review_ratings_enabled() {
		return wc_reviews_enabled() && 'yes' === get_option( 'woocommerce_enable_review_rating' );
	}
}

if ( ! function_exists( 'understrap_quantity_input_classes' ) ) {
	/**
	 * Add Bootstrap class to quantity input field.
	 *
	 * @param array $classes Array of quantity input classes.
	 * @return array
	 */
	function understrap_quantity_input_classes( $classes ) {
		$classes[] = 'form-control';
		return $classes;
	}
}

if ( ! function_exists( 'understrap_custom_added_to_cart_message' ) ) {
	/**
	 * Add Bootstrap class to added to cart message
	 *
	 * @param string $message String of the message.
	 * @return string
	 */
	function understrap_custom_added_to_cart_message( $message ) {
		return str_replace( 'button', 'btn btn-secondary btn-sm float-end', $message );
	}
}

if ( ! function_exists( 'understrap_dropdown_variation_classes' ) ) {
	/**
	 * Add Bootstrap class to select
	 *
	 * @param array $args Array of select arguments.
	 * @return array
	 */
	function understrap_dropdown_variation_classes( $args ) {
		$args['class'] = 'form-select w-25';
		return $args;
	}
}

if ( ! function_exists( 'understrap_woocommerce_before_shop_loop_item' ) ) {
	/**
	 * Add some style to shop items
	 */
	function understrap_woocommerce_before_shop_loop_item() {
		echo '<div class= "p-2 shadow-lg">';
	}
}
add_action( 'woocommerce_before_shop_loop_item', 'understrap_woocommerce_before_shop_loop_item' );

if ( ! function_exists( 'understrap_woocommerce_after_shop_loop_item' ) ) {
	/**
	 * Closing div for shop items loop
	 */
	function understrap_woocommerce_after_shop_loop_item() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'understrap_woocommerce_after_shop_loop_item' );


/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function understrap_woocommerce_cart_icon_shortcode() {
	ob_start();
	$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count.
	$cart_url = wc_get_cart_url(); // Set Cart URL.
	
	?>
	
	<li>
		<a class="nav-link menu-item cart-contents" href="<?php echo $cart_url; ?>" title="My Basket">
		<?php if ( $cart_count > 0 ) : ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
				<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
			</svg>
			<span class="cart-contents-count">(<?php echo $cart_count; ?>)</span>
		<?php endif; ?>
		</a>
	</li>
	
	<?php

	return ob_get_clean();
}
add_shortcode( 'woo_cart_but', 'understrap_woocommerce_cart_icon_shortcode' );

// Add a filter to get the cart count
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
/**
 * Add AJAX Shortcode when cart contents update
 */
function woo_cart_but_count( $fragments ) {
	ob_start();
	$cart_count = WC()->cart->cart_contents_count;
	$cart_url = wc_get_cart_url();
	
	?>
	<li>
		<a class="nav-link menu-item cart-contents" href="<?php echo $cart_url; ?>" title="My Basket">
		<?php if ( $cart_count > 0 ) : ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
				<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
			</svg>
			<span class="cart-contents-count">(<?php echo $cart_count; ?>)</span>
		<?php endif; ?>
		</a>
	</li>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}

add_filter( 'wp_nav_menu_items', 'woo_cart_but_icon', 10, 2 ); // Change menu to suit - example uses 'top-menu'

/**
 * Add WooCommerce Cart Menu Item Shortcode to particular menu
 */
function woo_cart_but_icon( $items, $args ) {
	if ( $args->theme_location == 'primary' ) {
		$items .= do_shortcode( '[woo_cart_but]' ); // Adding the created Icon via the shortcode already created
	   
	}   
	return $items;
}

add_action( 'widgets_init', 'understrap_woocommerce_widget_init' );

if ( ! function_exists( 'understrap_woocommerce_widget_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function understrap_woocommerce_widget_init() {
		register_sidebar(
			array(
				'name'          => __( 'Woocommerce Sidebar', 'understrap' ),
				'id'            => 'woocommerce-sidebar',
				'description'   => __( 'Woocommerce right sidebar widget area', 'understrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
} // End of function_exists( 'understrap_widgets_init' ).