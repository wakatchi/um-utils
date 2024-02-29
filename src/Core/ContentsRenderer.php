<?php

namespace Wakatchi\UMUtils\Core;

use Wakatchi\UMUtils\WPFunctions;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Abstract class for rendering contents.
 */
abstract class ContentsRenderer {

    /**
     * Renders a template with the given parameters.
     *
     * @param string $template_name The name of the template to render.
     * @param array $template_param An optional array of parameters to pass to the template.
     * @return string The rendered template.
     */
    protected function render_template( $template_name, $template_param = []){
        $output = WPFunctions::load_content($template_name,$template_param);
        return htmlspecialchars_decode(do_shortcode($output), ENT_NOQUOTES) ;
    }

    /**
     * Renders a message after redirecting to a specified URL.
     *
     * @param string $message The message to be displayed.
     * @param string $redirect_to The URL to redirect to.
     * @param string $message_container_file The file containing the message container template. Default is 'message-container.php'.
     * @param int $redirect_second The number of seconds to wait before redirecting. Default is 5.
     * @return string The rendered message after decoding HTML entities and executing shortcodes.
     */
    protected function render_message_after_redirect( $messsage, $redirect_to, $message_container_file = 'message-container.php',$redirect_second = 5){
        $template_param = [
            'message' => $messsage,
            'redirect_second' => $redirect_second,
        ];
        $output = WPFunctions::load_content($message_container_file,$template_param);
        header( "refresh: $redirect_second ; url=$redirect_to" );
        return htmlspecialchars_decode(do_shortcode($output), ENT_NOQUOTES) ;
    }
}


