<?php

// use Lean\Load;

// $chosenCat = '';
// $args = array(
//   'taxonomy' => 'product_cat',
//   'parent' => 0,
//   'hide_empty' => true
// );
// $main_categories = get_terms($args);
$featured_product_ID = get_field('featured_product', 'options');
$main_menu_class = is_array($featured_product_ID) ? 'has-featured-product' : '';
delete_transient('wp_nav_menu_cached');
$cache_key = wp_is_mobile() ? 'wp_nav_menu_cached_mobile' : 'wp_nav_menu_cached_desktop';
// Опит за извличане на кешираните категории
$wp_nav_menu = get_transient($cache_key);

if (false === $wp_nav_menu) {
  // echo 'Кешът не е наличен. Извличам от базата данни.<br>';

  $wp_nav_menu = wp_nav_menu(
    array(
      'theme_location'  => 'primary',
      'container_class' => 'primary-navigation',
      'menu_class' => 'main-menu '.$main_menu_class,
      'items_wrap' => '<div id="mobile-nav" class="mobile-nav">' .
        '<div class="sub-menu-head-mobile">' .
        '<div class="sub-menu-head-mobile__close"></div>' .
        '<div class="sub-menu-head-mobile__cat"></div>' .
        '</div>' .
        '<div class="mobile-nav__search">' .
        '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">' .
        '<g clip-path="url(#clip0_397_16058)">' .
        '<path d="M6.84199 0C10.6145 0 13.684 3.06949 13.684 6.84199C13.6836 8.36043 13.1751 9.83508 12.2395 11.031L15.9991 14.7907L14.7898 16L11.0301 12.2403C9.83434 13.1755 8.36004 13.6837 6.84199 13.684C3.06949 13.684 0 10.6145 0 6.84199C0 3.06949 3.06949 0 6.84199 0ZM6.84199 1.7105C4.01197 1.7105 1.7105 4.01197 1.7105 6.84199C1.7105 9.67201 4.01197 11.9735 6.84199 11.9735C9.67201 11.9735 11.9735 9.67201 11.9735 6.84199C11.9735 4.01197 9.67201 1.7105 6.84199 1.7105ZM4 4.85866C5.32991 3.71378 7.63727 3.71378 8.96806 4.85866C9.29579 5.13914 9.55572 5.4728 9.73285 5.84035C9.90997 6.20789 10.0008 6.60204 10 7H8.24201C8.24201 6.59717 8.0583 6.21706 7.72517 5.92933C7.06065 5.35841 5.90917 5.35689 5.24114 5.93084L4 4.85866Z" fill="#6F7173"/>' .
        '</g>' .
        '<defs>' .
        '<clipPath id="clip0_397_16058">' .
        '<rect width="16" height="16" fill="white"/>' .
        '</clipPath>' .
        '</defs>' .
        '</svg>' .
        '</div>' .
        '<div class="mobile-nav__logo">' .
        '<a href="https://kenduro.com" aria-label="Kenduro logo"></a>' .
        '</div>' .
        '<div class="mobile-nav__close">' .
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' .
        '<path d="M5.41406 4L4 5.41406L10.293 11.707L4 18L5.41406 19.4141L11.707 13.1211L18 19.4141L19.4141 18L13.1211 11.707L19.4141 5.41406L18 4L11.707 10.293L5.41406 4Z" fill="#6F7173"/>' .
        '</svg>' .
        '</div></div><ul id="%1$s" class="%2$s">%3$s</ul>',
      'echo' => false
    )
  );

  if (!empty($wp_nav_menu)) {
    // Запис на резултата в кеша за 1 час (3600 секунди)
    set_transient($cache_key, $wp_nav_menu, 3600);

    // echo 'Кешът е запазен.<br>';
  } else {
    // echo 'get_terms() не върна резултати.<br>';
  }
} else {
  // echo 'Кешът е наличен. Зареждам от кеша.<br>';
  // var_dump($main_categories); // Показва кешираните данни
}
?>
<div id="bottom-section" class="storefront-primary-navigation">
  <div class="container">
    <div class="row">
      <div class="col">
        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'storefront' ); ?>">
          <button id="site-navigation-menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_html( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
          <?php echo $wp_nav_menu; ?>
        </nav><!-- #site-navigation -->
      </div>
    </div>
  </div>
</div>