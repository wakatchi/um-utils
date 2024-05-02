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
         * Retrieves the existing terms for the given taxonomies that have associated posts.
         *
         * @param string|array $taxonomies The taxonomies to retrieve terms from.
         * @return array An array of existing terms with their associated post count.
         */
        public static function get_post_exist_terms($taxonomies){
            $terms = get_terms([
                'taxonomy' => $taxonomies,
                'hide_empty' => true,
            ]);
            $exist_terms = [];
            if( count($terms) > 0 ) {
                global $wpdb;
                foreach( $terms as $term ) {
                    $sql = "
                        SELECT COUNT(*) 
                        FROM $wpdb->term_relationships AS tr
                        INNER JOIN $wpdb->posts AS p ON tr.object_id = p.ID
                        WHERE tr.term_taxonomy_id = %d
                        AND p.post_status = 'publish'
                    ";
                    $count = $wpdb->get_var($wpdb->prepare($sql, $term->term_id));
                    if( $count > 0 ) {
                        $exist_terms[] = [
                            'term' => $term,
                            'count' => $count,
                        ];
                    }
                }
            }
            return $exist_terms ;
        }
    }
}
