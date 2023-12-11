<?php
/**
 * Custom menu functions
 */
function register_custom_menus() {
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu' ),
		)
	);
}
