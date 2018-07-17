<?php

/**
 * Custom preview link generation
 */
function headless_post_preview_link($preview_link, $post) {
  $postStatus = get_post_status($post->ID);
  $lang = pll_current_language('slug');
  $nonce = wp_create_nonce('bodybuilder_page_preview');
  $type = get_post_type($post);
  $url = home_url().'/'.$lang;
  if ($type === 'post') {
    $url .= '/post';
  }

  if ($postStatus != 'draft' && $postStatus != 'auto-draft') {
    // Preview URL for all published posts
    return $url.'/'.get_page_uri($post->ID);
  } else {
    // Preview URL for all posts which are in draft
    return $url.'/?preview='.$post->ID.'&token='.$nonce;
  }
}

add_filter('preview_post_link', 'headless_post_preview_link', 10, 2);
