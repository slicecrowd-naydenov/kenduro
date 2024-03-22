<?php use Lean\Load; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<meta name="facebook-domain-verification" content="959mi9u8mxe95xoet9djmp9rux5q97" />
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="baseurl" href="<?php echo esc_url(get_site_url()); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php Load::organism('header/index'); ?>