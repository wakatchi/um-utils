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
}