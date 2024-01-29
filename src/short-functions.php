<?php

namespace Wakatchi\WPUtils;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 文字列を通貨（円）表示する
 */
function wk_currensy_display_format( $price, $alt_text = '0円'){
    if( empty($price) ){
        return $alt_text;
    }
    return number_format( $price ).'円' ;
}

/**
 * 文字列を省略する
 */
function wk_shorten_characters($value, $size = 100){
    if( mb_strlen( $value ) <= $size ) {
        return $value ;
    }
    return mb_substr($value,0,$size).'...';
}

/**
 * 日付型を yyyy年m月d日 にフォーマットする
 */
function wk_datetime_display_format_yyyyMMdd ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text;
    }
    return date('Y年m月d日',strtotime($datetime));
}

/**
 * 日付型を yyyy年m月d日H時i分 にフォーマットする
 */
function wk_datetime_display_format_yyyyMMddhhmm ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text ;
    }
    return date('Y年m月d日 H時i分',strtotime($datetime));
}

/**
 * 日付型を yyyy年m月 にフォーマットする
 */
function wk_datetime_display_format_yyyyMM ($datetime, $alt_text = ''){
    if( empty($datetime) ){
        return $alt_text;
    }
    return date('Y年m月',strtotime($datetime));
}

/**
 * 配列の有効性をチェックする
 */
function wk_validate_array( $array ){
    return !is_null($array) && is_array($array) && count($array) > 0 ;
}

/**
 * unsetによる変数の無効化を安全に行う
 */
function wk_safety_unset( &$array, string ...$keys){
    foreach( $keys as $key ) {
        if( isset( $array[ $key ] ) ) {
            unset( $array[ $key ] );
        }
    }
}
