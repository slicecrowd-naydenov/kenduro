<?php use Lean\Load; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<!-- <meta name="facebook-domain-verification" content="959mi9u8mxe95xoet9djmp9rux5q97" /> -->
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="baseurl" href="<?php echo esc_url(get_site_url()); ?>">

	<?php wp_head(); ?>
	<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '951338676594370'); 
 fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=951338676594370&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
</head>

<body <?php body_class(); ?>>
	<?php Load::organism('header/index'); ?>