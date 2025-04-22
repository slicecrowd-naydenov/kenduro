<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

 // phpcs:disable WooCommerce.Commenting.CommentHooks.MissingHookComment

use Lean\Load;

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$downloads          = $order->get_downloadable_items();

// We make sure the order belongs to the user. This will also be true if the user is a guest, and the order belongs to a guest (userID === 0).
$show_customer_details = $order->get_user_id() === get_current_user_id();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>

<div class="woocommerce">
	<section class="woocommerce-order-details">
		<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

		<div class="collapse show" id="collapseExample">
				<p class="paragraph paragraph-xl semibold primary">Количка</p>
				<?php do_action('woocommerce_order_details_before_order_table_items', $order); ?>
				<ul class="custom-cart-list">
					<?php
					foreach ($order_items as $item_id => $item) {
						$product = $item->get_product();
		

						wc_get_template(
							'order/order-details-item.php',
							array(
								'order'              => $order,
								'item_id'            => $item_id,
								'item'               => $item,
								'show_purchase_note' => $show_purchase_note,
								'purchase_note'      => $product ? $product->get_purchase_note() : '',
								'product'            => $product,
							)
						);
					}
					?>
		
				</ul>
		
					<?php do_action('woocommerce_order_details_after_order_table_items', $order); ?>
			</div>
			<!-- <div id="custom-total">
				<span class="paragraph paragraph-xl primary semibold">Крайна цена</span>
				<h2 class="primary semibold">
					<span id="total"><?php // echo wp_kses_post($order->get_data()['total']); ?></span>
					лв.
				</h2>
			</div> -->
			<a class="button hide-show-cart" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
				<span class="text show-cart">
					Покажи количката
					<?php Load::atom('svg', ['name' => 'arrow_down']); ?>
		
				</span>
				<span class="text hide-cart">
					Скрий количката
					<?php Load::atom('svg', ['name' => 'arrow_down']); ?>
		
				</span>
			</a>
			<?php do_action('woocommerce_order_details_after_order_table', $order); ?>
	</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

?>

</div>
<?php
// if ( $show_customer_details ) {
	// wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
// }
