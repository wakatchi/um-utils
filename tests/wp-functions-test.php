<?php

namespace Wakatchi\WPUtils;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

class WPFunctionTest extends TestCase {
    
    public function testIsAdminIser(){
        // admin
        {
            wp_set_current_user( 1, "administrator" );
            $actual = wk_is_admin_user() ;
            $this->assertTrue($actual);
        }
        // foo
        {
            wp_set_current_user( 2, "foo" );
            $actual = wk_is_admin_user() ;
            $this->assertFalse($actual);
        }
    }

    public function testNVL_user_id(){
        // not null
        {
            $expect = 5 ;
            $actual = wk_nvl_user_id($expect) ;
            $this->assertEquals($expect,$actual);
        }
        // null
        {
            $expect = wp_create_user( "foo","bar");
            wp_set_current_user($expect);
            $actual = wk_nvl_user_id(null) ;
            $this->assertEquals($expect,$actual);

            wp_delete_user($expect);
        }
    }

    public function testWkLoadContent() {
        // Test case 1: Verify that the function returns the expected output
        $expectedOutput = "Hello, World!";
        $file = dirname( __DIR__ ) . '/tests/template/file1.php';
        $actualOutput = wk_load_content($file);
        $this->assertEquals($expectedOutput, $actualOutput);

        // Test case 2: Verify that the function handles parameters correctly
        $expectedOutput = "Hello, John!";
        $file = dirname( __DIR__ ) . '/tests/template/file2.php';
        $param = [
            'key' => $expectedOutput
        ];
        $actualOutput = wk_load_content($file, $param);
        $this->assertEquals($expectedOutput, $actualOutput);

        // Test case 3: Verify that the function handles null parameters correctly
        $expectedOutput = "Hello, World!";
        $file = dirname( __DIR__ ) . '/tests/template/file1.php';
        $param = null;
        $actualOutput = wk_load_content($file, $param);
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}