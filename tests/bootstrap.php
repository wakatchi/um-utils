<?php

use Yoast\WPTestUtils\WPIntegration;

require_once dirname( __DIR__ ) . '/vendor/yoast/wp-test-utils/src/WPIntegration/bootstrap-functions.php';

$test_dir = WPIntegration\get_path_to_wp_test_dir();

if( !$test_dir ) {
    exit('error!!');
}

require_once $test_dir . 'includes/functions.php';

tests_add_filter(
    'plugins_loaded',
    function(){
        require WP_PLUGIN_DIR.'/ultimate-member/ultimate-member.php';
    }
);

WPIntegration\bootstrap_it();

require_once dirname( __DIR__ ) . '/src/short-functions.php';
require_once dirname( __DIR__ ) . '/src/um-functions.php';
require_once dirname( __DIR__ ) . '/src/wp-functions.php';
 