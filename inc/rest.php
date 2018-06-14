<?php
/**
 * Bodybuilder REST class
 */
class BodyBuilder_Rest extends WP_REST_Controller {
  public function register_routes() {
    $namespace = 'bodybuilder/v1';

    register_rest_route($namespace, '/nav', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_menu')
    ));

    register_rest_route($namespace, '/site', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_site')
    ));

    register_rest_route($namespace, '/(?P<type>post|page)/(?P<id>\d+)/preview', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_preview')
    ));

    register_rest_route($namespace, '/settings', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_settings')
    ));

    register_rest_route($namespace, '/posts', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_posts')
    ));

    register_rest_route($namespace, '/categories', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_categories')
    ));
  }

  public function get_menu(WP_REST_Request $request) {
    $lang = substr($request->get_header('Accept-Language'), 0, 2);
    if ($lang === 'en') {
      $menu = wp_get_nav_menu_items('menu_en');
    }
    else {
      $menu = wp_get_nav_menu_items('menu');
    }

    // Add slug to the menu objects
    foreach ($menu as &$item) {
      $slug = str_replace(home_url(), '', $item->url);
      $slug = str_replace('/', '', $slug);
      $item->slug = $slug;
    }

    if (empty($menu)) {
      return new WP_Error('500', __('Menu not found', 'not-found'));
    }

    return $menu;
  }

  public function get_site(WP_REST_Request $request) {
    $lang = substr($request->get_header('Accept-Language'), 0, 2);

    $site = new stdClass();
    $site->menu = $this->get_menu($request);
    $site->settings = $this->get_settings($request);

    // Get the homepage ID set via settings
    $homepageId = get_option('page_on_front');
    // Then get translated version ID with Polylang, which is the actual homepage
    $locHomepageId = intval(pll_get_post($homepageId, $lang));
    $site->homepage = get_page($locHomepageId);

    if (empty($site)) {
      return new WP_Error('500', __('Error while loading data for the site', 'not-found'));
    }

    return $site;
  }

  public function get_preview(WP_REST_Request $request) {
    $postId = $request->get_param('id');
    $type = $request->get_param('type');

    // Nonce needs to be valid in order to preview
    // TODO Custom token check, because nonce will never work
    // $nonce = $request->get_param('token');
    // if (!wp_verify_nonce($nonce, 'bodybuilder_page_preview')) {
    //   return new WP_Error('403', __('Invalid nonce', 'invalid-nonce'));
    // }

    $post = null;
    if ($type === 'post') {
      $post = get_post($postId);
    }
    else if ($type === 'page') {
      $post = get_page($postId);
    }

    if (empty($post)) {
      return new WP_Error('404', __('Page/Post not found', 'not-found'));
    }

    // Status should be draft for preview
    $postStatus = get_post_status($post->ID);
    if ($postStatus != 'draft' && $postStatus != 'auto-draft') {
      return new WP_Error('400', __('Not available for preview', 'preview-unavailable'));
    }

    // Format the page the same as standard API does
    $controller = new WP_REST_Posts_Controller($type);
    $view = $controller->prepare_item_for_response($post, $request);

    return $view;
  }

  // TODO Get Post preview

  public function get_settings(WP_REST_Request $request) {
    $lang = substr($request->get_header('Accept-Language'), 0, 2);
    $settings = new stdClass();

    if ($lang === 'en') {
      $settings->footer = get_field('footer_columns', 'english');
      $settings->social_media = get_field('social_media', 'english');
    }
    else {
      $settings->footer = get_field('footer_columns', 'suomi');
      $settings->social_media = get_field('social_media', 'suomi');
    }

    if (empty($settings)) {
      return new WP_Error('500', __('Footer not found', 'not-found'));
    }

    return $settings;
  }

  public function get_posts(WP_REST_Request $request) {
    $lang = substr($request->get_header('Accept-Language'), 0, 2);

    $args = array(
      'hide_empty' => false,
      'lang' => $lang
    );
    $posts = get_posts($args);

    $recurse = new ACF_To_REST_API_Recursive;
    return $recurse->get_fields($posts);
  }

  public function get_categories(WP_REST_Request $request) {
    $lang = substr($request->get_header('Accept-Language'), 0, 2);

    $args = array(
      'hide_empty' => false
    );
    $categories = get_categories($args);
    $localeCategories = array();

    foreach ($categories as $cat) {
      $locale = pll_get_term_language($cat->term_id, 'slug');
      if ($locale === $lang) {
        array_push($localeCategories, $cat);
      }
    }

    return $localeCategories;
  }
}

add_action('rest_api_init', function() {
  $plugin = new BodyBuilder_Rest;
  $plugin->register_routes();
});
