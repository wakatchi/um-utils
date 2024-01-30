<?php

namespace Wakatchi\WPUtils;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

class ShortFunctionsTest extends TestCase{
    
    function testCurrensyDisplayFormat() {
        {
            $expected = '0円';
            $result = ShortFunctions::currensy_display_format(null);
            $this->assertEquals($expected, $result);
        }
        {
            $expected = '0円';
            $result = ShortFunctions::currensy_display_format('');
            $this->assertEquals($expected, $result);
        }
        {
            $expected = '100円';
            $result = ShortFunctions::currensy_display_format(100);
            $this->assertEquals($expected, $result);
        }
        {
            $expected = 'foo';
            $result = ShortFunctions::currensy_display_format(null,$expected);
            $this->assertEquals($expected, $result);
        }
        {
            $expected = '1,000円';
            $result = ShortFunctions::currensy_display_format(1000);
            $this->assertEquals($expected, $result);
        }
        {
            $expected = '-1円';
            $result = ShortFunctions::currensy_display_format(-1);
            $this->assertEquals($expected, $result);
        }
    }

    function testShortenCharacters() {
        // 文字列がそのまま返戻
        {
            $str = str_repeat("a",50);
            $actual = ShortFunctions::shorten_characters($str);
            $this->assertEquals($actual,$str);
        }
        // サイズ指定
        {
            $str = str_repeat("b",50);
            $actual = ShortFunctions::shorten_characters($str,49);
            $this->assertEquals(mb_substr($actual,0,49),mb_substr($str,0,49));
            $this->assertEquals(mb_substr($actual,-3),"...");
        }
        // デフォルト文字サイズ（100）に省略される
        {
            $str = str_repeat("c",101);
            $actual = ShortFunctions::shorten_characters($str);
            $this->assertEquals(mb_substr($actual,0,100),mb_substr($str,0,100));
            $this->assertEquals(mb_substr($actual,-3),"...");
        }
        // サイズ指定
        {
            $str = str_repeat("d",101);
            $actual = ShortFunctions::shorten_characters($str,49);
            $this->assertEquals(mb_substr($actual,0,49),mb_substr($str,0,49));
            $this->assertEquals(mb_substr($actual,-3),"...");
        }
    }
    public function testDatetimeDisplayFormat_yyyyMM(){
        // 空
        {
            $actual = ShortFunctions::datetime_display_format_yyyyMM(null);
            $this->assertEmpty($actual);
        }
        // 代替文字列指定
        {
            $actual = ShortFunctions::datetime_display_format_yyyyMM(null,"foo");
            $this->assertEquals($actual,'foo');
        }
        // 通常変換
        {
            $now = '2020-03-01';
            $actual = ShortFunctions::datetime_display_format_yyyyMM($now);
            $this->assertEquals($actual,'2020年03月');
        }
        // 通常変換
        {
            $now = '2020-12-15';
            $actual = ShortFunctions::datetime_display_format_yyyyMM($now);
            $this->assertEquals($actual,'2020年12月');
        }
    }

    public function testDatetimeDisplayFormat_yyyyMMdd(){
        // 空
        {
            $actual = ShortFunctions::datetime_display_format_yyyyMMdd(null);
            $this->assertEmpty($actual);
        }
        // 代替文字列指定
        {
            $actual = ShortFunctions::datetime_display_format_yyyyMMdd(null,"foo");
            $this->assertEquals($actual,'foo');
        }
        // 通常変換
        {
            $now = '2020-03-01';
            $actual = ShortFunctions::datetime_display_format_yyyyMMdd($now);
            $this->assertEquals($actual,'2020年03月01日');
        }
        // 通常変換
        {
            $now = '2020-03-15';
            $actual = ShortFunctions::datetime_display_format_yyyyMMdd($now);
            $this->assertEquals($actual,'2020年03月15日');
        }
    }

    public function testDatetimeDisplayFormat_yyyyMMddhhmm(){
        // 空
        {
            $actual = ShortFunctions::datetime_display_format_yyyyMMddhhmm(null);
            $this->assertEmpty($actual);
        }
        // 代替文字列指定
        {
            $actual = ShortFunctions::datetime_display_format_yyyyMMddhhmm(null,"foo");
            $this->assertEquals($actual,'foo');
        }
        // 通常変換
        {
            $now = '2020-03-01 08:10';
            $actual = ShortFunctions::datetime_display_format_yyyyMMddhhmm($now);
            $this->assertEquals($actual,'2020年03月01日 08時10分');
        }
        // 通常変換
        {
            $now = '2020-03-15 08:10';
            $actual = ShortFunctions::datetime_display_format_yyyyMMddhhmm($now);
            $this->assertEquals($actual,'2020年03月15日 08時10分');
        }
    }

    /**
     */
    public function testValidateArray(){
        {
            $actual = ShortFunctions::validate_array( [""] );
            $this->assertTrue($actual);
        }
        {
            $actual = ShortFunctions::validate_array( ["",""] );
            $this->assertTrue($actual);
        }
        {
            $actual = ShortFunctions::validate_array( [] );
            $this->assertFalse($actual);
        }
        {
            $actual = ShortFunctions::validate_array( null );
            $this->assertFalse($actual);
        }
        {
            $actual = ShortFunctions::validate_array( "" );
            $this->assertFalse($actual);
        }
    }

    public function testSafetyUnset(){
        // 一つだけ無効化
        {
            $actual = [
                "foo" => "bar",
                "scott" => "tiger",
            ] ;
            ShortFunctions::safety_unset($actual,"foo");
            $this->assertArrayNotHasKey("foo",$actual,"keyが削除されていない");
        }
        // 可変引数で無効化
        {
            $actual = [
                "foo" => "bar",
                "scott" => "tiger",
            ] ;
            ShortFunctions::safety_unset($actual,"foo","scott");
            $this->assertArrayNotHasKey("foo",$actual,"keyが削除されていない");
            $this->assertArrayNotHasKey("scott",$actual,"keyが削除されていない");
        }
    }

}