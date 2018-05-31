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

    if ($lang === 'en') {
      $site->homepageId = get_option('page_on_front');
    }
    else {
      // TODO We probably need custom ACF to define language-specific frontpage
      $site->homepageId = 2;
    }

    if (empty($site)) {
      return new WP_Error('500', __('Error while loading data for the site', 'not-found'));
    }

    return $site;
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
