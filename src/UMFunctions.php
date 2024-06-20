<?php

namespace Wakatchi\UMUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Wakatchi\UMUtils\UMFunctions' ) ) {

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

        /**
         * Retrieves the user meta value for a given user ID and meta key.
         * If the meta value is not found, returns the default value.
         *
         * @param int    $user_id   The ID of the user.
         * @param string $meta_key  The meta key to retrieve the value for.
         * @param mixed  $default   The default value to return if the meta value is not found.
         * @return mixed            The meta value or the default value.
         */
        public static function get_um_or_default( $user_id, $meta_key, $default = ''){
            return ShortFunctions::get_or_default(
                                self::get_um_user_data( $user_id, $meta_key ),
                                $default );
        }

        /**
         * Retrieves the UM number associated with a user or returns a default value if not found.
         *
         * @param int    $user_id   The ID of the user.
         * @param string $meta_key  The meta key for the UM number.
         * @param mixed  $default   The default value to return if the UM number is not found.
         * @return mixed The UM number associated with the user or the default value.
         */
        public static function get_um_number_or_default( $user_id, $meta_key, $default = ''){
            return ShortFunctions::get_number_or_default(
                                self::get_um_user_data( $user_id, $meta_key ),
                                $default );
        }

        /**
         * Retrieves the labels of selected values from a multiple select field for a given user.
         * 
         * The reason behind this function is that for the Ultimate member's multi-select field, the only thing you can get with um_user is the key.
         *
         * @param int    $user_id         The ID of the user.
         * @param string $field_meta_key  The meta key of the multiple select field.
         *
         * @return array  An array of labels corresponding to the selected values.
         */
        public static function get_um_multiple_select_values( $user_id, $field_meta_key) {
            $field_values = UMFunctions::get_um_user_data( $user_id, $field_meta_key);
            if( !$field_values ) {
                return [];
            }

            $um_fields = UM()->fields()->get_field( $field_meta_key );
            $labels = [];
            foreach( $field_values as $value ){
                if( isset($um_fields['options'][$value])){
                    $labels[] = $um_fields['options'][$value];
                }
            }
            return $labels;
        }
    }
}
