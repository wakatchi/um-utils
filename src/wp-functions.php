<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 管理者ユーザかを判断する
 */
function wk_is_admin_user() {
    return current_user_can( 'manage_options' );
}

/**
 * 指定されたユーザIDがnullだったらログインしているユーザIDを返戻する
 */
function wk_get_user_id_nvl( $user_id ) {
    return is_null( $user_id ) ? get_current_user_id() : $user_id ;
}

/**
 * 現在のURLを取得する
 */
function wk_get_current_page_url(){
    $scheme = is_ssl() ? 'https' : 'http' ;
    return $scheme.'://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

/**
 * 現在のホスト名を取得する
 */
function wk_get_host_url(){
    $scheme = is_ssl() ? 'https' : 'http' ;
    return $scheme.'://'.$_SERVER["HTTP_HOST"];
}

/**
 * この投稿がログインユーザ本人かを検証する
 */
function wk_is_current_auther(){
    return get_the_author_meta('ID') === get_current_user_id();
}

/**
 * Arrayなど構造化された変数を文字列にダンプする
 */
function wk_var_dump_text($data){
    ob_start();
    var_dump( $data ) ;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * Usermetaテーブル検索結果の重複を取り除く
 * 
 * @param array $meta_values Usermetaテーブルの検索結果
 * @return array 重複が取り除かれたUsermetaテーブルの検索結果。nullもしくは空配列が指定されたら空配列を返戻する
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
