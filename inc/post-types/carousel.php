<?php 
/**
 * Create Custom post type for carousel items.
 *
 * @package UnderStrap
 */

/**
 * Register Custom Post Type.
 */
function carousel_post_type() {

	$labels = array(
		'name'                  => _x( 'Carousels', 'Post Type General Name', 'understrap' ),
		'singular_name'         => _x( 'Carousel', 'Post Type Singular Name', 'understrap' ),
		'menu_name'             => __( 'Carousels', 'understrap' ),
		'name_admin_bar'        => __( 'Carousel', 'understrap' ),
		'archives'              => __( 'Item Archives', 'understrap' ),
		'attributes'            => __( 'Item Attributes', 'understrap' ),
		'parent_item_colon'     => __( 'Parent Item:', 'understrap' ),
		'all_items'             => __( 'All Items', 'understrap' ),
		'add_new_item'          => __( 'Add New Item', 'understrap' ),
		'add_new'               => __( 'Add New', 'understrap' ),
		'new_item'              => __( 'New Item', 'understrap' ),
		'edit_item'             => __( 'Edit Item', 'understrap' ),
		'update_item'           => __( 'Update Item', 'understrap' ),
		'view_item'             => __( 'View Item', 'understrap' ),
		'view_items'            => __( 'View Items', 'understrap' ),
		'search_items'          => __( 'Search Item', 'understrap' ),
		'not_found'             => __( 'Not found', 'understrap' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'understrap' ),
		'featured_image'        => __( 'Featured Image', 'understrap' ),
		'set_featured_image'    => __( 'Set featured image', 'understrap' ),
		'remove_featured_image' => __( 'Remove featured image', 'understrap' ),
		'use_featured_image'    => __( 'Use as featured image', 'understrap' ),
		'insert_into_item'      => __( 'Insert into item', 'understrap' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'understrap' ),
		'items_list'            => __( 'Items list', 'understrap' ),
		'items_list_navigation' => __( 'Items list navigation', 'understrap' ),
		'filter_items_list'     => __( 'Filter items list', 'understrap' ),
	);
	$args = array(
		'label'                 => __( 'Carousel', 'understrap' ),
		'description'           => __( 'A slideshow component for cycling through images — like a carousel.', 'understrap' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'carousel', $args );

}
add_action( 'init', 'carousel_post_type', 0 );

/**
 * Preset a custom fields for new carousel posts.
 *
 * @param int $post_ID Id of the post.
 */
function preset_custom_fields_to_carousel_custom_post_type( $post_ID ) {
	if ( 'auto-draft' === get_post_status( $post_ID ) && post_type_supports( get_post_type( $post_ID ), 'custom-fields' ) ) {
		add_post_meta( $post_ID, 'Link', '' );
		add_post_meta( $post_ID, 'Target', '_blank or _parent' );
		add_post_meta( $post_ID, 'Button_text', 'Read more..' );
	}
}
add_action( 'save_post_carousel', 'preset_custom_fields_to_carousel_custom_post_type' );

/**
 * Display carousel
 */
function understrap_carousel() {
	
	  $args = array(
		  'post_type' => 'carousel',
		  'posts_per_page' => -1,
		  'orderby'   => 'menu_order',
		  'order'     => 'ASC',
		  'meta_query' => array(
			  array(
				  'key' => '_thumbnail_id',
				  'compare' => 'EXISTS',
			  ),
		  ),
			  
	  );
	  $the_query = new WP_Query( $args );
	   

		?>

	  <?php if ( $the_query->have_posts() ) : ?>

			<?php
			$show_controls = true;
			$show_indicators = false;
			?>

		<section id="carousel" class="carousel slide">
			<?php if ( $show_indicators ) : ?>
		<ol class="carousel-indicators">    
				<?php for ( $i = 0; $i < $the_query->post_count; $i++ ) : ?>
			<li data-target="#carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ( $i ? $i : 'active' ); ?>"></li>    
			<?php endfor; ?>
		</ol>    
		<?php endif; ?>
		<div class="carousel-inner">
			<?php $i = 0; ?>
			<?php while ( $the_query->have_posts() ) : ?> 
				<?php $the_query->the_post(); ?>    
			<article class="carousel-item d-flex justify-content-center align-items-center <?php echo ( $i ? $i : 'active' ); ?>">
			<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="d-block w-100" alt="<?php echo get_the_title(); ?>" style="max-height: 400px; object-fit: cover;">
			<div class="position-absolute text-center">
				<h2><?php echo get_the_title(); ?></h2>
				<p>
					<?php echo nl2br( get_the_excerpt() ); ?>
				</p>
				<?php if ( get_post_meta( get_the_ID(), 'Link' ) ) : ?>
					<br />
					<a href="<?php echo get_post_meta( get_the_ID(), 'Link', true ); ?>" target="<?php echo get_post_meta( get_the_ID(), 'Target', true ); ?>" class="btn btn-success"><?php echo get_post_meta( get_the_ID(), 'Button_text', true ); ?></a>
				<?php endif; ?>
			</div>
			</article>
				<?php $i++; ?>
		<?php endwhile; ?>
		</div>
				<?php if ( $show_controls && $the_query->post_count > 1 ) : ?>
				<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</a>
				<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</section>
		
	  <?php endif; ?>

		<?php


}
