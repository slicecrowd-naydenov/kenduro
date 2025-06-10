<?php
// factory-riders.php
use Lean\Load;

get_header(); 

?>

<div id="primary" class="factory-riders">
	<div class="blog-hero">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<h1>Kenduro Factory Riders</h1>
					<p class="paragraph paragraph-xl">Виж кой е зад Кендуро.</p>
				</div>
			</div>
		</div>
	</div>
	<section class="category-posts">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<?php if (have_posts()) : ?>
						<ul class="blog-post-list">
							<?php while (have_posts()) : the_post(); ?>
									<li class="blog-post-list__item">
										<a href="<?php echo esc_attr(the_permalink()); ?>">
											<?php if (has_post_thumbnail()) : ?>
												<div class="post-thumbnail">
														<?php the_post_thumbnail('medium_large'); ?>
												</div>
											<?php endif; ?>

											<div class="title-wrapper">
													<?php
													echo '<p class="paragraph h4 semibold post-title">' . get_the_title() . '</p>';
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
							<?php endwhile; ?>
							</ul>
					<?php else : ?>
							<p>Няма публикации в тази категория.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php Load::organisms('homepage/exclusive-partners/index'); ?>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="recently-viewed-products"></div>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>