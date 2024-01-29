<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Determine if the user is an administrator
 * 
 * @return boolean Is this user an administrator
 */
function wk_is_admin_user() {
    return current_user_can( 'manage_options' );
}

/**
 * If the specified user ID is null, return the logged in user ID.
 * 
 * @return string User ID
 */
function wk_nvl_user_id( $user_id ) {
    return is_null( $user_id ) ? get_current_user_id() : $user_id ;
}

/**
 * Get current page URL
 * 
 * @return string Current page URL
 */
function wk_get_current_page_url(){
    return wk_get_host_url() . $_SERVER["REQUEST_URI"];
}

/**
 * Get hostname
 * 
 * @return string hostname
 */
function wk_get_host_url(){
    $scheme = is_ssl() ? 'https' : 'http' ;
    return $scheme.'://'.$_SERVER["HTTP_HOST"];
}

/**
 * Determine if this post is a logged-in user
 * 
 * @return boolean Is this user's post
 */
function wk_is_current_auther(){
    return get_the_author_meta('ID') === get_current_user_id();
}

/**
 * Dump a structured variable such as an Array to a string
 * 
 * @param $data structured data
 * @return string string to output
 */
function wk_var_dump_text( $data ){
    ob_start();
    var_dump( $data ) ;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * Deduplicate Usermeta table search results
 * 
 * @param array $meta_values Usermeta table search results
 * @return array Search results for the Usermeta table with duplicates removed. Returns an empty array if null or empty array is specified
 */
function wk_deserialize_usermeta_values( $meta_values ) {
    if( empty($meta_values )) {
        return [] ;
    }

    $deser_array = array_map( 'maybe_unserialize', $meta_values );
    $temp_values  = [] ;
    foreach ( $deser_array as $values ) {
        if ( is_array( $values ) ) {
            $temp_values = array_merge( $temp_values, $values );
        } else {
            $temp_values[] = $values;
        }
    }
    return array_unique( $temp_values );
}
