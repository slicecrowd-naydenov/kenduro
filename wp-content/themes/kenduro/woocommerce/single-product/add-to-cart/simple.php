<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}
if ($product->get_type() === 'easy_product_bundle') {
	function get_product_gallery_urls( $product_id ) {
    $product = wc_get_product( $product_id );

    if ( ! $product ) {
			return [];
    }

    // Масив за съхранение на URL адресите
    $image_urls = [];

    // Добавяме основното изображение
    $image_id = $product->get_image_id();
    if ( $image_id ) {
			$image_url = wp_get_attachment_url( $image_id );
			$image_urls[] = $image_url ? $image_url : wc_placeholder_img_src('woocommerce_single');
    } else {
			$image_urls[] = wc_placeholder_img_src('woocommerce_single');
    }

    $gallery_ids = $product->get_gallery_image_ids();
    if ( ! empty( $gallery_ids ) ) {
			foreach ( $gallery_ids as $gallery_id ) {
				$image_url = wp_get_attachment_url( $gallery_id );
				$image_urls[] = $image_url ? $image_url : wc_placeholder_img_src('woocommerce_single');
			}
		}

    return $image_urls;
	}

	
	$bundle_products = wc_get_product($product->get_id())->items;
	$bundle_products_ids = array_map(function ($item) {
		$delivery_time_text = '';
		$prod = wc_get_product($item['product']);
		$parent_id = $prod->get_parent_id();
		$parent_product = wc_get_product($parent_id);
		$get_product_name = '';
	
		if ($prod->get_type() === 'simple') {
			$get_product_name = $prod->get_name();
			$meta_data = get_field('meta_data', $item['product']); // $product_id е ID-то на продукта, за който искате да вземете полето
			if ($meta_data) {
				// Използване на array_column за създаване на асоциативен масив с ключовете и стойностите
				$meta_data_keys = array_column($meta_data, 'value', 'key');
				$get_prod = wc_get_product($item['product']);
				$stock_quantity = $get_prod->get_stock_quantity();
				if ($stock_quantity > 0) {
					$delivery_time_text = '1 Ден (утре)';
				} else {
					// Проверка дали съществува ключът 'delivery_time' и извличане на стойността му
					if (isset($meta_data_keys['delivery_time'])) {
						$delivery_time_value = $meta_data_keys['delivery_time'];
						$delivery_time_text = esc_html($delivery_time_value);
					} else {
						$delivery_time_text = 'Ще се свържем с Вас';
					}
				}
			} 
		} else {	
			$get_product_name = $parent_product->get_name();
			// $delivery_time_text = get_post_meta($item['product'], '_my_delivery_time_text', true);
		}

		// $delivery_time_text = get_post_meta($item['product'], '_my_delivery_time_text', true);
		// get_product_gallery_urls( $item['product'] );
		// pretty_dump(wc_get_gallery_image_html( 6995, false ));
		// pretty_dump($prod);
		$parent_prod_id = $prod->get_type() === 'simple' ? $item['product'] : wp_get_post_parent_id($item['product']);
    return [
			'id' => $item['product'],
			'parent_prod_id' => $parent_prod_id,
			'variation_prod_ids' => $item['products'],
			'type' => $prod->get_type(),
			'quantity' => $item['quantity'], // Количеството на основния продукт
			'parent_name' => $get_product_name,
			'delivery_time_text' => $delivery_time_text,
			'gallery_urls' => get_product_gallery_urls($parent_prod_id),
			'variations' => array_map(function ($variation_id) use ($parent_product) {
				$variation_product = wc_get_product($variation_id);
				$delivery_var_time_text = get_post_meta($variation_id, '_my_delivery_time_text', true);

				return [
					'id' => $variation_id, // ID на вариацията
					'type' => $variation_product->get_type(), // Тип на вариацията
					'quantity' => $variation_product->get_data()['stock_quantity'],
					'variation_option' => $variation_product->get_data()['attribute_summary'],
					'delivery_time_text' => $delivery_var_time_text,
					'name' => $parent_product->get_name() . ' ' . $variation_product->get_data()['attribute_summary']
				];
			}, $item['products']), // Включваме всички вариации
		];
	}, $bundle_products);

	?>
	<script>
    var bundle_products_ids = <?php echo json_encode($bundle_products_ids); ?>;
	</script>
	<?php
	// pretty_dump(wc_get_product($product->get_id())->items );
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
		<div class="custom-price-box">
			<?php echo $product->get_price_html() ?>
		</div>
		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button button-primary-orange add_to_cart_button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>">
			<span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span>
		</button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
