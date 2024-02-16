<?php

namespace Wakatchi\UMUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class UMFunctions
 * 
 * This class contains utility functions for Ultimate Member.
 */
class UMFunctions {

    private function __construct(){
    }

    /**
     * Retrieves data from Ultimate Member user information with the specified user ID and meta key.
     *
     * @param int $user_id The ID of the user.
     * @param string $meta_key The meta key to retrieve the value for.
     * @return mixed The value of the user meta data.
     */
    public static function get_um_user_data( $user_id, $meta_key ){
        um_fetch_user( $user_id );
        $value = um_user( $meta_key );
        um_reset_user();
        return $value;
    }

}

