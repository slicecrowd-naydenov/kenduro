<?php

/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
	return;
}
?>
<li class="custom-cart-list__item">
	<?php
	$is_visible        = $product && $product->is_visible();
	$product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

	?>
	<div class="product-thumbnail">
		<?php
		$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $product->get_image(), $item, $item_id);

		if (!$product_permalink) {
			echo $thumbnail; // PHPCS: XSS ok.
		} else {
			printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
		}
		?>
	</div>
	<div>
		<div class="product-name">
			<?php
			echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible));
			?>
		</div>
		<?php

		// **************************************
		// UNCOMMENT this when we add QUANTITY
		// **************************************

		// $qty          = $item->get_quantity();
		// $refunded_qty = $order->get_qty_refunded_for_item( $item_id );

		// if ( $refunded_qty ) {
		// 	$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
		// } else {
		// 	$qty_display = esc_html( $qty );
		// }

		// echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>', $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		
		// ***************************************
		// UNCOMMENT this when we add QUANTITY ^^^
		// ***************************************

		?>
		<div class="product-price">
			<?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
			?>
		</div>

	</div>
</li>