<?php

/**
 * The main template.
 */

get_header();

if (have_posts()) :
	/* Start the Loop */
	while (have_posts()) :
		the_post();
?>
		<a href="#" id="createProducts">create Products</a>
		</br>
		<a href="#" id="createCategories">create Categories</a>
		</br>
		<a href="#" id="productFields">Product fields</a>
		</br>
		<a href="#" id="filterFields">Filter fields</a>
		</br>
		<a href="#" id="filterValues">Filter values</a>
		</br>
		<a href="#" id="createFilters">create Filters</a>

<?php
	endwhile; // End of the loop.
endif;

get_footer();
