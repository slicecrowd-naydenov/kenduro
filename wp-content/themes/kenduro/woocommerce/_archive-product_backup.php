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

if ( is_tax( 'pa_brand' ) ) {
	$term = get_queried_object();
	$term_id = $term->term_id;
	$meta_fields = get_term_meta($term_id);
	$is_exclusive = isset($meta_fields['exclusive_brand']) && $meta_fields['exclusive_brand'][0];
	$term_logo_id = $meta_fields['exclusive_logo'][0];
	$term_banner_id = $meta_fields['exclusive_banner'][0];
	$brand_description = $meta_fields['brand_description'][0];
	$term_logo = wp_get_attachment_url($term_logo_id);
	$term_banner = wp_get_attachment_url($term_banner_id);
	$classes = $is_exclusive ? 'exclusive' : 'no-exclusive';
}

function output_filter_modal() {
	if (wp_is_mobile()) {
		?>
		<!-- Button trigger modal -->
		<button type="button" class="button filter-modal" data-toggle="modal" data-target="#filterModal">
			Филтри
		</button>

		<!-- Modal -->
		<div class="modal fade mobile-modal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Филтри</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<?php Load::atom('svg', ['name' => 'close']); ?>
						</button>
					</div>
					<div class="modal-body">
						<?php
							Load::molecules('product-category/product-categories-filter/index');
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {
		Load::molecules('product-category/product-categories-filter/index');
	}
}


?>
<div class="container">
	<div class="row">
		<div class="col">
			
		<?php




$args = array(
	'post_type'      => 'product',
	'posts_per_page' => -1,
	'tax_query' => array(
		array(
			'taxonomy' => 'pa_brand',
			'field' => 'slug',
			'terms' => 'hebo'
		)
	)
);

// pretty_dump($_GET);

$products_query = new WP_Query($args);

$product_ids = array();
if ($products_query->have_posts()) {
	while ($products_query->have_posts()) {
		$products_query->the_post();
		$product_ids[] = get_the_ID();
	}
}
// Reset post data
wp_reset_postdata();
// pretty_dump(wp_get_term_taxonomy_parent_id(2417, 'product_cat'));
// Step 2: Get categories associated with the product(s)
$main_categories = array();
$child_categories = array();
// $wp_terms = array();
foreach ($product_ids as $product_id) {
	$terms = wp_get_post_terms($product_id, 'product_cat');

	foreach ($terms as $term) {
		// pretty_dump($term)
		// pretty_dump($term->name . ' / id: ' . $term->term_id . ' / parent_id: ' . $term->parent);

		// if (in_array($term['parent'], $categories)) {

		// }
		// $categories[] = $term->term_id;
		// $wp_terms[] = $term;
		if ($term->parent === 0) {
			$main_categories[] = $term->term_id;
			// $term->name . ' / id: ' . $term->term_id . ' / parent_id: ' . $term->parent;
		} else {
			$child_categories[] = $term->term_id; // Добавяне на подкатегориите в $sub_categories
		}
	}
}
// Remove duplicate categories
$main_categories = array_unique($main_categories);
// pretty_dump($main_categories);
$child_categories = array_unique($child_categories);

// pretty_dump($child_categories);
// pretty_dump(get_queried_object());

?>





			<?php
			if (is_product_category()) :
				if (category_has_parent()) :
					woocommerce_breadcrumb();
				endif;
			endif;

			if ( is_tax( 'pa_brand' ) ) { ?>
				<div class="custom-breadcrumb">
					<a href="<?php echo esc_attr(get_site_url().'/brands')?>" class="paragraph paragraph-l">Производители</a>
					<span>/</span>
				</div>
			<?php } ?>
			<header>
				<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
					<!-- .woocommerce-products-header__title -->
					<h4 class="page-title semibold <?php echo esc_attr($classes); ?>">
						<?php woocommerce_page_title(); 
						
						if (is_tax( 'pa_brand' ) && $is_exclusive) : ?>
							<p class="paragraph paragraph-m regular exclusive-banner">
								<?php Load::atom('svg', ['name' => 'star-filled']); ?>
								Ексклузивен партньор
							</p>
						<?php endif;?>
					</h4>
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

			if ( !is_tax( 'pa_brand' ) ) {
				if (is_product_category()) {
					Load::molecules('product-category/product-category-info/index', [
						'title' => 'Научете повече за ',
						'class' => 'full-container',
						'description' => 'Разгледайте детайлно нашите продукти от тази категория.',
						'cat' => single_term_title('', false),
						'cat_img_inner' => $cat_inner_image_url
					]);
					?>
					<div class="mobile-wrapper">
					<?php
					Load::molecules('product-category/product-categories-view/index');
					?>
					</div>
					<?php
				} else {
					if (!is_search()) {
						Load::molecules('product-category/product-category-info/index', [
							'title' => 'Всички продукти',
							'class' => 'full-container',
							'description' => 'Научете повече за нашите продукти.',
							'cat' => single_term_title('', false),
							'cat_img_inner' => $cat_inner_image_url
						]);
						Load::molecules('product-category/product-categories-view/index');
					}
				}
			} else {
				// Brand Tax page
				?>

				<div class="brand-info <?php echo esc_attr($classes); ?>">
					<div class="brand-info__image">
						<div class="brand-info__logo">
							<img src="<?php echo esc_attr($term_logo)?>" />
						</div>
						<img src="<?php echo esc_attr($term_banner)?>" />
					</div>
					<div>
						<div class="brand-info__description collapse paragraph paragraph-l" id="collapseSummary">
							<?php 
							echo $brand_description; ?>
						</div>
						<a class="collapsed paragraph paragraph-l" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
					</div>
				</div>
				<?php Load::molecules('product-category/product-categories-view/index'); 


			}

			if (is_search()) { ?>
				<div class="mobile-wrapper">
					<?php output_filter_modal(); ?>
				</div>
				<?php
			}
			?>
			<div class="filter-content-wrapper">
				<div class="filter-sidebar">
					
<p class="paragraph paragraph-xl semibold">Основни категории</p>
<ul class="custom_cat_filters">
<li>
			<a href="<?php echo get_site_url().'/brand/hebo/' ?>">Всички</a>
		</li>
<?php
$child_cat_IDS = array();
// $sub_child_cat_IDS = array();
foreach ($main_categories as $main_cat) {
	foreach ($child_categories as $child_cat) {
		$child = get_term_by('id', $child_cat, 'product_cat');
		$term = get_queried_object();

		// pretty_dump('$child_cat = ' . $child_cat . ' / $child->parent = ' . $child->parent  . ' / $term->term_id = ' . $term->term_id . ' / $main_cat : ' . $main_cat);


		if ($child->parent === $term->term_id) {
			$child_cat_IDS[] = $child_cat;
		} 
		// else if ($child_cat !== $child->parent && $child->parent !== $term->term_id) {
		// 	$sub_child_cat_IDS[] = $child_cat;
		// }
	}

	$term = get_term_by('id', $main_cat, 'product_cat');
	?>
		<li>
			<a href="<?php echo get_site_url().'/brand/hebo/?product_cat='.$term->slug; ?>"><?php echo $term->name; ?></a>
		</li>
	<?php
}
$child_cat_IDS = array_unique($child_cat_IDS);

// pretty_dump(array_unique($sub_child_cat_IDS));
?>
</ul>

<?php if ($child_cat_IDS) : 
		$term = get_queried_object();	
	?>
<p class="paragraph paragraph-xl semibold"><?php echo $term->name; ?></p>

<ul class="custom_cat_filters">
<?php
foreach ($child_cat_IDS as $child_cat) {
	$term = get_term_by('id', $child_cat, 'product_cat');

	// foreach ($child_categories as $c) {
	// 	$child = get_term_by('id', $c, 'product_cat');
	// 	$term = get_queried_object();


	// 	if ($child->parent === $term->term_id) {
	// 		$sub_child_cat_IDS[] = $c;
	// 	}
	// }
	
	?>
		<li>
			<a href="<?php echo get_site_url().'/brand/hebo/?product_cat='.$term->slug; ?>"><?php echo $term->name; ?></a>
		</li>
	<?php
}
?>
</ul>

<?php endif; 
// pretty_dump(array_unique($sub_child_cat_IDS));
echo do_shortcode('[wpf-filters id=1]');
// echo do_shortcode('[yith_wcan_filters slug="sidebar-filters"]'); 
?>

				</div>
				<?php
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

			?>
			</div>

<?php

			// echo do_shortcode('[wrvp_recently_viewed_products number_of_products_in_row="4" posts_per_page="4"]');
            Load::molecules('product-category/product-category-info/index', [
              'title' => '<span class="highlighted">K</span>enduro е изработен от Teo',
              'class' => 'full-width-container',
              'description' => 'Тео Кабакчиев, световноизвестен хард ендуро състезател, ръководи Kenduro.com с непоколебима страст, гарантирайки нашия непоколебим ангажимент към услуги и качество от най-високо ниво.'
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
