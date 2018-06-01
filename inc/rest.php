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

    register_rest_route($namespace, '/page/(?P<id>\d+)/preview', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_page_preview')
    ));

    register_rest_route($namespace, '/footer', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => array($this, 'get_footer')
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
      $item->slug = sanitize_title($item->title);
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
    $site->footer = $this->get_footer($request);

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

  public function get_page_preview(WP_REST_Request $request) {
    $pageId = $request->get_param('id');

    // Nonce needs to be valid in order to preview
    if (!wp_verify_nonce($request['_wpnonce'], 'wp_rest')) {
      return new WP_Error('403', __('Invalid nonce', 'invalid-nonce'));
    }

    $page = get_page($pageId);
    if (empty($page)) {
      return new WP_Error('404', __('Page not found', 'not-found'));
    }

    // Page status should be draft for preview
    $pageStatus = get_post_status($page->ID);
    if ($pageStatus != 'draft' && $pageStatus != 'auto-draft') {
      return new WP_Error('400', __('Page not available for preview', 'preview-unavailable'));
    }

    // Format the page the same as standard API does
    $controller = new WP_REST_Posts_Controller('page');
    $pageView = $controller->prepare_item_for_response($page, $request);

    return $pageView;
  }

  public function get_footer(WP_REST_Request $request) {
    $lang = substr($request->get_header('Accept-Language'), 0, 2);
    $footer = new stdClass();

    if ($lang === 'en') {
      $footer->columns = get_field('footer_columns', 'english');
      $footer->social_media = get_field('social_media', 'english');
    }
    else {
      $footer->columns = get_field('footer_columns', 'suomi');
      $footer->social_media = get_field('social_media', 'suomi');
    }

    if (empty($footer)) {
      return new WP_Error('500', __('Footer not found', 'not-found'));
    }

    return $footer;
  }
}

add_action('rest_api_init', function() {
  $plugin = new BodyBuilder_Rest;
  $plugin->register_routes();
});
