<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Formats the given price into a displayable format.
 *
 * @param float $price The price to be formatted.
 * @param string $alt_text The alternative text to be displayed if the price is empty.
 * @return string The formatted price with the currency symbol.
 */
function wk_currensy_display_format( $price, $alt_text = '0円'){
    if( empty($price) ){
        return $alt_text;
    }
    return number_format( $price ).'円' ;
}

/**
 * Shortens a string to a specified number of characters.
 *
 * @param string $value The string to be shortened.
 * @param int $size The maximum number of characters to keep.
 * @return string The shortened string.
 */
function wk_shorten_characters($value, $size = 100){
    if( mb_strlen( $value ) <= $size ) {
        return $value ;
    }
    return mb_substr($value,0,$size).'...';
}

/**
 * Formats a datetime string in the format 'yyyyMMdd' to 'Y年m月d日'.
 *
 * @param string $datetime The datetime string to format.
 * @param string $alt_text The alternative text to return if the datetime is empty.
 * @return string The formatted datetime string in the format 'Y年m月d日'.
 */
function wk_datetime_display_format_yyyyMMdd ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text;
    }
    return date('Y年m月d日',strtotime($datetime));
}

/**
 * Formats a datetime string in the format 'YYYY年MM月DD日 HH時mm分'.
 *
 * @param string $datetime The datetime string to format.
 * @param string $alt_text The alternative text to return if the datetime is empty.
 * @return string The formatted datetime string.
 */
function wk_datetime_display_format_yyyyMMddhhmm ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text ;
    }
    return date('Y年m月d日 H時i分',strtotime($datetime));
}

/**
 * Formats a datetime string to display as 'YYYY年MM月'.
 *
 * @param string $datetime The datetime string to format.
 * @param string $alt_text The alternative text to return if the datetime is empty.
 * @return string The formatted datetime string.
 */
function wk_datetime_display_format_yyyyMM ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text;
    }
    return date('Y年m月',strtotime($datetime));
}

/**
 * Validates an array.
 *
 * This function checks if the given value is not null, is an array, and has at least one element.
 *
 * @param mixed $array The value to be validated.
 * @return bool Returns true if the value is a non-empty array, false otherwise.
 */
function wk_validate_array( $array ){
    return !is_null($array) && is_array($array) && count($array) > 0 ;
}

/**
 * Unsets specified keys from an array if they exist.
 *
 * @param array $array The array to modify.
 * @param string ...$keys The keys to unset.
 * @return void
 */
function wk_safety_unset( &$array, string ...$keys){
    foreach( $keys as $key ) {
        if( isset( $array[ $key ] ) ) {
            unset( $array[ $key ] );
        }
    }
}
