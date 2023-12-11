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
$base    = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format  = isset($format) ? $format : '';
// pretty_dump($base);
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
		<a href="<?php echo esc_url(str_replace('%#%', $current - 1, $base)); ?>" class="button button-secondary <?php echo esc_attr($has_prev_link ? 'enable' : 'disable'); ?>">Previous page</a>
		<p class="paragraph paragraph-l tetriary semibold">Page <?php echo $current; ?> of <?php echo $total; ?></p>
		<a href="<?php echo esc_url(str_replace('%#%', $current + 1, $base)); ?>" class="button button-secondary <?php echo esc_attr($has_next_link ? 'enable' : 'disable'); ?>">Next page</a>
	</div>

	<?php
	echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max(1, $current),
				'total'     => $total,
				'prev_text' => 'Previus Page',
				'next_text' => 'Next Page',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
	?>
</nav>