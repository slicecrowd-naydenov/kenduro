<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

use Lean\Load;

if (!defined('ABSPATH')) {
	exit;
}

if ($related_products) : ?>

	<section class="related products">

		<?php
		$heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));

		if ($heading) :
		?>
			<div class="popular-categories">
				<?php
				global $product;
				$category_ids = $product->get_category_ids();
				$innermost_category_id = null;
				$innermost_category_slug = null;

				foreach ($category_ids as $category_id) {
					if ($innermost_category_id === null || term_is_ancestor_of($innermost_category_id, $category_id, 'product_cat')) {
						$innermost_category_id = $category_id;
						$innermost_category = get_term_by('id', $category_id, 'product_cat');
						$innermost_category_slug = $innermost_category->slug;
					}
				}

				$innermost_category_name = get_term_field('name', $innermost_category_id, 'product_cat');

				?>
				<div class="popular-categories__header">
					<p class="paragraph paragraph-xl semibold primary">Popular in <?php echo $innermost_category_name; ?></p>
					<?php
					Load::atoms('link/index', [
						'text' => 'Browse All Products',
						'class' => 'underline',
						'url' => get_site_url().'/product-category/' . $innermost_category_slug,
						'icon' => 'arrow_down'
					]);
					?>
				</div>
			</div>
			<hr>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

		<?php foreach ($related_products as $related_product) : ?>

			<?php
			$post_object = get_post($related_product->get_id());

			setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

			wc_get_template_part('content', 'product');
			?>

		<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
<?php
endif;

wp_reset_postdata();
