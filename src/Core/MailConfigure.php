<?php

namespace Wakatchi\UMUtils\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Abstract class responsible for Ultimate Member email settings
 */
abstract class MailConfigure {

    function __construct() {
        add_filter( 'um_email_notifications',	        array( &$this,'config_email_notifications'),10,3);
        add_filter( 'um_email_templates_path_by_slug',	array( &$this,'email_templates_path_by_slug'), 10,3 );
    }

	protected abstract function get_custom_emails() ;
	protected abstract function get_email_templates_path() ;
	protected abstract function get_mail_slugs() ;

    /**
     * Configures email notifications.
     *
     * @param array $emails The array of email notifications.
     * @return array The updated array of email notifications.
     */
    function config_email_notifications( $emails ) {
        $custom_emails = $this->get_custom_emails();

        foreach($custom_emails as $slug => $custom_email){
            $option = UM()->options()->get($slug.'_on');
            if( !$option ) {
                UM()->options()->update($slug.'_on', empty( $custom_email['default_active']) ? 0 : 1);
                UM()->options()->update($slug.'_sub', $custom_email['subject']);
            }
            $located = UM()->mail()->locate_template($slug) ;
            if( !file_exists($located)){
                file_put_contents(($located),$custom_email['body']);
            }
            $emails[ $slug ] = $custom_email;
        }
        return $emails;
    }

    /**
     * Returns an array of email templates paths by slug.
     *
     * @param array $path_by_slug The existing array of paths by slug.
     * @return array The updated array of paths by slug.
     */
    function email_templates_path_by_slug($path_by_slug){  
        $email_templates_path = $this->get_email_templates_path() ;
        $mail_slugs = $this->get_mail_slugs() ;

        $array = [];
        foreach($mail_slugs as $slug){
            $array[$slug] = $email_templates_path;
        }
        return array_merge($path_by_slug,$array);
    }
}


