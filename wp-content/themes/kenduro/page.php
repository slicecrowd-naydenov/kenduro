<?php

/**
 * The template for displaying all pages
 */

get_header();
?>
<div class="container">
	<div class="row">
		<div class="col">
			<?php
			if (have_posts()) :
				/* Start the Loop */
				while (have_posts()) :
					the_post();
					the_content();

				/* Page content here */

				endwhile; // End of the loop.
			endif;
			?>

		</div>
	</div>
</div>
<?php
get_footer();
