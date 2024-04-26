<?php

namespace Wakatchi\UMUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Wakatchi\UMUtils\WPFunctions' ) ) {

    /**
     * Class WPFunctions
     * 
     * This class contains utility functions for WordPress.
     */
    class WPFunctions {

        private function __construct(){
        }

        /**
         * Checks if the current user is an admin user.
         *
         * @return bool True if the current user is an admin user, false otherwise.
         */
        public static function is_admin_user() {
            return current_user_can( 'manage_options' );
        }

        /**
         * Returns the user ID if it is not null, otherwise returns the current user ID.
         *
         * @param int|null $user_id The user ID.
         * @return int The user ID.
         */
        public static function nvl_user_id( $user_id ) {
            return is_null( $user_id ) ? get_current_user_id() : $user_id ;
        }

        /**
         * Returns the current page URL.
         *
         * @return string The current page URL.
         */
        public static function get_current_page_url(){
            return self::get_host_url() . $_SERVER["REQUEST_URI"];
        }

        /**
         * Returns the host URL based on the current server scheme.
         *
         * @return string The host URL.
         * @deprecated Use `home_url()` instead.
         */
        public static function get_host_url(){
            $scheme = is_ssl() ? 'https' : 'http' ;
            return $scheme.'://'.$_SERVER["HTTP_HOST"];
        }

        /**
         * Checks if the current user is the author of the post.
         *
         * @return bool True if the current user is the author, false otherwise.
         */
        public static function is_current_auther(){
            return get_the_author_meta('ID') === get_current_user_id();
        }

        /**
         * Outputs a formatted string representation of a variable using var_dump.
         *
         * @param mixed $data The variable to be dumped.
         * @return string The formatted string representation of the variable.
         * 
         * @codeCoverageIgnore
         */
        public static function var_dump_text( $data ){
            ob_start();
            var_dump( $data ) ;
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }

        /**
         * Deserialize usermeta values.
         *
         * This function deserializes an array of usermeta values using `maybe_unserialize` function.
         * It merges all the values into a single array and removes duplicates.
         *
         * @param array $meta_values The array of usermeta values to be deserialized.
         * @return array The deserialized and merged array of usermeta values.
         */
        public static function deserialize_usermeta_values( $meta_values ) {
            if( empty($meta_values ) || !is_array($meta_values) ){
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

        /**
         * Loads the content of a file and returns it as a string.
         *
         * @param string $file The path to the file to be loaded.
         * @param mixed $param Optional parameter to be passed to the included file.
         * @return string The content of the file as a string.
         * 
         * @codeCoverageIgnore
         */
        public static function load_content( $file, $param = null) {
            ob_start();
            if( !is_null($param) ) {
                $template_param = $param ;
            }
            include( $file ) ;
            return ob_get_clean();
        }

        /**
         * Renders a template file with optional parameters.
         *
         * @param string $file The path to the template file.
         * @param mixed $param Optional parameters to be passed to the template.
         * @return string The rendered template content.
         */
        public static function render_template( $file, $param = null) {
            $template_path = apply_filters('wum_get_template_path', $file);
            $output = self::load_content( ShortFunctions::ensure_php_extension($template_path),$param);
            return htmlspecialchars_decode(do_shortcode($output), ENT_NOQUOTES) ;
        }

        /**
         * Translates and formats a string using the specified text domain.
         *
         * @param string $msgid The message ID to be translated.
         * @param string $slug The text domain to use for translation.
         * @param mixed ...$arg Optional arguments to be passed to the translated string.
         * @return string The translated and formatted string.
         * 
         * @codeCoverageIgnore
         */
        public static function __s( $msgid, $slug, ...$arg){
            return sprintf( __( $msgid, $slug ), ...$arg ) ;
        }

        /**
         * Validates a term.
         *
         * @param mixed $term The term to validate.
         * @return bool Returns true if the term is not null and not a WordPress error, false otherwise.
         */
        public static function validate_term( $term ) {
            return !is_null($term) && !is_wp_error($term);
        }
    }
}
