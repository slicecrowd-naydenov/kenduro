<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
use Lean\Load;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}
$added_coupon_code = WC()->cart->get_applied_coupons() ? 'valid-code' : '';

?>
<div class="coupon-wrapper <?php echo esc_attr($added_coupon_code); ?>">
	<div class="add-coupon woocommerce-form-coupon-toggle showcoupon">
		<?php Load::atom('svg', ['name' => 'plus', 'class' => 'plus-icon']); ?>
		Добави промо код
	</div>

	<?php Load::molecules('cart-discount-container/index'); ?>

	<form class="checkout_coupon woocommerce-form-coupon coupon-area" method="post">
		<label for="coupon_code" class="coupon-label">
			<?php esc_html_e( 'Промо код', 'woocommerce' ); ?>
		</label>

		<div class="input-wrapper">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Въведи тук', 'woocommerce' ); ?>" id="coupon_code" value="" />

			<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( '', 'woocommerce' ); ?>"><?php esc_html_e( '', 'woocommerce' ); ?></button>
		</div>
	</form>
</div>