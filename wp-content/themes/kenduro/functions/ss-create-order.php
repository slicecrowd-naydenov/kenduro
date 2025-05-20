<?php

function create_record_curl($appId, $dataBody, $bulk) {
  $url = 'https://app.smartsuite.com/api/v1/applications/' . $appId . '/records/' . $bulk;

  $headers = array(
    'Content-Type: application/json',
    'Authorization: Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
    'ACCOUNT-ID: sd0y91s2'
  );

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataBody));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    return new WP_Error('api_error', 'Error fetching data from API: ' . curl_error($ch), array('status' => 500));
  }

  curl_close($ch);
  
  return json_decode($response, true);
}

function create_prim_sales_curl($dataBody) {
  $url = 'https://test-kenduro.demo.prim.io/api/RPC.common.Api.So.set?token=8de195ad6e1e584513f5f6c392e8c239';

  $headers = array(
    'Content-Type: application/json'
  );

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataBody));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    return new WP_Error('api_error', 'Error fetching data from API: ' . curl_error($ch), array('status' => 500));
  }

  curl_close($ch);
  
  return json_decode($response, true);
}