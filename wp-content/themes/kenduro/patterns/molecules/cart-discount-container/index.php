<div class="cart-discounts-container">
		<?php 
		foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<p class="paragraph paragraph-m">Отстъпка от промо код</p>
        <span class="code-name"><?php echo $code; ?> </span>
				<span class="discount-info">
					<?php
						$discount_amount = $coupon->get_amount(); // Получаване на стойността на отстъпката
						$discount_type = $coupon->get_discount_type(); // Получаване на типа на отстъпката

						if ( $discount_type == 'percent' ) {
							echo '<strong class="discount-amount">' . $discount_amount . '%</strong>';
						} else {
							echo '<strong class="discount-amount">' . wc_price( $discount_amount ) . '</strong>';
						}
						
						wc_cart_totals_coupon_html( $coupon ); 
					?>
				</span>
			</div>
		<?php endforeach; ?>
	</div>