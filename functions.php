<?php

// Admin settings
require_once 'inc/admin.php';

// Post/page preview link
require_once 'inc/preview.php';

// REST API endpoints
require_once 'inc/rest.php';
require_once 'inc/acf-to-rest-recursive.php';

// CORS handling
require_once 'inc/cors.php';

// TinyMCE config
require_once 'inc/tinymce.php';

// Enable recursion
add_action('after_setup_theme', array('ACF_To_REST_API_Recursive', 'init'));
add_filter('acf/rest_api/recursive/types', function($types) {
	return $types;
});
