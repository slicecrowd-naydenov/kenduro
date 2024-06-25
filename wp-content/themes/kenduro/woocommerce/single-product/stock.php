<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */
use Lean\Load;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$delivery_time_text = '';
$ss_delivery_time_text = '';

if ($product->is_type('simple')) {
	$meta_data = get_field('meta_data', $product->get_id()); // $product_id е ID-то на продукта, за който искате да вземете полето
	if ($meta_data) {
		// Използване на array_column за създаване на асоциативен масив с ключовете и стойностите
		$meta_data_keys = array_column($meta_data, 'value', 'key');

		// Проверка дали съществува ключът 'delivery_time' и извличане на стойността му
		if (isset($meta_data_keys['delivery_time'])) {
			$delivery_time_value = $meta_data_keys['delivery_time'];
			$delivery_time_text = esc_html($delivery_time_value);
		} else {
			$delivery_time_text = 'Ще се свържем с Вас';
		}
	} 
} else {
	$variation_ids = $product->get_children();

	$delivery_time_text = get_post_meta($variation_ids[0], '_my_delivery_time_text', true);
}

switch ($delivery_time_text) {
	case "В момента няма наличност":
		$ss_delivery_time_text = "В момента няма наличност";
		break;
	case "Ще се свържем с вас":
		$ss_delivery_time_text = "Наличност : ще се свържем с вас";
		break;
	case "1 Ден (утре)":
		$ss_delivery_time_text = "Може да бъде доставено утре!";
		break;
	default:
		$ss_delivery_time_text = "Доставка ".$delivery_time_text;
}

?>
<div class="custom-stock">
	<p class="stock paragraph paragraph-m <?php echo esc_attr( $class ); ?>">
		<?php // echo wp_kses_post( $availability );
			Load::atom('svg', ['name' => 'checkbox']);
		?>
			<span>
				<?php echo $ss_delivery_time_text; ?>
			</span>
			<?php
			// if ($class === 'in-stock') {
			// 	// echo '<b>In stock</b>';
			// 	echo 'Може да бъде доставено утре !';
			// }
	
			// if ($class === 'out-of-stock') {
			// 	// echo '<b>Out of stock</b>';
			// 	echo 'Не може да бъде доставен на следващия ден';
			// }

			// if ($class === 'available-on-backorder') {
			// 	// echo '<b>In Backorder</b>';
			// 	echo 'Може да бъде доставен след 3-6 дни';
			// }
		?>
	</p>
	<span class="woocommerce-variation-sku-number paragraph paragraph-m">
		Продукт № : 
		<span class="sku-value">
			<?php //echo $product->get_sku();	?>
		</span>
	</span>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.variations_form').on('found_variation', function(event, variation) {
		var delivery_time_text = variation.delivery_time_text;
		var delivery_message;

		switch (delivery_time_text) {
			case "В момента няма наличност":
				delivery_message = "В момента няма наличност";
				break;
			case "Ще се свържем с вас":
				delivery_message = "Наличност : ще се свържем с вас";
				break;
			case "1 Ден (утре)":
				delivery_message = "Може да бъде доставено утре!";
				break;
			default:
				delivery_message = "Доставка " + delivery_time_text;
		}

		$('.custom-stock .stock span').text(delivery_message);
	});
});
</script>