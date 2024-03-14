<?php

namespace Wakatchi\UMUtils\Core;

use Mockery;
use Brain\Monkey\Functions as MonkeyFunctions;
use Wakatchi\UMUtils\Core\ContentsRenderer;
use Yoast\WPTestUtils\BrainMonkey\TestCase;

class ContentsRendererTest extends TestCase {

    public function testRenderTemplate() {
        $template_name = dirname( __DIR__ ) . '/template/file1.php';

        $template_param = [
            'param1' => 'value1',
            'param2' => 'value2'
        ];
        MonkeyFunctions\expect('do_shortcode')
            ->once()
            ->andReturn('loaded output');

        MonkeyFunctions\expect('htmlspecialchars_decode')
            ->once()
            ->with('loaded output',ENT_NOQUOTES)
            ->andReturn('Decoded output');

        $contents_renderer = new ConcreteClass();
        $actual = $contents_renderer->render($template_name, $template_param);
        $this->assertEquals('Decoded output', $actual);
    }

    public function testRenderMessageAfterRedirect() {
        $template_name = dirname( __DIR__ ) . '/template/file1.php';
        $redirect_second = 5;
        $redirect_to = 'http://example.com';

        MonkeyFunctions\expect('do_shortcode')
            ->once()
            ->with(Mockery::type('string'))
            ->andReturn('loaded output');

        MonkeyFunctions\expect('header')
            ->once()
            ->with( "refresh: $redirect_second ; url=$redirect_to" );

        MonkeyFunctions\expect('htmlspecialchars_decode')
            ->once()
            ->with('loaded output',ENT_NOQUOTES)
            ->andReturn('Decoded output');

        $contents_renderer = new ConcreteClass();
        $actual = $contents_renderer->message_after_redirect($template_name, $redirect_to,$template_name, $redirect_second);
        $this->assertEquals('Decoded output', $actual);
    }
}

class ConcreteClass extends ContentsRenderer {

    public function render( $template_name, $template_param = []){
        return parent::render_template($template_name, $template_param);
    }

    public function message_after_redirect( $messsage, $redirect_to, $message_container_file = 'message-container.php',$redirect_second = 5){
        return parent::render_message_after_redirect($messsage, $redirect_to, $message_container_file, $redirect_second);
    }
}