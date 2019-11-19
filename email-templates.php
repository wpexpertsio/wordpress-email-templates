<?php

/**
 * Email Templates
 *
 * @link              https://wp.timersys.com
 * @since             1.0.0
 * @package           Mailtpl
 *
 * @wordpress-plugin
 * Plugin Name:       Email Templates
 * Plugin URI:        http://wordpress.org/plugins/email-templates
 * Description:       Beautify WordPress default emails
 * Version:           1.3.1.2
 * Author:            Damian Logghe
 * Author URI:        https://wp.timersys.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       email-templates
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MAILTPL_VERSION'       , '1.3.1.2');
define( 'MAILTPL_PLUGIN_FILE'   , __FILE__);
define( 'MAILTPL_PLUGIN_DIR'    , plugin_dir_path(__FILE__) );
define( 'MAILTPL_PLUGIN_URL'    , plugin_dir_url(__FILE__) );
define( 'MAILTPL_PLUGIN_HOOK'   , basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mailtpl-activator.php
 */
function activate_mailtpl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mailtpl-activator.php';
	Mailtpl_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mailtpl-deactivator.php
 */
function deactivate_mailtpl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mailtpl-deactivator.php';
	Mailtpl_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mailtpl' );
register_deactivation_hook( __FILE__, 'deactivate_mailtpl' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mailtpl.php';

/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
function Mailtpl() {

	$plugin = Mailtpl::instance();
	$plugin->run();

}
Mailtpl();
