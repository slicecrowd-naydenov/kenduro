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
<?php
// $order = wc_get_order(12339);
// pretty_dump($order->get_items());
// $rows = [];
// foreach ( $order->get_items() as $item ) {
// 	// pretty_dump(get_class($item));
// 	$product_data = $item->get_data();
// 	$id = $product_data['product_id'];
// 	$product = wc_get_product($id);
// 	$product_total = $item['total'];
// 	$product_total_tax = $item['total_tax'];
// 	$product_discount = $product_total + $product_total_tax;
// 		// $product = $item->get_product();
// 	$rows[] = [
// 		"sku" => $product ? $product->get_sku() : '', // Защита ако продуктът е изтрит
// 		"price" => $product_discount,
// 		"quantity" => $item->get_quantity()
// 	];

// 	pretty_dump($product->get_sku());
// }
// pretty_dump($rows);