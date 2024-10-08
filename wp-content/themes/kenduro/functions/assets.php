<?php
/**
 * Add theme scripts
 */
function add_theme_styles() {
	wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/build/css/style.css', array(), filemtime( get_stylesheet_directory() . '/build/css/style.css' ) );
}
function add_theme_scripts() {
	wp_enqueue_script( 'libs-script', get_stylesheet_directory_uri() . '/build/js/libs.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/build/js/libs.js' ), true );
	wp_enqueue_script( 'main-script', get_stylesheet_directory_uri() . '/build/js/main-min.js', array( 'libs-script' ), filemtime( get_stylesheet_directory() . '/build/js/main-min.js' ), true );

	wp_localize_script( 'main-script', 'wpApiSettings', array(
    'rest_url' => esc_url_raw( rest_url() ),
    'site_url' => esc_url_raw( get_site_url() ),
    'nonce' => wp_create_nonce( 'wp_rest' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'add_theme_styles', 21 );
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );
