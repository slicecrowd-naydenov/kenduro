<?php
use Lean\Load;

/**
 * The template for displaying all single posts
 */

get_header();

if (have_posts()) {
	while (have_posts()) {
	
		$featured_posts = get_field('suggested_products');
		if( $featured_posts ): 
			$ids = array(); 
			foreach( $featured_posts as $post ): 
				setup_postdata($post);
				$ids[] = $post;
			endforeach;

			$random_ids = array_rand($ids, 2);
    	$selected_ids = $ids[$random_ids[0]] . ',' . $ids[$random_ids[1]];
				// Reset the global post object so that the rest of the page works correctly.
			wp_reset_postdata();
		endif;
?>

	<div id="primary">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="single-content-wrapper">
						<div class="featured-image">
							<?php the_post_thumbnail(); ?>
						</div>
						<div class="content-wrapper woocommerce-checkout">
							<div class="content">
								<div class="content-nav">
									<div class="post-category">
										<a href="<?php echo esc_attr(get_site_url().'/blog'); ?>" class="post-category__main">Блог</a>
										<?php 
											$allcategory = get_the_category(); 
											foreach ($allcategory as $category) {
												if ($category->cat_name !== 'Блог') {
										?>
													<a class="post-category__secondary" href="<?php echo esc_attr(get_category_link($category->term_id)); ?>">#<?php echo $category->cat_name; ?></a>
										<?php 
												}
											}
										?>
									</div>
									<div class="share-box">
										<p class="paragraph paragraph-l">Сподели:</p>
										<?php echo do_shortcode('[addtoany]');?>
									</div>
								</div>

								<h1 class="bold"><?php the_title(); ?></h1>
								<?php
								the_post();
								the_content();
								?>
							</div>
							<div class="sidebar woocommerce">
								<div class="wpcf7 js">
									<div id="omnisend-embedded-v2-66a0d83c1b6b3377bbd50c3f"></div>
								</div>
								<h4 class="sidebar__title semibold">Разгледай също</h4>

								<?php
								$current_post_id = get_the_ID(); // Вземете ID на текущия пост

								$current_post_categories = get_the_category($current_post_id); // Вземете категорията на текущия пост

								if (!empty($current_post_categories)) {
								?>
									<ul class="blog-post-list">
										<?php
										$current_category_id = $current_post_categories[0]->term_id;

										// Създайте WP Query за връщане на постовете в същата категория, без текущия пост
										$args = array(
											'category__in' => array($current_category_id), // Използвайте ID на текущата категория
											'post__not_in' => array($current_post_id), // Изключете текущия пост
											'posts_per_page' => 3 // Връщайте всички постове в категорията
										);

										$related_posts_query = new WP_Query($args);

										// Проверка дали има постове
										if ($related_posts_query->have_posts()) {
											while ($related_posts_query->have_posts()) { ?>
												<li>
													<?php $related_posts_query->the_post(); ?>
													<a href="<?php echo esc_attr(the_permalink()); ?>">
														<?php
														if (has_post_thumbnail()) {
															?>
																<div class="thumb">
																	<?php the_post_thumbnail('medium_large'); ?>
																</div>
															<?php
															}

														echo '<p class="paragraph paragraph-xl semibold post-title">' . get_the_title(get_post()->ID) . '</p>';
														// Извеждане на описание
														echo '<p class="paragraph paragraph-l post-excerpt">' . get_the_excerpt(get_post()->ID) . '</p>';
														?>
														<span class="learn-more">
															Виж повече
															<?php Load::atom('svg', ['name' => 'arrow_orange']); ?>
														</span>
													</a>
												</li>
										<?php
											}
										}

										// Възстановете оригиналния Query
										wp_reset_postdata();
										?>
									</ul>

								<?php
								}


								?>
								<h4 class="sidebar__title semibold">От Кендуро с любов ❤️</h4>
								<?php echo do_shortcode('[products limit="2" columns="1" ids="'.$selected_ids.'"]')?>

							</div>
						</div>
						<?php
							Load::molecules('product-category/product-category-info/index', [
								'title' => '<span class="highlighted">K</span>enduro е изработен от Teo',
								'class' => 'full-width-container',
								'description' => 'Тео Кабакчиев, световноизвестен хард ендуро състезател, ръководи Kenduro.com с непоколебима страст, гарантирайки нашия непоколебим ангажимент към услуги и качество от най-високо ниво.'
							]);

							?>
					</div>
				</div>
			</div>
		</div>
		<?php Load::molecules('best-selling-products/index');  ?>
		
	</div>
<?php
	}
}
get_footer();
