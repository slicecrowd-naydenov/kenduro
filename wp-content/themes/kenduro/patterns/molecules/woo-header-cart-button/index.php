<?php 
  use Lean\Load; 

  // if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // global $woocommerce;
    // $total = $woocommerce->cart->get_cart_total();
    // $cart_icon = file_get_contents(ICON_PATH.'/cart.svg');

    // $filledBasket = $count > 0 ? 'filled' : '';
?>

  <a 
    class="cart-customlocation" 
    href="<?php echo wc_get_cart_url(); ?>" 
    title="<?php _e( 'View your shopping cart' ); ?>"
  > 
    <span class="cart-icon"><?php Load::atom('svg', ['name' => 'cart']); ?></span>
    <span class="text">Количка :</span> 
    <?php echo WC()->cart->get_cart_total(); ?>
  </a>