<?php
add_filter('mce_buttons_2', function($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
});

add_filter('tiny_mce_before_init', function($init_array) {
  $style_formats = array(
    // Each array child is a format with it's own settings
    [
      'title' => 'Quote',
      'block' => 'blockquote',
      'classes' => 'quote',
      'wrapper' => true,
    ],

    [
      "title" => "Smaller text",
      "inline" => "small",
      "classes" => "smaller",
    ],

    [
      "title" => "Button",
      "classes" => "button",
      "inline" => "a",
    ],
  );

  $init_array['style_formats'] = json_encode($style_formats);
  return $init_array;
});
