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

$current_product = wc_get_product(get_the_ID());

function brand_text($current_product) {
	$brand = '';

	if ($current_product->get_attribute('pa_brand')) {
		$brand = $current_product->get_attribute('pa_brand');
	} else {
		$brand = '';
	}

	return $brand;
}

$brand_text = brand_text($current_product);


function custom_code_after_product_data_tabs() {
	$current_product = wc_get_product(get_the_ID());
	$brand_text = brand_text($current_product);


	if (!$current_product) {
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
				'terms'      => strtolower($brand_text),
			),
		),
		'orderby'        => 'menu_order', // Сортиране по полето "Menu order"
		'order'          => 'ASC',
	);
	$related_products = wc_get_products($args);

	if (!empty($related_products)) : ?>
		<div class="row brand-section">
			<div class="col-12 col-xl-6">
				<?php 
					$taxonomy = 'pa_brand';
					$term = get_term_by('name', $brand_text, $taxonomy);
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
							<img src="<?php echo esc_attr($term_logo)?>" alt="<?php echo esc_attr(strtolower($brand_text)); ?>" />
						</div>
					</div>
					<div class="brand-info__description paragrap paragraph-l">
						<?php echo $brand_description; ?>
					</div>
					<a href="<?php echo esc_attr($term_link); ?>" class="paragrap paragraph-l">Виж всички продукти от <?php echo $brand_text; ?></a>
				</div>


			</div>
			<div class="col-12 col-xl-6">
				<div class="brand-section__products">
					<div>Популярни от <strong><?php echo $brand_text; ?></strong></div>
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
						foreach ($related_products as $related_product) :
							$related_product_ID = $related_product->get_id();
							$product_classes = implode(' ', wc_get_product_class('', $related_product));
							$product_image = has_post_thumbnail($related_product_ID) ? wp_get_attachment_image_src(get_post_thumbnail_id($related_product_ID), 'medium')[0] : wc_placeholder_img_src();
							?>
							<li class="product <?php echo esc_attr($product_classes); ?>">
								<a href="<?php echo esc_url(get_permalink($related_product_ID)); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
									<div class='wc-img-wrapper'>
										<?php
										// Product image
										echo '<img src="' . esc_url($product_image) . '" alt="' . esc_attr(get_the_title($related_product_ID)) . '" />';
										?>
									</div>
									<?php
									// Product title
									echo '<h3 class="woocommerce-loop-product__title">' . get_the_title($related_product_ID) . '</h3>';

									// Product price
									echo '<span class="price">' . $related_product->get_price_html() . '</span>';
									?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>	
			</div>
		</div>
<?php
	endif;

	// wp_reset_postdata();
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
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $current_product ); ?>>
	<?php
		$attachment_ids = $current_product->get_gallery_image_ids();
		$class_gallery = '';
		if (empty($attachment_ids)) {
			$class_gallery = 'no-gallery';
		}
	?>
	<div class="product-gallery-section <?php echo $class_gallery; ?>">
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

			if ($brand_text !== '') : 
				$term = get_term_by('name', $brand_text, 'pa_brand');
				$term_link = get_term_link($term);
			?>
				<a href="<?php echo esc_url($term_link); ?>" class="paragraph paragraph-xl semibold text-underline"><?php echo $brand_text; ?></a>
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
			?>
			<div class="recommended-box">
				<p class="paragraph paragraph-xl semibold primary text-center">Може би ще харесаш също така</p>
				<div class="woocommerce column-4 skeleton-products">
					<ul class="recco-custom products columns-4">
						<li class="product skeleton">
							<a
								class="woocommerce-LoopProduct-link woocommerce-loop-product__link"
								href="#"
							>
								<div class="wc-img-wrapper">
									<img src="<?php echo wc_placeholder_img_src(); ?>" />
								</div>
								<p class="paragraph paragraph-l">Product Title</p>
								<div class="button button-secondary-blue">Разгледай</div>
							</a>
						</li>
						<li class="product skeleton">
							<a
								class="woocommerce-LoopProduct-link woocommerce-loop-product__link"
								href="#"
							>
								<div class="wc-img-wrapper">
									<img src="<?php echo wc_placeholder_img_src(); ?>" />
								</div>
								<p class="paragraph paragraph-l">Product Title</p>
								<div class="button button-secondary-blue">Разгледай</div>
							</a>
						</li>
						<li class="product skeleton">
							<a
								class="woocommerce-LoopProduct-link woocommerce-loop-product__link"
								href="#"
							>
								<div class="wc-img-wrapper">
									<img src="<?php echo wc_placeholder_img_src(); ?>" />
								</div>
								<p class="paragraph paragraph-l">Product Title</p>
								<div class="button button-secondary-blue">Разгледай</div>
							</a>
						</li>
						<li class="product skeleton">
							<a
								class="woocommerce-LoopProduct-link woocommerce-loop-product__link"
								href="#"
							>
								<div class="wc-img-wrapper">
									<img src="<?php echo wc_placeholder_img_src(); ?>" />
								</div>
								<p class="paragraph paragraph-l">Product Title</p>
								<div class="button button-secondary-blue">Разгледай</div>
							</a>
						</li>
					</ul>
				</div>
				<div class="recommender-ui-wrapper"></div>
			</div>
		</div>
	</div>

	<?php

	Load::organisms('information-list/index', [
		'class' => 'product-single',
		'list'  => [
			['icon' => 'calendar', 'text' => 'Доставка на следващия ден *'],
			['icon' => 'return-policy', 'text' => 'Тествайте преди да купите'],
			['icon' => 'payment', 'text' => 'Плащане при доставка'],
			['icon' => 'return-policy', 'text' => '14-дневна политика за връщане']
		]
	]);
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