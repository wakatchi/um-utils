<?php

namespace Wakatchi\UMUtils;

use ftp;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Wakatchi\UMUtils\ShortFunctions' ) ) {

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
         * Formats a datetime string in the format 'HH時mm分'.
         *
         * @param string $datetime The datetime string to format.
         * @param string $alt_text The alternative text to return if the datetime is empty.
         * @return string The formatted datetime string.
         */
        public static function time_display_format_HHii ($datetime, $alt_text = ''){
            if( empty($datetime) ){
                return $alt_text ;
            }
            return date('H時i分',strtotime($datetime));
        }

        /**
         * Formats a datetime string in the format 'MM月DD日 HH時mm分'.
         *
         * @param string $datetime The datetime string to format.
         * @param string $alt_text The alternative text to return if the datetime is empty.
         * @return string The formatted datetime string.
         */
        public static function datetime_display_format_MMddhhmm ($datetime, $alt_text = ''){
            if( empty($datetime) ){
                return $alt_text ;
            }
            return date('m月d日 H時i分',strtotime($datetime));
        }

        /**
         * Displays a custom formatted date and time.
         *
         * @param string $datetime The date and time to format.
         * @param string $format The format to use for displaying the date and time. Default is 'Y年m月d日 H時i分'.
         * @param string $alt_text The alternative text to return if $datetime is empty. Default is an empty string.
         * @return string The formatted date and time.
         */
        public static function display_custom_format($datetime, $format = 'Y年m月d日 H時i分',$alt_text = ''){
            if( empty($datetime) ){
                return $alt_text ;
            }
            return date($format,strtotime($datetime));
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

        /**
         * 指定された16進数のカラーコードをRGBA形式に変換します。
         *
         * @param string $hex 16進数のカラーコード
         * @param float $opacity 不透明度（0から1の範囲で指定）
         * @return string RGBA形式のカラーコード
         */
        public static function hex2Rgba( $hex, $opacity = 1) {
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            return "rgba($r, $g, $b, $opacity)";
        }

        /**
         * Ensures that the given filename has the '.php' extension.
         *
         * @param string $filename The filename to check.
         * @return string The filename with the '.php' extension, if it doesn't already have it.
         */
        public static function ensure_php_extension($filename) {
            return pathinfo($filename, PATHINFO_EXTENSION) == 'php' ? $filename : $filename . '.php';
        }

        /**
         * Sorts an array by the 'count' key in descending order.
         *
         * @param array $array The array to be sorted.
         * @return array The sorted array.
         */
        public static function sort_array_by_count( $array ) {
            array_multisort(array_column($array,'count'),SORT_DESC,$array);
            return $array;
        }
        
        /**
         * Returns a new array containing the first $limit elements of the given array.
         *
         * @param array $array The input array.
         * @param int $limit The maximum number of elements to include in the new array. Default is 10.
         * @return array The new array containing the first $limit elements of the input array.
         */
        public static function narrow_top_array( $array, $limit = 10) {
            return array_slice($array , 0, $limit);
        }

        /**
         * Checks if a string is entirely lowercase.
         *
         * @param string $string The string to check.
         * @return bool Returns true if the string is entirely lowercase, false otherwise.
         */
        public static function is_lowercase($string) {
            return preg_match('/^[a-z]+$/', $string) === 1;
        }
        
        /**
         * Checks if a string contains only alphanumeric characters.
         *
         * @param string $string The string to be checked.
         * @return bool Returns true if the string contains only alphanumeric characters, false otherwise.
         */
        public static function is_alpha_and_numetic($string) {
            return ctype_alnum($string);
        }
        
        /**
         * Checks if a given string is a valid email address.
         *
         * @param string $string The string to be checked.
         * @return bool Returns true if the string is a valid email address, false otherwise.
         */
        public static function is_valid_email($string) {
            return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
        }
        
        /**
         * Checks if a string is a valid phone number.
         *
         * @param string $string The string to be checked.
         * @return bool Returns true if the string is a valid phone number, false otherwise.
         */
        public static function is_phone_number($string) {
            return preg_match('/^[0-9-]+$/', $string) === 1;
        }
    }
}