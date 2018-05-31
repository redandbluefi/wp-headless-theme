<?php

// Modify the page response for ACF to REST page endpoint
add_filter('acf/rest_api/page/get_items', function($response, $request) {
  $data = array();

  foreach ($response->get_data() as $json) {
    // Get the whole page object, with slugs and everything
    $page = get_page($json['id']);

    // Add also the basic ACF to REST fields
    $page->acf = $json['acf'];

    array_push($data, $page);
  }

  return $data;
}, 50, 2);
