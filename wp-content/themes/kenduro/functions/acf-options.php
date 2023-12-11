<?php
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'    => 'SmartSuite',
    'menu_title'    => 'SmartSuite',
    'menu_slug'     => 'smartsuite',
    'capability'    => 'edit_posts',
    'redirect'      => false
  ));

  acf_add_options_sub_page(array(
    'page_title'    => 'Fields',
    'menu_title'    => 'Fields',
    'parent_slug'   => 'smartsuite',
  ));
}
