<?php use Lean\Load; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<?php if (isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['HTTP_HOST'], ['kenduro.com', 'www.kenduro.com'])) : ?>
		<script>
			(() => {
				let t = document.createElement("script");
				t.src = "https://businesswebvitals.com/YaNLaxvZfkjmdLVu"
				t.async = !0;
				t.id = "uxify-script";
				document.head.appendChild(t);
			})();
		</script>
		<script async src="https://scripts.luigisbox.com/LBX-833562.js"></script> 
	<?php endif; ?>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <meta name="facebook-domain-verification" content="959mi9u8mxe95xoet9djmp9rux5q97" /> -->
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="baseurl" href="<?php echo esc_url(get_site_url()); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php Load::organism('header/index');	?>