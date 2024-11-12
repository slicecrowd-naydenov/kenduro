<?php
/**
 * Add theme scripts
 */

function add_theme_scripts() {
	if (!is_admin()) {
		// wp_deregister_script( 'jquery' );
		// wp_deregister_script('jquery-ui-core');
		wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'storefront-gutenberg-blocks' );
		wp_dequeue_style( 'storefront-icons' );
		wp_dequeue_style( 'storefront-fonts' );
		wp_dequeue_style( 'storefront-style-inline' );
		// wp_dequeue_style( 'wp-emoji-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );

		// wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', false, null, true );
		// wp_enqueue_script( 'jquery' );
	}
	
	wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/build/css/style.css', array(), filemtime( get_stylesheet_directory() . '/build/css/style.css' ) );
	
	wp_enqueue_script( 'libs-script', get_stylesheet_directory_uri() . '/build/js/libs.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/build/js/libs.js' ), true );
	wp_enqueue_script( 'main-script', get_stylesheet_directory_uri() . '/build/js/main-min.js', array( 'libs-script' ), filemtime( get_stylesheet_directory() . '/build/js/main-min.js' ), true );

	wp_localize_script( 'main-script', 'wpApiSettings', array(
    'rest_url' => esc_url_raw( rest_url() ),
    'site_url' => esc_url_raw( get_site_url() ),
    'nonce' => wp_create_nonce( 'wp_rest' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'add_theme_scripts', 21);
