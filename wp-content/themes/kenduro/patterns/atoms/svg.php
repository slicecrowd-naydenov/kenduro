<?php
	$defaults = [
		'name'  => '',
		'class' => '',
		'url'   => null,
	];

	$args     = wp_parse_args( $args, $defaults );
	$site_url = get_site_url();
	$url      = ( null === $args['url'] ) ? esc_url( ICON_PATH . '/' . $args['name'] . '.svg' ) : $url = str_replace( $site_url, '.', $args['url'] );
	$class    = trim( implode( ' ', (array) $args['class'] ) );
	$class    = ( '' !== $class ) ? ' ' . $class : '';

	echo '<i class="svg' . esc_attr( $class ) . '">' . wp_kses( wp_remote_get( esc_url( $url ) ) ) . '</i>';
