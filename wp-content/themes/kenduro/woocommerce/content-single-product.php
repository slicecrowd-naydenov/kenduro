<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */
use Lean\Load; 

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="product-gallery-section">
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
  	$meta_fields = get_field("meta_data", $product->get_id());
		foreach ($meta_fields as $meta_field) {
			if (get_site_url() === 'http://kenduro.test') {
				if ($meta_field['key'] === 's76de0814b') {
					if ($meta_field['value'] !== '') {
						?>
						<p class="paragraph paragraph-xl semibold text-underline"><?php echo $meta_field['value']; ?></p>
						<?php
					}
				}
			} else {
				if ($meta_field['key'] === 'brand_text_id') {
					if ($meta_field['value'] !== 's86366185a') {
						?>
						<p class="paragraph paragraph-xl semibold text-underline"><?php echo $meta_field['value']; ?></p>
						<?php
					}
				}
			}
		}
		// pretty_dump($meta_fields);
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		Load::organisms('information-list/index', [
			'class' => 'product-single',
      'list'  => [
				['icon' => 'customer-support', 'text' => 'Next Day Delivery *'],
				['icon' => 'return-policy', 'text' => 'Test before you buy'],
				['icon' => 'payment', 'text' => 'Pay on Delivery'],
				['icon' => 'return-policy', 'text' => '14-day Return Policy']
			]
    ]);
		?>
	</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
