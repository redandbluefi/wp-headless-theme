<?php
/**
 * Allow GET requests from * origin
 * Thanks to https://joshpress.net/access-control-headers-for-the-wordpress-rest-api/
 */
add_action(
    'rest_api_init',
    function () {
        remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');

        add_filter('rest_pre_serve_request', function ($value) {
            header('Access-Control-Allow-Origin: ' . get_option('home'));
            header('Access-Control-Allow-Methods: GET');
            header('Access-Control-Allow-Credentials: true');

            return $value;
        });
    },
    15
);

function add_allowed_origins($origins)
{
    $origins[] = get_option('home');
    return $origins;
}
add_filter('allowed_http_origins', 'add_allowed_origins');

add_action('wplf_pre_validate_submission', function() {
  $origin = get_option('home');
  header("Access-Control-Allow-Origin: $origin");
  header("Access-Control-Allow-Credentials: true");
});
