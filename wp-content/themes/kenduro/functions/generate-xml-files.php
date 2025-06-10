<?php
// Генериране на xml файлове за Luigisbox

// Генериране на xml файл за Brands:
function generate_brand_feed_file() {
  $upload_dir = wp_upload_dir();
  $file_path = $upload_dir['basedir'] . '/feeds/brands.xml';

  if (!file_exists(dirname($file_path))) {
      wp_mkdir_p(dirname($file_path));
  }

  $terms = get_terms([
      'taxonomy'   => 'pa_brand',
      'hide_empty' => false,
  ]);

  ob_start();
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<brands>\n";

  foreach ($terms as $term) {
    $id = esc_xml($term->term_id);
    $name = esc_xml($term->name);
    $url = esc_xml(get_term_link($term));

    echo "  <brand>\n";
    echo "    <identity>{$id}</identity>\n";
    echo "    <name><![CDATA[{$name}]]></name>\n";
    echo "    <url>{$url}</url>\n";
    echo "  </brand>\n";
  }

  echo "</brands>\n";

  $xml = ob_get_clean();
  file_put_contents($file_path, $xml);
}


// Генериране на xml файл за Categories:
function generate_category_feed_file() {
  $upload_dir = wp_upload_dir();
  $file_path = $upload_dir['basedir'] . '/feeds/categories.xml';

  if (!file_exists(dirname($file_path))) {
    wp_mkdir_p(dirname($file_path));
  }

  $terms = get_terms([
      'taxonomy'   => 'product_cat',
      'hide_empty' => false,
  ]);

  ob_start();
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<categories>\n";

  foreach ($terms as $term) {
    $id = esc_xml($term->term_id);
    $name = esc_xml($term->name);
    $url = esc_xml(get_term_link($term));
    $hierarchy = esc_xml(get_category_hierarchy($term));

    echo "  <category>\n";
    echo "    <identity>{$id}</identity>\n";
    echo "    <name><![CDATA[{$name}]]></name>\n";
    echo "    <url>{$url}</url>\n";
    if ($hierarchy) {
        echo "    <hierarchy><![CDATA[{$hierarchy}]]></hierarchy>\n";
    }
    echo "  </category>\n";
  }

  echo "</categories>\n";

  $xml = ob_get_clean();
  file_put_contents($file_path, $xml);
}


function get_category_hierarchy($term) {
  $ancestors = get_ancestors($term->term_id, 'product_cat');
  if (empty($ancestors)) return '';

  $ancestors = array_reverse($ancestors);
  $names = [];

  foreach ($ancestors as $ancestor_id) {
    $ancestor = get_term($ancestor_id, 'product_cat');
    $names[] = $ancestor->name;
  }

  return implode(' | ', $names);
}




