<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Retrieves the user meta data for a given user ID and meta key.
 *
 * @param int $user_id The ID of the user.
 * @param string $meta_key The meta key to retrieve the value for.
 * @return mixed The value of the user meta data.
 */
function wk_get_um_user_data($user_id, $meta_key){
    um_fetch_user( $user_id );
    $value = um_user( $meta_key );
    um_reset_user();
    return $value;
}
