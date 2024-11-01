<?php
/**
 * Plugin Name:       VitalEdge Pixel
 * Description:       Reveal the consumer identities of your website traffic. Automatically builds a marketable, contactable database from never-before-seen anonymous visitors.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            VitalEdge
 * Author URI:        https://vitaledge.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_vitaledge_plugin() {
	VitalEdgeInc\VeCore\VeActivate::activate();
}
register_activation_hook( __FILE__, 'activate_vitaledge_plugin' );


/**
 * The code that runs during plugin deactivation
 */
function deactivate_vitaledge_plugin() {
	VitalEdgeInc\VeCore\VeDeactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_vitaledge_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'VitalEdgeInc\\VeInit' ) ) {
	VitalEdgeInc\VeInit::register_services();
}