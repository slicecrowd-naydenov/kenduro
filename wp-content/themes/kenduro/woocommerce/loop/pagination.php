<?php

/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if (!defined('ABSPATH')) {
	exit;
}

$total   = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base    = isset($base) ? $base : esc_url_raw(add_query_arg('product-page', '%#%', remove_query_arg('add-to-cart')));
$format  = isset($format) ? $format : '';

if ($total <= 1) {
	return;
}
?>
<nav class="woocommerce-pagination">
	<div class="woocommerce-pagination__info">
		<?php
		$has_prev_link = false;
		$has_next_link = false;
		if (1 < $current) :
			$has_prev_link = true;
		endif;

		if ($current < $total || -1 == $total) :
			$has_next_link = true;
		endif;
		?>
		<a href="<?php echo esc_url(add_query_arg('product-page', max(1, $current - 1))); ?>" class="button button-secondary-blue <?php echo esc_attr($has_prev_link ? 'enable' : 'disable'); ?>">
			<span>Предишна</span>
		</a>
		<p class="paragraph paragraph-l tetriary semibold">Страница <?php echo $current; ?> от <?php echo $total; ?></p>
		<a href="<?php echo esc_url(add_query_arg('product-page', min($total, $current + 1))); ?>" class="button button-secondary-blue <?php echo esc_attr($has_next_link ? 'enable' : 'disable'); ?>">
			<span>Следваща</span>
		</a>
	</div>

	<?php
	echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array(
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max(1, $current),
				'total'     => $total,
				'prev_text' => 'Предишна',
				'next_text' => 'Следваща',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
	?>
</nav>