// Генериране на xml файл за Products:
// 1. Основна функция за генериране на XML фийда
if (!function_exists('generate_products_feed_file')) {
  function generate_products_feed_file() {
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/feeds/products.xml';

    if (!file_exists(dirname($file_path))) {
      wp_mkdir_p(dirname($file_path));
    }

    ob_start();
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<items>\n";

    $args = [
      'post_type'      => ['product'],
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'meta_value_num',
      'meta_key'       => '_price',
      'order'          => 'DESC',
      'fields'         => 'ids',
    ];

    $loop = new WP_Query($args);
    foreach ($loop->posts as $product_id) {
      $product = wc_get_product($product_id);
      if (!$product || !$product->get_sku()) continue;

      $id          = esc_xml($product->get_id());
      $sku         = esc_xml($product->get_sku());
      $title       = esc_xml($product->get_name());
      $url         = esc_url(get_permalink($product->get_id()));
      $price       = wc_get_price_to_display($product);
      $regular_price = $product->get_regular_price();
      $price_old = ($regular_price !== '' && $regular_price !== null) ? $regular_price : $price;
      $description = esc_xml($product->get_description());
      $brand       = esc_xml($product->get_attribute('pa_brand'));
      $color       = esc_xml($product->get_attribute('pa_6501a4062d14b1261118e548'));
      $color       = $color ? $color : '';
      if (str_contains($color, '/')) {
        [$color_primary, $color_secondary] = array_map('esc_xml', array_map('trim', explode('/', $color, 2)));
      } else {
        $color_primary   = esc_xml($color);
        $color_secondary = ''; // няма вторичен цвят
      }
      $image_id = $product->get_image_id();
      $image_s_url = esc_url(
        $image_id ? wp_get_attachment_image_src($image_id, 'woocommerce_gallery_thumbnail')[0] : wc_placeholder_img_src('woocommerce_gallery_thumbnail')
      );
      $image_m_url = esc_url(
        $image_id ? wp_get_attachment_image_src($image_id, 'medium')[0] : wc_placeholder_img_src('medium')
      );
      $image_l_url = esc_url(
        $image_id ? wp_get_attachment_image_src($image_id, 'woocommerce_single')[0] : wc_placeholder_img_src('woocommerce_single')
      );
      $ean         = esc_xml($product->get_attribute('ean'));
      $to_cart_id  = $product->get_id();
      $group_id    = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();
      $introduced_at = get_the_date('Y-m-d', $product->get_id());

      // Категории
      $categories   = wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'all']);
      $hierarchies = [];

      foreach ($categories as $term) {
          $hierarchy = get_product_category_hierarchy($term);
          if ($hierarchy) {
              $hierarchies[$hierarchy] = substr_count($hierarchy, '|'); // дълбочина
          }
      }

      // Сортирай по дълбочина: най-дълбоката първа
      arsort($hierarchies);

      // Премахни вложени/дублиращи се йерархии
      $cleaned = [];
      foreach (array_keys($hierarchies) as $candidate) {
          $is_nested = false;
          foreach ($cleaned as $existing) {
              if (str_starts_with($candidate, $existing . ' |')) {
                  $is_nested = true;
                  break;
              }
          }
          if (!$is_nested) {
              $cleaned[] = $candidate;
          }
      }

      // Генерирай XML
      $cat_output = '';
      $primary_set = false;
      foreach ($cleaned as $hierarchy) {
        $primary = !$primary_set ? ' primary="true"' : '';
        $cat_output .= "    <category{$primary}><![CDATA[{$hierarchy}]]></category>\n";
        $primary_set = true;
      }

      // Атрибути (параметри)
      $param_output = '';
      foreach ($product->get_attributes() as $attribute) {
        if (is_a($attribute, 'WC_Product_Attribute') && $attribute->is_taxonomy()) {
          $name   = wc_attribute_label($attribute->get_name());
          $values = wc_get_product_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names']);
          if (!empty($values)) {
            $param_output .= "      <param>\n";
            $param_output .= "        <name><![CDATA[{$name}]]></name>\n";
            $param_output .= "        <value><![CDATA[" . implode(', ', $values) . "]]></value>\n";
            $param_output .= "      </param>\n";
          }
        }
      }

      echo "  <item>\n";
      echo "    <identity>{$id}</identity>\n";
      echo "    <title><![CDATA[{$title}]]></title>\n";
      echo "    <url>{$url}</url>\n";
      echo "    <item_group_id>{$group_id}</item_group_id>\n";
      echo "    <availability>1</availability>\n";
      echo "    <availability_rank>3</availability_rank>\n";
      echo "    <availability_rank_text><![CDATA[In external warehouse / Ships within 5 days]]></availability_rank_text>\n";
      echo $cat_output;
      echo "    <brand><![CDATA[{$brand}]]></brand>\n";
      echo "    <color><![CDATA[{$color}]]></color>\n";
      echo "    <color_primary><![CDATA[{$color_primary}]]></color_primary>\n";
      echo "    <color_secondary><![CDATA[{$color_secondary}]]></color_secondary>\n";
      echo "    <price>{$price}</price>\n";
      echo "    <price_old>{$price_old}</price_old>\n";
      echo "    <image_link_s>{$image_s_url}</image_link_s>\n";
      echo "    <image_link_m>{$image_m_url}</image_link_m>\n";
      echo "    <image_link_l>{$image_l_url}</image_link_l>\n";
      echo "    <description><![CDATA[{$description}]]></description>\n";
      echo "    <labels><![CDATA[Summer sale, Free shipping]]></labels>\n";
      echo "    <product_code>{$sku}</product_code>\n";
      echo "    <ean>{$ean}</ean>\n";
      echo "    <to_cart_id>{$to_cart_id}</to_cart_id>\n";
      echo "    <margin>0.42</margin>\n";
      echo "    <boost>1</boost>\n";
      echo "    <introduced_at>{$introduced_at}</introduced_at>\n";
      echo "    <parameters>\n{$param_output}    </parameters>\n";
      echo "  </item>\n";
    }

    echo "</items>\n";
    wp_reset_postdata();

    $xml = ob_get_clean();
    file_put_contents($file_path, $xml);
  }
}

// 2. Хелпър за йерархията на категориите
if (!function_exists('get_product_category_hierarchy')) {
  function get_product_category_hierarchy($term) {
    if (is_wp_error($term) || !$term instanceof WP_Term) {
      return '';
    }

    $hierarchy = [$term->name];

    while ($term->parent != 0) {
      $term = get_term($term->parent, 'product_cat');
      if (is_wp_error($term)) break;
      array_unshift($hierarchy, $term->name);
    }

    return implode(' | ', $hierarchy);
  }
}

// 3. Ескейпване на XML символи
if (!function_exists('esc_xml')) {
  function esc_xml($string) {
    return htmlspecialchars($string, ENT_XML1 | ENT_QUOTES, 'UTF-8');
  }
}

// 4. Ръчно генериране през URL: /?generate_luigisbox_feed=1
add_action('init', function () {
  if (isset($_GET['generate_luigisbox_feed']) && current_user_can('manage_options')) {
    generate_products_feed_file();
    generate_brand_feed_file();
    generate_category_feed_file();
    wp_die('Luigi’s Box Feeds generated.');
  }
});
