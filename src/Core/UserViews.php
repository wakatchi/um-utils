<?php

namespace Wakatchi\UMUtils\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Wakatchi\UMUtils\Core\UserViews' ) ) {

    /**
     * Class about user views
     */
    class UserViews {

        private const VIEWED_USED_META_KEY = 'wum_viewed_user';

        const VIEW_UNIT_DAY = 86400;
        const VIEW_UNIT_WEEK = 604800;

        function __construct() {
        }

        /**
         * Adds a viewed user to the user's list of viewed users.
         *
         * @param int $user_id The ID of the user.
         * @param int|null $viewed_user_id The ID of the viewed user. If not provided, the current user's ID will be used.
         * @return void
         */
        function add_viewed_user( $user_id , $viewed_user_id = null ){
            if( is_null($user_id) ){
                return ;
            }
            if( is_null($viewed_user_id) ){
                $viewed_user_id = get_current_user_id();
            }
            $viewed_users = get_user_meta( $user_id, self::VIEWED_USED_META_KEY, true );
            if ( !is_array($viewed_users) ){
                $viewed_users = [];
            }
            if ( !in_array($viewed_user_id, $viewed_users) ){
                $now = apply_filters('wum_get_current_time', time());
                $viewed_users[$viewed_user_id] = $now ;
                update_user_meta( $user_id, self::VIEWED_USED_META_KEY, $viewed_users );
            }
        }

        /**
         * Retrieves the count of user views within a specified time unit.
         *
         * @param int    $user_id    The ID of the user.
         * @param string $view_unit  The time unit for counting views. Default is 'day'.
         *
         * @return int  The count of user views within the specified time unit.
         */
        function get_user_view_count( $user_id, $view_unit = self::VIEW_UNIT_DAY ){
            $viewed_users = get_user_meta( $user_id, self::VIEWED_USED_META_KEY, true );
            if ( !is_array($viewed_users) ){
                return 0;
            }
            $now = apply_filters('wum_get_current_time', time());
            $count = 0;
            foreach( $viewed_users as $viewed_user_id => $viewed_time ){
                if ( $now - $viewed_time < $view_unit ){
                    $count++;
                }
            }
            return $count;
        }
    }
}