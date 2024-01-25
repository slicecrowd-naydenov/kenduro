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
$product = wc_get_product();
?>
<div class="custom-stock">
	<p class="stock paragraph paragraph-m <?php echo esc_attr( $class ); ?>">
		<?php // echo wp_kses_post( $availability );
			Load::atom('svg', ['name' => 'checkbox']);
	
			if ($class === 'in-stock') {
				// echo '<b>In stock</b>';
				echo 'Може да бъде доставено утре !';
			}
	
			if ($class === 'out-of-stock') {
				// echo '<b>Out of stock</b>';
				echo 'Не може да бъде доставен на следващия ден';
			}

			if ($class === 'available-on-backorder') {
				// echo '<b>In Backorder</b>';
				echo 'Може да бъде доставен след 3-6 дни';
			}
		?>
	</p>
	<span class="woocommerce-variation-sku-number paragraph paragraph-m">
		Prod. № : 
		<span class="sku-value">
			<?php 
				if ( !$product->is_type( 'variable' ) ) {
					echo $product->get_sku();
						// For variable products, get the SKU of the selected variation
						// $default_attributes = $product;
						// pretty_dump($product);
                
						// Get the default variation ID based on the default attributes
						// $variation_id = wc_get_default_variation_id( $product, $default_attributes );
						
						// Get the SKU of the default variation
						// $variation = wc_get_product( $variation_id );
						// echo $variation->get_sku();
				} 
				?>
		</span>
	</span>
</div>
