<?php

/**
 * Register block patterns.
 * Include this file in your theme, and update image paths, prefix and text domain.
 *
 * @link https://developer.wordpress.org/block-editor/developers/block-api/block-patterns/
 */

/**
 * Make sure that block patterns are enabled before registering.
 * Requires WordPress version 5.5 or Gutenberg version 7.8.
 */
if (function_exists('register_block_pattern')) {

    /**
     * Check if the register_block_pattern_category exists.
     * Requires WordPress 5.5 or Gutenberg version 8.2.
     */
    if (function_exists('register_block_pattern_category')) {
        register_block_pattern_category('forms', array('label' => __('Forms', 'understrap')));
        register_block_pattern_category('example', array('label' => __('Example', 'understrap')));
        register_block_pattern_category('blog', array('label' => __('Blog', 'understrap')));
        register_block_pattern_category('shop', array('label' => __('Shop', 'understrap')));
    }


    /**
     * Register the pattern.
     */
    register_block_pattern(
        'understrap/jumbotron',
        array(
            'title'       => __('Jumbotron 2', 'understrap'),
            'categories'  => array('Understrap'),
            'keywords'    => array(__('Understrap', 'understrap'), __('Jumbotron', 'understrap')),
            'description' => __('A contact form with a flower background image and a heading above it.', 'understrap'),
            'content'     => '
                <!-- wp:group {"className":"container py-5 p-5 mb-4 bg-light rounded-3"} -->
                <div class="wp-block-group container py-5 p-5 mb-4 bg-light rounded-3"><div class="wp-block-group__inner-container"><!-- wp:heading {"className":"display-5 fw-bold"} -->
                <h2 class="display-5 fw-bold">Custom jumbotron</h2>
                <!-- /wp:heading -->
                
                <!-- wp:paragraph {"className":"fs-4"} -->
                <p class="fs-4">This is the Front Page content. Use this static Page to test the Front Page output of the Theme. The Theme should properly handle both Blog Posts Index as Front Page and static Page as Front Page.</p>
                <!-- /wp:paragraph -->
                
                <!-- wp:buttons -->
                <div class="wp-block-buttons"><!-- wp:button {"borderRadius":0,"backgroundColor":"luminous-vivid-amber","textColor":"black","width":50} -->
                <div class="wp-block-button has-custom-width wp-block-button__width-50"><a class="wp-block-button__link has-black-color has-luminous-vivid-amber-background-color has-text-color has-background no-border-radius" href="#">Example button</a></div>
                <!-- /wp:button --></div>
                <!-- /wp:buttons --></div></div>
                <!-- /wp:group -->
            ',
        )
    );
}
