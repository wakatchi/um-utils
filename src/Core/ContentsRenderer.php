<?php

namespace Wakatchi\WPUtils\Core;

use Wakatchi\WPUtils\WPFunctions;

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
}


