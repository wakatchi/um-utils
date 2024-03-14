<?php

namespace Wakatchi\UMUtils\Admin;

use Brain\Monkey;
use Brain\Monkey\Functions as MonkeyFunctions;
use Wakatchi\UMUtils\Admin\AdminMenu;
use Yoast\WPTestUtils\BrainMonkey\TestCase;

class AdminMenuTest extends TestCase {

    protected function setUp(): void{
        parent::setUp();
        Monkey\setUp();

    }
    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testInit() {
        $base_slug = 'test-menu';
        $title = 'foo';
        $label = 'bar';
        $slug = 'test-submenu';

        $adminMenu = new ConcreteAdminMenu($base_slug, $title, $label, $slug);
        $this->expectOutputString('');
        $this->assertSame(10,has_action('admin_menu', [$adminMenu, 'add_submenu']));
        $this->assertSame(10,has_action('admin_init', [$adminMenu, 'init_section']));
        $this->assertSame(10,has_action('admin_init', [$adminMenu, 'init_field']));
        $this->assertSame(10,has_action('admin_init', [$adminMenu, 'init_register_settings']));
    }

    public function testAddSubmenu() {
        $base_slug = 'test-menu';
        $title = 'foo';
        $label = 'bar';
        $slug = 'test-submenu';

        $adminMenu = new ConcreteAdminMenu($base_slug, $title, $label, $slug);
        MonkeyFunctions\expect('add_submenu_page')
            ->once()
            ->with($base_slug, $title, $label, 'manage_options', $slug, [$adminMenu, 'render']);

        $adminMenu->add_submenu();
    }

    public function testRenderAdminTemplate_render() {
        {
            $base_slug = 'test-menu';
            $title = 'foo';
            $label = 'bar';
            $slug = 'test-submenu';
    
            // Set up the necessary variables
            $file = dirname( __DIR__ ) . '/template/file1.php';
            $template_param = ['param1' => 'value1', 'param2' => 'value2'];
    
            // Mock the current_user_can function to return true
            MonkeyFunctions\when('current_user_can')
                ->justReturn(true);

            MonkeyFunctions\expect('wp_die')
                ->never();

            $adminMenu = new ConcreteAdminMenu($base_slug, $title, $label, $slug);
    
            $adminMenu->render_admin_template($file, $template_param);
            $this->expectOutputString('Hello, World!');
        }
    }

    public function testRenderAdminTemplate_not_render() {
        {
            $base_slug = 'test-menu';
            $title = 'foo';
            $label = 'bar';
            $slug = 'test-submenu';
   
            MonkeyFunctions\when('current_user_can')
                ->justReturn(false);

            // Mock execution of wp_die by raising an exception
            MonkeyFunctions\expect('wp_die')
                ->once()
                ->andThrow("RuntimeException");

            $this->expectException(\RuntimeException::class);

            $adminMenu = new ConcreteAdminMenu($base_slug, $title, $label, $slug);
            $adminMenu->render_admin_template('');
        }
    }
}

class ConcreteAdminMenu extends AdminMenu {

    public function __construct($base_slug, $title, $label, $slug) {
        parent::__construct($base_slug, $title, $label, $slug);
    }

    public function init_section() {
        echo 'init_section';
    }
    public function init_field() {
        echo 'init_field';
    }
    public function init_register_settings() {
        echo 'init_register_settings';
    }
    public function render(){

    }

}