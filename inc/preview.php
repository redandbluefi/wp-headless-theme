<?php

/**
 * Custom preview link generation
 */
function headless_post_preview_link($preview_link, $post) {
  $postStatus = get_post_status($post->ID);
  $nonce = wp_create_nonce('wp_rest');

  if ($postStatus != 'draft' && $postStatus != 'auto-draft') {
    // Preview URL for all published posts
    return home_url()."?preview_id=".$post->ID.'&nonce='.$nonce;
  } else {
    // Preview URL for all posts which are in draft
    return home_url()."?custom_preview=".$post->ID.'&nonce='.$nonce;
  }
}

add_filter('preview_post_link', 'headless_post_preview_link', 10, 2);
