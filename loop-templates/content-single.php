<?php
/**
 * Single post partial template
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php if ( has_post_thumbnail() ): ?>

	<div class="carousel slide">
		<div class="carousel-inner">
			<figure class="carousel-item active">
			<img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>" alt="" class="img-fluid w-100" style="max-height: 200px;object-fit: cover;" />
			<div class="carousel-caption">
				<h1><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></h1>
			</div>
			</figure>
		</div>
	</div>

	<?php endif; ?>

	<header class="entry-header">

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->
	
	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
