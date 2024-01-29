<?php

namespace Wakatchi\WPUtils;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

class ShortFunctionTest extends TestCase{
    
    function testWk_currensy_display_format() {
        // Test case 1: Empty price
        $result = wk_currensy_display_format('', '0円');
        assert($result === '0円', 'Test case 1 failed');
    
        // Test case 2: Non-empty price
        $result = wk_currensy_display_format(1000);
        assert($result === '1,000円', 'Test case 2 failed');
    
        // Test case 3: Non-empty price with custom alt text
        $result = wk_currensy_display_format(2000, 'N/A');
        assert($result === '2,000円', 'Test case 3 failed');
    
        // Test case 4: Non-empty price with empty alt text
        $result = wk_currensy_display_format(3000, '');
        assert($result === '3,000円', 'Test case 4 failed');
    }
}