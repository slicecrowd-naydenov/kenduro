<?php

use Lean\Load;

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;
// $category = get_queried_object();
// echo single_term_title();
get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>
<div class="container">
	<div class="row">
		<div class="col">
			<?php
			if (is_product_category()) :
				if (category_has_parent()) :
					woocommerce_breadcrumb();
				endif;
			endif;
			?>
			<header>
				<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
					<!-- .woocommerce-products-header__title -->
					<h4 class="page-title semibold"><?php woocommerce_page_title(); ?></h4>
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action('woocommerce_archive_description');
				?>
			</header>
			<?php
			$ancestors = get_ancestors(get_queried_object_id(), 'product_cat');

			if ($ancestors) {
				$outermost_parent_id = end($ancestors);
			} else {
				$outermost_parent_id = get_queried_object_id();
			}
			$cat_inner_image_url = get_field('inner_cat_thumbnail', 'product_cat_' . $outermost_parent_id);

			if (is_product_category()) {
				Load::molecules('product-category/product-category-info/index', [
					'title' => 'Learn more about ',
					'class' => 'full-container',
					'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					'cat' => single_term_title('', false),
					'cat_img_inner' => $cat_inner_image_url
				]);
				Load::molecules('product-category/product-categories-view/index');
				Load::molecules('product-category/product-categories-filter/index');
			} else {
				Load::molecules('product-category/product-category-info/index', [
					'title' => 'ALL PRODUCTS',
					'class' => 'full-container',
					'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					'cat' => single_term_title('', false),
					'cat_img_inner' => $cat_inner_image_url
				]);
				Load::molecules('product-category/product-categories-view/index');
			}

			if (woocommerce_product_loop()) {

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action('woocommerce_before_shop_loop');

				woocommerce_product_loop_start();

				if (wc_get_loop_prop('total')) {
					while (have_posts()) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action('woocommerce_shop_loop');

						wc_get_template_part('content', 'product');
					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action('woocommerce_after_shop_loop');
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action('woocommerce_no_products_found');
			}
			// echo do_shortcode('[wrvp_recently_viewed_products number_of_products_in_row="4" posts_per_page="4"]');
            Load::molecules('product-category/product-category-info/index', [
              'title' => '<span class="highlighted">K</span>enduro is crafted by Teo',
              'class' => 'full-width-container',
              'description' => 'Teo Kabakchiev, a world-renowned hard enduro rider, leads Kenduro.com with an unwavering passion, ensuring our unwavering commitment to top-tier services and quality.'
            ]);

            // echo do_shortcode('[products limit="12" columns="5" best_selling="true"]');
          ?>
        </div>
      </div>
    </div>
    
    <?php 
      Load::molecules('exclusive-brands/index');
      Load::molecules('best-selling-products/index'); 
			// echo do_shortcode('[recently_viewed_products]');
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');
get_footer('shop');
