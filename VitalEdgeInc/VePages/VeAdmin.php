<?php 

namespace VitalEdgeInc\VePages;

use \VitalEdgeInc\VeCore\VeBaseController;
use \VitalEdgeInc\VeApi\VeSettingsApi;
use \VitalEdgeInc\VeApi\VeCallbacks\VeAdminCallbacks;
use \VitalEdgeInc\VeApi\VePixelApi;

/**
* 
*/
class VeAdmin extends VeBaseController
{
	public $settings;

	public $client;

	public $pages = array();

	public $callbacks;

	//public $subpages = array();

	public function register() 
	{
		$this->settings = new VeSettingsApi();
		$this->callbacks = new VeAdminCallbacks();
		$this->client = new VePixelApi();
		$this->setPages();
		$this->setSubPages();
		$this->setSettings();
		$this->settings->addPages( $this->pages )->register();

		// $this->client->test();
	}

	public function setPages()
	{
		$this->pages = array(
			array(
				'page_title' => 'VitalEdge Pixel Plugin', 
				'menu_title' => 'VitalEdge Pixel', 
				'capability' => 'manage_options', 
				'menu_slug' => 'vitaledge_plugin',
				'callback' => array($this->callbacks, 'adminDashboard'),
				'icon_url' => plugin_dir_url( dirname(__DIR__))."assets/images/logo-vitaledge.png"	,
				'position' => 110
			)
		);
	}

	public function setSubPages()
	{
		// $this->subpages = array(
		// 	array(
		// 		'parent_slug' => 'vitaledge_plugin', 
		// 		'page_title' => 'Custom Post Types', 
		// 		'menu_title' => 'CPT', 
		// 		'capability' => 'manage_options', 
		// 		'menu_slug' => 'vitaledge_cpt', 
		// 		'callback' => function() { echo '<h1>CPT Manager</h1>'; }
		// 	),
		// 	array(
		// 		'parent_slug' => 'vitaledge_plugin', 
		// 		'page_title' => 'Custom Taxonomies', 
		// 		'menu_title' => 'Taxonomies', 
		// 		'capability' => 'manage_options', 
		// 		'menu_slug' => 'vitaledge_taxonomies', 
		// 		'callback' => function() { echo '<h1>Taxonomies Manager</h1>'; }
		// 	),
		// 	array(
		// 		'parent_slug' => 'vitaledge_plugin', 
		// 		'page_title' => 'Custom Widgets', 
		// 		'menu_title' => 'Widgets', 
		// 		'capability' => 'manage_options', 
		// 		'menu_slug' => 'vitaledge_widgets', 
		// 		'callback' => function() { echo '<h1>Widgets Manager</h1>'; }
		// 	)
		// );
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'vitaledge_options_group',
				'option_name' => 'pixel_id',
				'callback' => array( $this->callbacks, 'veOptionsGroup')
			)
		);

		$this->settings->setSettings($args);
	}
}