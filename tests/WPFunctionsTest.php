<?php

namespace Wakatchi\UMUtils;

use stdClass;
use Yoast\WPTestUtils\BrainMonkey\TestCase;

class WPFunctionsTest extends TestCase {
    
    public function testIsAdminIser(){
        // admin
        {
            wp_set_current_user( 1, "administrator" );
            $actual = WPFunctions::is_admin_user() ;
            $this->assertTrue($actual);
        }
        // foo
        {
            wp_set_current_user( 2, "foo" );
            $actual = WPFunctions::is_admin_user() ;
            $this->assertFalse($actual);
        }
    }

    public function testNVL_user_id(){
        // not null
        {
            $expect = 5 ;
            $actual = WPFunctions::nvl_user_id($expect) ;
            $this->assertEquals($expect,$actual);
        }
        // null
        {
            $expect = wp_create_user( "foo","bar");
            wp_set_current_user($expect);
            $actual = WPFunctions::nvl_user_id(null) ;
            $this->assertEquals($expect,$actual);

            wp_delete_user($expect);
        }
    }

    public function testWkLoadContent() {
        // Test case 1: Verify that the function returns the expected output
        $expectedOutput = "Hello, World!";
        $file = dirname( __DIR__ ) . '/tests/template/file1.php';
        $actualOutput = WPFunctions::load_content($file);
        $this->assertEquals($expectedOutput, $actualOutput);

        // Test case 2: Verify that the function handles parameters correctly
        $expectedOutput = "Hello, John!";
        $file = dirname( __DIR__ ) . '/tests/template/file2.php';
        $param = [
            'key' => $expectedOutput
        ];
        $actualOutput = WPFunctions::load_content($file, $param);
        $this->assertEquals($expectedOutput, $actualOutput);

        // Test case 3: Verify that the function handles null parameters correctly
        $expectedOutput = "Hello, World!";
        $file = dirname( __DIR__ ) . '/tests/template/file1.php';
        $param = null;
        $actualOutput = WPFunctions::load_content($file, $param);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testGetCurrentPageUrl()
    {
        // Test case 1: Verify that the function returns the expected URL
        $_SERVER["REQUEST_URI"] = "/page1";
        $expectedUrl = get_site_url() . "/page1";
        $actualUrl = WPFunctions::get_current_page_url();
        $this->assertEquals($expectedUrl, $actualUrl);

        // Test case 2: Verify that the function handles query parameters correctly
        $_SERVER["REQUEST_URI"] = "/page2?param1=value1&param2=value2";
        $expectedUrl = get_site_url() . "/page2?param1=value1&param2=value2";
        $actualUrl = WPFunctions::get_current_page_url();
        $this->assertEquals($expectedUrl, $actualUrl);

        // Test case 3: Verify that the function handles special characters in the URL correctly
        $_SERVER["REQUEST_URI"] = "/page3?param=value%20with%20spaces";
        $expectedUrl = get_site_url() . "/page3?param=value%20with%20spaces";
        $actualUrl = WPFunctions::get_current_page_url();
        $this->assertEquals($expectedUrl, $actualUrl);
    }

    public function testGetHostUrl()
    {
        // Test case 1: Verify that the function returns the expected URL
        $expectedUrl = home_url();
        $actualUrl = WPFunctions::get_host_url();
        $this->assertEquals($expectedUrl, $actualUrl);
    }

    public function testIsCurrentAuther(){
        {
            $expect = wp_create_user( "foo","bar");
            $user = wp_set_current_user($expect);

            $my_post = array(
                'post_title'    => 'foo',
                'post_content'  => 'bar',
                'post_status'   => 'publish',
                'post_author'   => $user->ID
            );
            $post_id = wp_insert_post( $my_post ) ;

            global $post;
            $post = get_post($post_id);
            setup_postdata( $post );

            $actual = WPFunctions::is_current_auther();
            $this->assertTrue($actual);
        }
        {
            $expect = wp_create_user( "foo","bar");
            $user = wp_set_current_user($expect);

            $my_post = array(
                'post_title'    => 'foo',
                'post_content'  => 'bar',
                'post_status'   => 'publish',
                'post_author'   => '555555'
            );
            $post_id = wp_insert_post( $my_post ) ;

            global $post;
            $post = get_post($post_id);
            setup_postdata( $post );

            $actual = WPFunctions::is_current_auther();
            $this->assertFalse($actual);
        }
    }

    public function testDeserializeUsermetaValues()
    {
        {
            // Test case 1: Verify that the method returns an empty array when given an empty array
            $metaValues = [];
            $expectedOutput = [];
            $actualOutput = WPFunctions::deserialize_usermeta_values($metaValues);
            $this->assertEquals($expectedOutput, $actualOutput);
        }
        {
            // Test case 2: Verify that the method correctly deserializes and merges the values
            $metaValues = ['a:1:{i:0;s:3:"foo";}', 'a:1:{i:0;s:3:"bar";}'];
            $expectedOutput = ['foo', 'bar'];
            $actualOutput = WPFunctions::deserialize_usermeta_values($metaValues);
            $this->assertEquals($expectedOutput, $actualOutput);
        }
        {
            // Test case 3: Verify that the method handles non-array values correctly
            $metaValues = 'a:1:{i:0;s:3:"baz";}';
            $expectedOutput = [];
            $actualOutput = WPFunctions::deserialize_usermeta_values($metaValues);
            $this->assertEquals($expectedOutput, $actualOutput);
        }
        {
            // Test case 4: Verify that the method removes duplicate values
            $metaValues = ['a:1:{i:0;s:3:"foo";}', 'a:1:{i:0;s:3:"foo";}'];
            $expectedOutput = ['foo'];
            $actualOutput = WPFunctions::deserialize_usermeta_values($metaValues);
            $this->assertEquals($expectedOutput, $actualOutput);
        }
    }
}


