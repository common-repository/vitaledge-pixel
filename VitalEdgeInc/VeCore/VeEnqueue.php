<?php 

namespace VitalEdgeInc\VeCore;

use \VitalEdgeInc\VeCore\VeBaseController;
use \VitalEdgeInc\VeApi\VePixelApi;

class VeEnqueue extends VeBaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action('wp_head',array($this,'addPixelScript'), 10);
		
	}
	
	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/style.css' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/script.js' );
	}

	function addPixelScript(){
		//install pixel by adding pixel script
		$vitaledge = new VePixelApi();
		$pixelId = get_option('ve_px_id');
		$script1 = get_option('ve_script_1');
		$script2 = get_option('ve_script_2');
		if (!empty($pixelId)){			
			$script1 = html_entity_decode($script1);
			$script2 = mb_convert_encoding($script2, "UTF-8", "HTML-ENTITIES");

			// echo esc_attr($script1);
			// echo esc_attr($script2);
			// using esc functions only displays it on users end, what we are trying is to integrate a script
			print($script1);
			print($script2);

			// $script_params = array(
			// 	'script1' => $script1,
			// 	'script2' => $script2,
			// );
			// wp_enqueue_script( 'jquery' );
			// wp_enqueue_script( 'pixeljs', $this->plugin_url . 'assets/pixel-script.js' );
			// wp_localize_script( 'pixeljs', 'scriptParams', $script_params );
		}
	}
}