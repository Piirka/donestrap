<?php

// Disabling custom colors in block Color Palettes #Disabling custom colors in block Color Palettes
// By default, the color palette offered to blocks allows the user to select a custom color different from the editor or theme default colors.
// This flag will make sure users are only able to choose colors from the editor-color-palette the theme provided or from the editor default colors if the theme did not provide one.
add_theme_support( 'disable-custom-colors' );

add_action( 'after_setup_theme', 'understrap_setup_theme_supported_features' );
function understrap_setup_theme_supported_features() {
    
    // Parses colors from sass file and make them available in Gutenberg. 
    // TODO: Make this more readable. Not pretty but works. 
    $colors = trim(file_get_contents(get_template_directory_uri().'/sass/theme/_theme_variables.scss'));
    $display = explode('// Gutenberg colors', $colors);
    $display = str_replace(' !default;','",', $display );
    $display = str_replace(':','":"', $display );
    $display = str_replace('$','"', $display );
    $display = str_replace(' ','', $display );
    $display = '{'.$display[1].'}';
    $colors = str_replace(",\n}","}", trim($display) );

    $editor_color_palette = array();

    foreach( json_decode($colors) as $key => $value ) {
        $editor_color_palette[] = array(
            'name'  => $key,
            'slug'  => $key,
            'color' => $value
        );
    }

    add_theme_support( 'editor-color-palette', $editor_color_palette );  
}



/**
 * This adds theme.css styles to gutenberg editor.
 */ 
function understrap_gutenberg_css() {
	add_theme_support( 'editor-styles' ); // if you don't add this line, your stylesheet won't be added.
	add_editor_style( 'css/theme.min.css' ); // tries to include style-editor.css directly from your theme folder.
}
add_action( 'after_setup_theme', 'understrap_gutenberg_css' );