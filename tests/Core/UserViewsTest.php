<?php

namespace Wakatchi\UMUtils\Core;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

class UserViewsTest extends TestCase {
    private $user_id_1 ;
    private $user_id_2 ;
    private $user_id_3 ;

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
        $this->user_id_3 = wp_insert_user([
            'user_login' => 'scott',
            'user_pass'  => 'tiger',
            'user_email' => 'scott@example.com',
            'role'       => 'publisher'
        ]);
        UM()->user()->generate_profile_slug($this->user_id_1);
        UM()->user()->generate_profile_slug($this->user_id_2);
        UM()->user()->generate_profile_slug($this->user_id_3);
    }

    public function tearDown() : void {
        if( has_filter('wum_get_current_time') ){
            remove_all_filters('wum_get_current_time');
        }  

        UM()->user()->set($this->user_id_1);
        UM()->user()->delete();
        UM()->user()->set($this->user_id_2);
        UM()->user()->delete();
        UM()->user()->set($this->user_id_3);
        UM()->user()->delete();
        parent::tearDown();
    }

    public function testAddViewedUser(){
        $userViews = new UserViews();
        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);
        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(1, $actual);
    }
    public function testAddViewedUser_user_id_null(){
        $userViews = new UserViews();
        $userViews->add_viewed_user(null,$this->user_id_2);
        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(0, $actual);
    }

    public function testAddViewedUser_viewed_user_null(){
        wp_set_current_user( get_user_by('ID',$this->user_id_2));

        $userViews = new UserViews();
        $userViews->add_viewed_user($this->user_id_1);
        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(1, $actual);
    }

    public function testAddViewedUser_guest_user(){
        $userViews = new UserViews();
        $userViews->add_viewed_user($this->user_id_1,null);
        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(1, $actual);
    }

    public function testAddViewedUser_duplicate_user(){
        $userViews = new UserViews();

        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);
        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);

        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(1, $actual);
    }

    public function testAddViewedUser_2_user(){
        $userViews = new UserViews();

        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);
        $userViews->add_viewed_user($this->user_id_1, $this->user_id_3);

        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(2, $actual);
    }

    public function testAddViewedUser_no_view_count(){
        $userViews = new UserViews();
        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);
        
        // Update the current date by 1 day
        add_filter('wum_get_current_time',function($time){
            return $time + UserViews::VIEW_UNIT_DAY;
        });
        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(0, $actual);
    }

    public function testAddViewedUser_2_days(){
        $userViews = new UserViews();

        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);
        add_filter('wum_get_current_time',function($time){
            return $time + UserViews::VIEW_UNIT_DAY;
        });
        $userViews->add_viewed_user($this->user_id_1, $this->user_id_3);
        remove_filter('wum_get_current_time',function($time){
            return $time + UserViews::VIEW_UNIT_DAY;
        });
        $actual = $userViews->get_user_view_count($this->user_id_1);
        $this->assertEquals(1, $actual);
    }

    public function testAddViewedUser_week(){
        $userViews = new UserViews();

        $userViews->add_viewed_user($this->user_id_1, $this->user_id_2);
        add_filter('wum_get_current_time',function($time){
            return $time + UserViews::VIEW_UNIT_DAY;
        });
        $userViews->add_viewed_user($this->user_id_1, $this->user_id_3);
        $actual = $userViews->get_user_view_count($this->user_id_1, UserViews::VIEW_UNIT_WEEK);
        $this->assertEquals(2, $actual);
    }
}