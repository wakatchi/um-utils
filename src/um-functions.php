<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Ultimate Memberのフィールドを取得する
 */
function wk_get_um_user_data($user_id, $meta_key){
    um_fetch_user( $user_id );
    $value = um_user( $meta_key );
    um_reset_user();
    return $value;
}
