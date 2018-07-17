<?php


// img unautop
function img_unautop($pee) {
    $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<div class="figure">$1</div>', $pee);
    return $pee;
}
add_filter( 'acf_the_content', 'img_unautop', 30 );

//Use large images by default
function my_default_image_size () {
    return 'large'; 
}

add_filter( 'pre_option_image_default_size', 'my_default_image_size' );
?>