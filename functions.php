<?php

// Admin settings
require_once 'inc/admin.php';

// Post/page preview link
require_once 'inc/preview.php';

// REST API endpoints
require_once 'inc/rest.php';

// CORS handling
require_once 'inc/cors.php';

// function my_acf_load_value($value, $post_id, $field) {
//   // TODO Check if automatic is checked, fetch only when automatic
//
//   // Get the parent (module) for this news field
//   // $parent = get_field_object($field['parent'], $post_id);
//
//   // $args = array(
//   //   'post_type' => 'post',
//   //   'lang' => 'fi'
//   // );
//   //
//   // $query = new WP_Query($args);
//   // return $query->get_posts();
//
//   $args = array(
//     'posts_per_page'   => 5,
//     'showposts'        => 5,
//     'offset'           => 0,
//     'orderby'          => 'date',
//     'order'            => 'DESC',
//     'post_type'        => 'post',
//     'post_status'      => 'publish',
//     'suppress_filters' => true,
//     'lang' => 'fi'
//   );
//
//   $posts = get_posts($args);
//   // array_push($posts, pll_get_post(150, 'en'));
//   // array_push($posts, pll_get_post(153, 'fi'));
//
//   return $posts;
// }
//
// add_filter('acf/load_value/key=field_5b176bdc98ac3', 'my_acf_load_value', 10, 3);
