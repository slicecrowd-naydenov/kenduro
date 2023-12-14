<?php
  use Lean\Load; 

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
  // $cart_icon = file_get_contents(ICON_PATH.'/cart.svg');

	ob_start();

	?>
	<a 
    class="cart-customlocation"
    href="<?php echo esc_url(wc_get_cart_url()); ?>" 
    title="<?php _e('View your shopping cart', 'woothemes'); ?>"
  >
    <span class="cart-icon"><?php Load::atom('svg', ['name' => 'cart']); ?></span>
    <span class="text">Cart :</span> 
    <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}