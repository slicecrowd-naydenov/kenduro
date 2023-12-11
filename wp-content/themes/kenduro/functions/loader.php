<?php
/**
 * Templates loader
 */
add_filter( 'loader_directories', function( $directories ) {
	$directories[] = get_stylesheet_directory() . '/patterns';

	return $directories;
});

add_filter('loader_alias', function( $alias ) {
	$alias['atom']     = 'atoms';
	$alias['molecule'] = 'molecules';
	$alias['organism'] = 'organisms';

	return $alias;
});
