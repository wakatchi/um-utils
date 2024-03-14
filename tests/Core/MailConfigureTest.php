<?php

namespace Wakatchi\UMUtils\Core;

use Mockery;
use Brain\Monkey\Functions as MonkeyFunctions;
use Wakatchi\UMUtils\Core\ContentsRenderer;
use Yoast\WPTestUtils\BrainMonkey\TestCase;

class MailConfigureTest extends TestCase {

    public function testAddFilter(){
        $mail = new ConcreteMail();
        $this->assertSame(10,has_filter('um_email_notifications', [$mail, 'config_email_notifications']));
        $this->assertSame(10,has_filter('um_email_templates_path_by_slug', [$mail, 'email_templates_path_by_slug']));
    }

    public function testEmailTemplatesPathBySlug()
    {
        // path_by_slug is empty
        {
            $mail = new ConcreteMail();
            $path_by_slug = [];
            $expected = [
                'mail1' => __DIR__ . '/templates/mail/', 
                'mail2' => __DIR__ . '/templates/mail/'
            ];
            $actual = $mail->email_templates_path_by_slug($path_by_slug);
            $this->assertEquals($expected, $actual);
        }
        // path_by_slug is not empty
        {
            $mail = new ConcreteMail();
            $path_by_slug = [
                'mail3' => __DIR__ . '/templates/mail/', 
                'mail4' => __DIR__ . '/templates/mail/'
            ];
            $expected = [
                'mail3' => __DIR__ . '/templates/mail/',
                'mail4' => __DIR__ . '/templates/mail/',
                'mail1' => __DIR__ . '/templates/mail/',
                'mail2' => __DIR__ . '/templates/mail/'];
            $actual = $mail->email_templates_path_by_slug($path_by_slug);
            $this->assertEquals($expected, $actual);
        }
    }

    public function testConfigEmailNotifications()
    {
        $mail = new ConcreteMail();
        $emails = [];

        $actuals = $mail->config_email_notifications($emails);

        $expected_email = $mail->get_custom_emails();
        $this->assertEquals( count($expected_email), count($actuals) );

        foreach( $expected_email as $expected_slug => $expected_email){
            $this->assertArrayHasKey($expected_slug, $actuals);
            $this->assertEquals($expected_email, $actuals[$expected_slug]);

            $actual_email = $actuals[$expected_slug];
            // body
            $this->assertEquals($expected_email['body'], $actual_email['body']);

            // -- UM Check
            // on/off
            $actual_option_on = UM()->options()->get($expected_slug.'_on');
            $this->assertEquals($expected_email['default_active'], $actual_option_on);

            // subject
            $actual_subject = UM()->options()->get($expected_slug.'_sub');
            $this->assertEquals($expected_email['subject'], $actual_subject);
        }

    }
}

class ConcreteMail extends MailConfigure {

	function get_custom_emails(){
        $custom_emails = array(
            "slug1" => array(
                'key'			=> 'slug1',
                'subject'		=> 'subject1',
                'body'			=> 'aaaa',
                'default_active'=> true
            ),
            "slug2" => array(
                'key'			=> 'slug2',
                'subject'		=> 'subject2',
                'body'			=> 'bbbb',
                'default_active'=> false
            ),
            "mail1" => array(
                'key'			=> 'mail1',
                'subject'		=> 'subject3',
                'body'			=> '',
                'default_active'=> true
            ),
        );
        return $custom_emails;
    }
	function get_email_templates_path(){
        return __DIR__ . '/templates/mail/';
    }
	function get_mail_slugs(){
        return ['mail1','mail2'];
    }

}