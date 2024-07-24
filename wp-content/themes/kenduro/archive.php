<?php

use Lean\Load;

/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header();
$current_cat = get_category( get_query_var( 'cat' ) );
$cat_id = $current_cat->cat_ID;
$is_blog_cat = $current_cat->name === 'Блог' ? 'active' : '';

?>
<div id="primary">
	<div class="blog-hero">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="wrapper woocommerce-checkout">
						<div class="left">
							<h1>Кендуро Блог</h1>
							<p class="paragraph paragraph-xl">Бъди информиран за всичко в ендурото</p>
						</div>
						<div class="right woocommerce">
							<div class="wpcf7 js">
								<div id="omnisend-embedded-v2-66a0d83c1b6b3377bbd50c3f"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="blog-content">
		<?php
		if (have_posts()) : ?>

			<!-- <h1 class="archive-title"><?php // echo single_cat_title('', false); 
																			?>:</h1> -->
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="posts-nav">
							<ul class="nav nav-pills dropdown-menu">
								<li class="nav-item" role="presentation">
									<?php 
									?>
									<a 
										href="<?php echo esc_url(get_site_url()); ?>/blog/" 
										title="blog"
										class="paragraph paragraph-l nav-link <?php echo $is_blog_cat; ?>"
									>Всички</a>
								</li>
								<?php

								$categories = get_categories();
								foreach ($categories as $category) {
									// $featured_image_id = get_term_meta( $category->term_id, 'featured_image_id', true );
									// $category_image = wp_get_attachment_image( $featured_image_id, 'thumbnail' );
									if ($category->cat_ID !== 1 && $category->name !== "Блог") {
										$category_link = get_category_link( $category->term_id );
										$active_cat = $cat_id === $category->cat_ID ? 'active': '';
								?>
								<li class="nav-item" role="presentation">
									<a 
										href="<?php echo esc_url( $category_link ); ?>" 
										title="<?php echo esc_attr($category->name);?>"
										class="paragraph paragraph-l nav-link <?php echo $active_cat; ?>"
									><?php echo $category->name;?></a>
								</li>
								<?php
									}
								}
								?>
							</ul>							
							<div id="search-field" class="search-field">
								<input type="text" placeholder="Търси в Кендуро Блог">
							</div>
						</div>
						<div id="main">
							<div id="search-results">
								<ul class="blog-post-list">

									<?php $count = 1;
									while (have_posts()) : the_post(); ?>
										<li class="blog-post-list__item">
											<a href="<?php echo esc_attr(the_permalink()); ?>">
												<?php
												if (has_post_thumbnail()) {
													$thumb_size = $count === 1 ? 'full' : 'medium_large';
												?>
													<div class="thumb">
														<?php if ($count === 1) : ?>
															<p class="paragraph paragraph-m semibold newest-blog-article">Най-новото от Кендуро Блог</p>
														<?php endif;
														the_post_thumbnail($thumb_size); 
														?>
													</div>
												<?php
												}
												?>
												<div class="title-wrapper">
													<?php
													echo '<p class="paragraph paragraph-xl semibold post-title">' . get_the_title() . '</p>';
													// get the post content     
													if ($count === 1) {
														$content = get_the_content(); ?>
														<?php
														// get the first 80 words from the content and added to the $abstract variable
														preg_match('/^([^.!?\s]*[\.!?\s]+){0,120}/', strip_tags($content), $abstract);
															// pregmatch will return an array and the first 80 chars will be in the first element 
															echo '<p class="paragraph paragraph-l post-excerpt">' . $abstract[0] . '...</p>';
													} else {
														echo '<p class="paragraph paragraph-l post-excerpt">' . get_the_excerpt() . '</p>';
													}
													?>
													<span class="learn-more">
														Виж повече
														<?php Load::atom('svg', ['name' => 'arrow_orange']); ?>
													</span>
												</div>
											</a>
										</li>
									<?php $count++;
									endwhile; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
