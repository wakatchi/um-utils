<?php

namespace Wakatchi\UMUtils\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Wakatchi\UMUtils\Core\Shortcodes' ) ) {

    /**
     * Utility Shortcodes
     */
    class Shortcodes extends ContentsRenderer{

        function __construct() {
            add_shortcode( 'wum_render_template',  array( &$this,'render_simple_template'),10,2);
        }

        function render_simple_template($atts = null, $content = null){
            $template = isset($atts['template']) ? $atts['template'] : '';
            if ( empty( $template ) ){
                return "The 'template' attribute for the shortcode 'wum_render_template' was not set." ;
            }

            $file = $template.'.php';
            $template_param = [
                'content' => $content
            ];
            $template_path = apply_filters('wum_get_template_path', $file);
            return $this->render_template($template_path,$template_param);
        }
    }
}