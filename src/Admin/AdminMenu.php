<?php

namespace Wakatchi\UMUtils\Admin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class AdminMenu
 * 
 * Represents an admin menu item.
 */
abstract class AdminMenu {

	/**
	 * @var string The base slug of the admin menu.
	 */
	private $base_slug;

	/**
	 * @var string The title of the admin menu.
	 */
	private $title;

	/**
	 * @var string The label of the admin menu.
	 */
	private $label;

	/**
	 * @var string The slug of the admin menu.
	 */
	private $slug;


	/**
	 * AdminMenu constructor.
	 *
	 * @param string $base_slug The base slug of the admin menu.
	 * @param string $title The title of the admin menu.
	 * @param string $label The label of the admin menu.
	 * @param string $slug The slug of the admin menu.
	 */
	public function __construct($base_slug, $title, $label, $slug) {
		$this->base_slug = $base_slug;
		$this->title = $title;
		$this->label = $label;
		$this->slug = $slug;
		$this->init();
	}

	/**
	 * Initializes the admin menu.
	 */
	function init() {	
		add_action('admin_menu', array( &$this,'add_submenu'));
		add_action('admin_init', array( &$this,'init_section'));
		add_action('admin_init', array( &$this,'init_field'));
		add_action('admin_init', array( &$this,'init_register_settings'));
	}

	protected abstract function render() ;
	protected abstract function init_section() ;
	protected abstract function init_field() ;
	protected abstract function init_register_settings() ;

	function add_submenu() {
		add_submenu_page(
			$this->base_slug,
			$this->title,
			$this->label,
			'manage_options',
			$this->slug,
			array( $this, 'render' )
		);
	}

	function render_admin_template($file,$template_param = []) {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		include($file); ;
	}
}
