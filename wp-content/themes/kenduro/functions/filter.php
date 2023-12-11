<?php 
use Lean\Load;

// function get_active_filters($data) {
//   $result = array(
//     'categories'=> array(),
//     'attributes'=>array('5gggft6')
//   );
// }

function filter($data) {
  
  $body = json_decode($data->get_body(), true);
  $filters = count($body) === 0 ? array() : $body;

  ob_start();
  Load::organism('shop/index', $filters);
  $result = ob_get_contents();
  ob_end_clean();
  return array(
    'html'=>$result,
    // 'active_filters'=>get_active_filters($data)
  );
	
  // $q = $body['q'];

  // $response = EcontRestClient::searchCities($q);
  // return esc_html__(Load::organism('shop/index', $filters));
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'ce', '/filter', array(
    'methods' => 'POST',
    'callback' => 'filter',
    'permission_callback' => function () {return true;},
    'args' => array(
      'body' => array(
        'default' => NULL
      ) 
    )
  ) );
});
