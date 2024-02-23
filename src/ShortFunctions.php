<?php

namespace Wakatchi\UMUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class ShortFunctions
 * 
 * This class contains short functions for utility purposes.
 */
class ShortFunctions {

    private function __construct(){
    }

    /**
     * Formats the given price into a currency display format.
     *
     * @param float|int|string $price The price to format.
     * @param string $alt_text The alternative text to return if the price is empty or not numeric. Default is '0円'.
     * @return string The formatted price with the currency symbol.
     */
    public static function currensy_display_format( $price, $alt_text = '0円'){
        if( empty($price) || !is_numeric($price) ){
            return $alt_text;
        }
        return number_format( $price ).'円' ;
    }

    /**
     * Returns the given value if it is not empty, otherwise returns the default value.
     *
     * @param mixed $value The value to check.
     * @param mixed $default The default value to return if the given value is empty. Default is '-'.
     * @return mixed The given value if it is not empty, otherwise the default value.
     */
    public static function get_or_default( $value, $default = '-'){
        return !empty($value) ? $value : $default ;
    }

    /**
     * Returns the formatted number or a default value if the number is empty.
     *
     * @param mixed $value The number to format.
     * @param string $default The default value to return if the number is empty. Default is '-'.
     * @return string The formatted number or the default value.
     */
    public static function get_number_or_default( $value, $default = '-'){
        return !empty($value) ? number_format($value) : $default ;
    }

    /**
     * Shortens a string to a specified number of characters.
     *
     * @param string $value The string to be shortened.
     * @param int $size The maximum number of characters to keep.
     * @return string The shortened string.
     */
    public static function shorten_characters($value, $size = 100){
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
    public static function datetime_display_format_yyyyMMdd ($datetime, $alt_text = ''){
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
    public static function datetime_display_format_yyyyMMddhhmm ($datetime, $alt_text = ''){
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
    public static function datetime_display_format_yyyyMM ($datetime, $alt_text = ''){
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
    public static function validate_array( $array ){
        return !is_null($array) && is_array($array) && count($array) > 0 ;
    }

    /**
     * Unsets specified keys from an array if they exist.
     *
     * @param array $array The array to modify.
     * @param string ...$keys The keys to unset.
     * @return void
     */
    public static function safety_unset( &$array, string ...$keys){
        foreach( $keys as $key ) {
            if( isset( $array[ $key ] ) ) {
                unset( $array[ $key ] );
            }
        }
    }
}

