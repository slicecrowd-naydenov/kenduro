<?php 
  use Lean\Load;

  $args = wp_parse_args($args, [
    'text' => '',
    'class' => '',
    'url' => '',
    'icon' => ''
  ]);
?>
<a href="<?php echo $args['url'];?>" class="paragraph paragraph-m semibold primary custom-link <?php echo $args['class']; ?>">
  <?php 
    echo $args['text'];
    if ($args['icon']) :
      Load::atom('svg', ['name' => $args['icon']]);
    endif;
  ?>
</a>