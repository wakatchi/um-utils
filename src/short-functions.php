<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display string in currency (yen)
 * 
 * @param string $price price
 * @param string $alt_text alternative text. If omitted, "0円"
 * 
 * @return string formatted string
 * 
 */
function wk_currensy_display_format( $price, $alt_text = '0円'){
    if( empty($price) ){
        return $alt_text;
    }
    return number_format( $price ).'円' ;
}

/**
 * omit a string to the specified size. The default string is converted to "..."
 * 
 * @param string $value String to omit
 * @param string $size string length. If omitted, 100
 * 
 * @return string Omitted string
 */
function wk_shorten_characters($value, $size = 100){
    if( mb_strlen( $value ) <= $size ) {
        return $value ;
    }
    return mb_substr($value,0,$size).'...';
}

/**
 * Format date type to "yyyy年M月d日"
 * 
 * @param $datetime DateTime to format
 * @param string $alt_text alternative text. If omitted, it will be blank.
 * 
 * @return string formatted string
 */
function wk_datetime_display_format_yyyyMMdd ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text;
    }
    return date('Y年m月d日',strtotime($datetime));
}

/**
 * Format date type to "yyyy年M月d日 H時i分"
 * 
 * @param $datetime DateTime to format
 * @param string $alt_text alternative text. If omitted, it will be blank.
 * 
 * @return string formatted string
 */
function wk_datetime_display_format_yyyyMMddhhmm ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text ;
    }
    return date('Y年m月d日 H時i分',strtotime($datetime));
}

/**
 * Format date type to "yyyy年M月"
 * 
 * @param $datetime DateTime to format
 * @param string $alt_text alternative text. If omitted, it will be blank.
 * 
 * @return string formatted string
 */
function wk_datetime_display_format_yyyyMM ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text;
    }
    return date('Y年m月',strtotime($datetime));
}

/**
 * Determine the validity of an array
 * - not null
 * - is an array
 * - There is one or more data in the array
 * 
 * @param $array Target data
 * 
 * @return boolean Whether Array is enabled or not
 */
function wk_validate_array( $array ){
    return !is_null($array) && is_array($array) && count($array) > 0 ;
}

/**
 * Disable a variable explicitly
 * 
 * @param array &$array Array
 * @param string variable length keys
 */
function wk_safety_unset( &$array, string ...$keys){
    foreach( $keys as $key ) {
        if( isset( $array[ $key ] ) ) {
            unset( $array[ $key ] );
        }
    }
}
