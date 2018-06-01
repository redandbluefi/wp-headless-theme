<?php

/**
 * Custom preview link generation
 */
function headless_post_preview_link($preview_link, $post) {
  $postStatus = get_post_status($post->ID);
  $lang = pll_current_language('slug');
  // $nonce = wp_create_nonce('wp_rest');

  if ($postStatus != 'draft' && $postStatus != 'auto-draft') {
    // Preview URL for all published posts
    return home_url().'/'.$lang.'/'.get_page_uri($post->ID);
  } else {
    // Preview URL for all posts which are in draft
    return home_url().'/'.$lang.'/?preview='.$post->ID;
  }
}

add_filter('preview_post_link', 'headless_post_preview_link', 10, 2);
