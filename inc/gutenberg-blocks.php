<?php

/**
 * Plugin Name: Gutenberg Blocks
 * Author: Muhammad Owais Alam
 * Description: This plugin allows users to add a WordPress Gutenberg custom template for the Gutenberg editor
 * Version: 1.0.0
 */
add_action( 'init', function() {
    $args = array(
        'public' => true,
        'label'  => 'News',
        'show_in_rest' => true,
        'template_lock' => 'all',
        'template' => array(
            array( 'core/paragraph', array(
                'placeholder' => 'Breaking News',
            ) ),
            array( 'core/image', array(
                'align' => 'right',
            ) ),
        ),
    );
    register_post_type( 'jumbotron block', $args );
} );