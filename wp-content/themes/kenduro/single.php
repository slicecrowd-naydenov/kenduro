<?php
/**
 * The template for displaying all single posts
 */

get_header();

?>

<div id="primary">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="single-content-wrapper">
					<div class="featured-image">
						<?php the_post_thumbnail(); ?>
					</div><!-- .featured-image -->
					<div class="content-wrapper">
						<div class="content">
							<div class="content-nav">
								<?php woocommerce_breadcrumb(); ?>
								<div class="share-box">
									<p class="paragraph paragraph-l">Сподели:</p>
									<ul>
										<li>
											<a href="#">F</a>
										</li>
										<li>
											<a href="#">C</a>
										</li>
									</ul>
								</div>
							</div>

							<h1 class="bold"><?php the_title(); ?></h1>
							<?php 
							the_post();
							the_content();
							?>
						</div>
						<div class="siderbar">
							Sidebar
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

get_footer();