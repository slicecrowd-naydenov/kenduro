<?php
	$defaults = [
	  'name' => '',
	  'class' => '',
	];
	
	$args = wp_parse_args( $args, $defaults );
	$class = trim( implode( ' ', (array) $args['class'] ) );
	$class = ($class !== '') ? ' ' . $class : '';

	echo url_get_contents(ICON_PATH . '/' . $args['name'] . '.svg');
?>