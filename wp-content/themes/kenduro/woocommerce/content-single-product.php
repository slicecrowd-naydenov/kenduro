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

defined('ABSPATH') || exit;

global $product;

function brand_text() {
	global $product;

	$brand = '';

	if ($product->get_attribute('pa_brand')) {
		$brand = $product->get_attribute('pa_brand');
	} else {
		$brand = '';
	}

	return $brand;
}

function custom_code_after_product_data_tabs() {
	global $product;

	if (!$product) {
		return;
	}

	// Popular products by Brand
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 3,
		'post__not_in' => array(get_the_ID()),
		'tax_query'      => array(
			array(
				'taxonomy'   => 'pa_brand',
				'field'      => 'slug',
				'terms'      => strtolower(brand_text()),
			),
		),
		'orderby'        => 'menu_order', // Сортиране по полето "Menu order"
		'order'          => 'ASC',
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) : ?>
		<div class="row brand-section">
			<div class="col-12 col-xl-6">
				<?php 
					$taxonomy = 'pa_brand';
					$term = get_term_by('name', brand_text(), $taxonomy);
					$term_id = $term->term_id;
					$meta_fields = get_term_meta($term_id);
					$term_logo_id = $meta_fields['exclusive_logo'][0];
					$brand_description = $meta_fields['brand_description'][0];
					$term_logo = wp_get_attachment_url($term_logo_id);
					$term_link = get_term_link($term);

				?>
				<div class="brand-info">
					<div class="brand-info__image">
						<div class="brand-info__logo">
							<img src="<?php echo esc_attr($term_logo)?>" />
						</div>
					</div>
					<div class="brand-info__description paragrap paragraph-l">
						<?php echo $brand_description; ?>
					</div>
					<a href="<?php echo esc_attr($term_link); ?>" class="paragrap paragraph-l">Виж всички продукти от <?php echo brand_text(); ?></a>
				</div>


			</div>
			<div class="col-12 col-xl-6">
				<div class="brand-section__products">
					<div>Популярни от <strong><?php echo brand_text(); ?></strong></div>
					<?php
						Load::atoms('link/index', [
							'text' => 'Разгледай всички',
							'class' => 'underline',
							'url' => $term_link,
							'icon' => 'arrow_down'
						]); 
					?>
				</div>
				<div class="woocommerce columns-5">
					<ul class="products columns-5">
						<?php

						while ($query->have_posts()) :
							$query->the_post();
							$product = wc_get_product(get_the_ID());
							$product_classes = implode(' ', wc_get_product_class('', $product));
							$product_image = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail')[0] : wc_placeholder_img_src();
							?>
							<li class="product <?php echo esc_attr($product_classes); ?>">
								<a href="<?php echo esc_url(get_permalink()); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
									<div class='wc-img-wrapper'>
										<?php
										// Product image
										echo '<img src="' . esc_url($product_image) . '" alt="' . esc_attr(get_the_title()) . '" />';
										?>
									</div>
									<?php
									// Product title
									echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';

									// Product price
									echo '<span class="price">' . $product->get_price_html() . '</span>';
									?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>	
			</div>
		</div>
<?php
	endif;

	wp_reset_postdata();
}
add_action('woocommerce_after_single_product_summary', 'custom_code_after_product_data_tabs', 11);

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
	<div class="product-gallery-section">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action('woocommerce_before_single_product_summary');
		?>

		<div class="summary entry-summary">
			<?php

			if (brand_text() !== '') : ?>
				<p class="paragraph paragraph-xl semibold text-underline"><?php echo brand_text(); ?></p>
			<?php endif;
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
			do_action('woocommerce_single_product_summary');
			Load::organisms('information-list/index', [
				'class' => 'product-single',
				'list'  => [
					['icon' => 'customer-support', 'text' => 'Доставка на следващия ден *'],
					['icon' => 'return-policy', 'text' => 'Тествайте преди да купите'],
					['icon' => 'payment', 'text' => 'Плащане при доставка'],
					['icon' => 'return-policy', 'text' => '14-дневна политика за връщане']
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
	do_action('woocommerce_after_single_product_summary');
	?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>