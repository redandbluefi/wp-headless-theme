<?php

function bodybuilder_register_settings() {
  if (function_exists("acf_add_options_page")) {
    $parent = acf_add_options_page([
      'page_title' => 'Sivuston asetukset',
      'menu_slug' => 'acf-opts',
    ]);


    if (function_exists('pll_languages_list')) {
      $names = pll_languages_list([
        'fields' => 'name',
      ]);

      foreach ($names as $name) {
        $fields = [
          'page_title' => $name,
          'menu_title' => $name,
          'post_id' => $name,
          'parent_slug' => $parent['menu_slug'],
        ];
        acf_add_options_sub_page($fields);
      }
    }
  }
}

add_action('plugins_loaded', 'headless_register_settings');
