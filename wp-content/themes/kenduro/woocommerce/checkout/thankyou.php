<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
			<?php
	// pretty_dump($order->get_meta_data());
			?>
			<div class="custom-section-wrapper">
				<div class="custom-section">
					<div>
						<img src="<?php echo IMAGES_PATH; ?>/confette.png" alt="confette">
					</div>
					<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>
					<p class="paragraph paragraph-xl regular">Поръчка №<?php echo $order->get_order_number(); ?> от <?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<div class="success-message">
						<p class="paragraph paragraph-l">
							Изпратихме имейл с потвържение на <strong><?php echo $order->get_billing_email(); ?></strong>.</br>
							Ще ви се обадим за потвърждение в рамките на деня.
						</p>
					</div>
				</div>
				<div class="custom-section column-wrapper">
					<div class="column">
						<p class="section-title paragraph paragraph-xl semibold">Данни за контакт</p>
						<p class="paragraph paragraph-m">Име</p>
						<p class="paragraph paragraph-l semibold text_value">
							<?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?>
						</p>
						<p class="paragraph paragraph-m">Имейл</p>
						<p class="paragraph paragraph-l semibold text_value">
							<?php echo $order->get_billing_email(); ?>
						</p>
						<p class="paragraph paragraph-m">Телефон за връзка</p>
						<p class="paragraph paragraph-l semibold text_value">
							<?php echo $order->get_billing_phone(); ?>
						</p>
						<?php 
								$order_meta_data = $order->get_meta_data();
								foreach ($order_meta_data as $meta_item) {
									// Проверка дали ключът е "woo_bg_econt_cookie_data"
									if ($meta_item->key === 'woo_bg_econt_cookie_data') {
										$meta_form = $meta_item->value['form'];
										$want_invoice = isset($meta_form['want_invoice']) ? $meta_form['want_invoice'] : false;
										if ($want_invoice) { ?>
										<p class="paragraph paragraph-m">Фактура към:</p>
										<p class="paragraph paragraph-l semibold">
											<?php echo $meta_form['invoice_company_name']; ?>
										</p>
										<p class="paragraph paragraph-l semibold">
											Булстат : <?php echo $meta_form['invoice_bulstat']; ?>
										</p>
										<?php if ($meta_form['invoice_vat_registration'] === 'yes') : ?>
											<p class="paragraph paragraph-l semibold">Регистрирана по ДДС</p>
											<p class="paragraph paragraph-l semibold">
												ДДС Номер : <?php echo $meta_form['invoice_vat_number']; ?>
											</p>
											<!-- pretty_dump($meta_item->value['form']); -->
										<?php
										endif;
										}
										break;
									}
								}	

								$type_delivery = '';
								// $address_delivery = '';
								$order_details = $order->get_order_item_totals();
								foreach ($order_details as $key => $order_detail) {
									if ($key === 'shipping') {
										$type_delivery = strpos($order_detail['value'], 'адрес') ? "Адрес" : "Офис";
									}
								}
						?>
					</div>
					<div class="column">
						<p class="section-title paragraph paragraph-xl semibold">Доставка и плащане</p>
						<p class="paragraph paragraph-m">Доставка</p>
						<p class="paragraph paragraph-l semibold text_value">ЕКОНТ</p>
						<p class="paragraph paragraph-m">Тип доставка</p>
						<p class="paragraph paragraph-l semibold text_value">
							До <?php echo $type_delivery; ?>
						</p>
						<p class="paragraph paragraph-m">Адрес на доставка</p>
						<p class="paragraph paragraph-l semibold text_value">гр Благоевград</p>
						<p class="paragraph paragraph-m">Начин на плащане</p>
						<p class="paragraph paragraph-l semibold text_value">
							<?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
						</p>

					</div>

					<?php 
								// pretty_dump($order);
					
					?>

				</div>
				
				<div class="button-wrapper">
					<a href="<?php echo esc_attr(get_site_url()); ?>" class="button button-secondary-blue">Отиди в началната страница</a>
				</div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
