<?php

namespace Wakatchi\WPUtils\Core;

use function Wakatchi\WPUtils\wk_load_content;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Abstract class for rendering contents.
 */
abstract class Contents_Renderer {

    /**
     * Renders a template with the given parameters.
     *
     * @param string $template_name The name of the template to render.
     * @param array  $template_param Optional. The parameters to pass to the template. Default is an empty array.
     * @return string The rendered template.
     */
    protected function render_template( $template_name, $template_param = []){
        $output = wk_load_content($template_name,$template_param);
        return htmlspecialchars_decode(do_shortcode($output), ENT_NOQUOTES) ;
    }
}


