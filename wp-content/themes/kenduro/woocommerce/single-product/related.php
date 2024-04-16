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
$related_prod = array();

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

$category_id = $innermost_category_id;

$args = array(
	'post_type'      => 'product',
	'post__not_in' => array(get_the_ID()),
	'posts_per_page' => 5,
	// 'orderby'        => 'rand',
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $category_id,
		),
	)
);
$products_query = new WP_Query($args);
if ($products_query->have_posts()) :
	while ($products_query->have_posts()) : $products_query->the_post();
		$related_prod[] = get_the_ID();
	endwhile;

	wp_reset_postdata();
endif;
if ($related_prod) :
?>

	<section class="related products">
		<div class="popular-categories">
			<div class="popular-categories__header">
				<p class="paragraph paragraph-xl semibold primary">Популярни в <?php echo $innermost_category_name; ?></p>
				<?php
				Load::atoms('link/index', [
					'text' => 'Разгледай всички Продукти',
					'class' => 'underline',
					'url' => get_site_url() . '/product-category/' . $innermost_category_slug,
					'icon' => 'arrow_down'
				]);
				?>
			</div>
		</div>
		<hr>

		<?php echo do_shortcode('[products ids="' . implode(',', $related_prod) . '" limit="5" columns="5"]'); ?>

	</section>
<?php
endif;

wp_reset_postdata();
