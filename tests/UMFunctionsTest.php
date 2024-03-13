<?php

namespace Wakatchi\UMUtils;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

class UMFunctionsTest extends TestCase {

    private $user_id_1 ;
    private $user_id_2 ;

    public function setup() : void {
        parent::setup();
        $this->user_id_1 = wp_insert_user([
            'user_login' => 'foo',
            'user_pass'  => 'foo',
            'user_email' => 'foo@example.com',
            'role'       => 'subscriber'
        ]);
        $this->user_id_2 = wp_insert_user([
            'user_login' => 'bar',
            'user_pass'  => 'bar',
            'user_email' => 'bar@example.com',
            'role'       => 'publisher'
        ]);
        UM()->user()->generate_profile_slug($this->user_id_1);
        UM()->user()->generate_profile_slug($this->user_id_2);
    }
    
    public function tearDown() : void {
        UM()->user()->set($this->user_id_1);
        UM()->user()->delete();
        UM()->user()->set($this->user_id_2);
        UM()->user()->delete();
        parent::tearDown();
    }

    public function testGetUMUserData(){
        {
            $meta_key = 'company_name';
            $expected_value = 'Foo Company';

            update_user_meta($this->user_id_1, $meta_key, $expected_value);
            wp_set_current_user( get_user_by('ID',$this->user_id_1));

            $actual = UMFunctions::get_um_user_data($this->user_id_1, $meta_key);
            $this->assertEquals($expected_value, $actual);
        }
        // switch user
        {
            $meta_key = 'company_name';
            $expected_value = 'Foo Company';

            update_user_meta($this->user_id_1, $meta_key, $expected_value);
            wp_set_current_user( get_user_by('ID',$this->user_id_2));

            $actual = UMFunctions::get_um_user_data($this->user_id_1, $meta_key);
            $this->assertEquals($expected_value, $actual);
        }
    }

    public function testGetUMOrDefault(){
        {
            $meta_key = 'company_description';
            $expected_value = 'Scott Tiger';

            update_user_meta($this->user_id_1, $meta_key, $expected_value);
            wp_set_current_user( get_user_by('ID',$this->user_id_1));

            $actual = UMFunctions::get_um_or_default($this->user_id_1, $meta_key);
            $this->assertEquals($expected_value, $actual);
        }
        // switch user
        {
            $meta_key = 'company_description';
            $expected_value = 'Scott Tiger';

            update_user_meta($this->user_id_1, $meta_key, $expected_value);
            wp_set_current_user( get_user_by('ID',$this->user_id_2));

            $actual = UMFunctions::get_um_or_default($this->user_id_1, $meta_key);
            $this->assertEquals($expected_value, $actual);
        }
        // get Default
        {
            wp_set_current_user( get_user_by('ID',$this->user_id_1));
            $actual = UMFunctions::get_um_or_default($this->user_id_1,'foo');
            $this->assertEquals('', $actual);
        }
        // set Default
        {
            wp_set_current_user( get_user_by('ID',$this->user_id_1));

            $default_value = '=======';
            $actual = UMFunctions::get_um_or_default($this->user_id_1,'foo',$default_value);
            $this->assertEquals($default_value, $actual);
        }
    }

    public function testGetUMNumberOrDefault(){
        {
            $meta_key = 'company_employee_count';
            $expected_value = 1000;

            update_user_meta($this->user_id_1, $meta_key, $expected_value);
            wp_set_current_user( get_user_by('ID',$this->user_id_1));

            $actual = UMFunctions::get_um_number_or_default($this->user_id_1, $meta_key);
            $this->assertEquals( number_format($expected_value), $actual);
        }
        // switch user
        {
            $meta_key = 'company_employee_count';
            $expected_value = 1000;

            update_user_meta($this->user_id_1, $meta_key, $expected_value);
            wp_set_current_user( get_user_by('ID',$this->user_id_2));

            $actual = UMFunctions::get_um_number_or_default($this->user_id_1, $meta_key);
            $this->assertEquals( number_format($expected_value), $actual);
        }
        // get Default
        {
            wp_set_current_user( get_user_by('ID',$this->user_id_1));
            $actual = UMFunctions::get_um_number_or_default($this->user_id_1,'foo');
            $this->assertEquals('', $actual);
        }
        // set Default
        {
            wp_set_current_user( get_user_by('ID',$this->user_id_1));

            $default_value = '=======';
            $actual = UMFunctions::get_um_number_or_default($this->user_id_1,'foo',$default_value);
            $this->assertEquals($default_value, $actual);
        }

    }
}