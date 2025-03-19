<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tirony.me
 * @since             1.0.0
 * @package           Rony_Bricks_Builder_Addons
 *
 * @wordpress-plugin
 * Plugin Name:       Bricks Builder Addons
 * Plugin URI:        https://tirony.me
 * Description:       Some useful adons for bricks builder
 * Version:           1.0.0
 * Author:            t.i. rony
 * Author URI:        https://tirony.me/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rony-bricks-builder-addons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RONY_BRICKS_BUILDER_ADDONS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rony-bricks-builder-addons-activator.php
 */
function activate_rony_bricks_builder_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rony-bricks-builder-addons-activator.php';
	Rony_Bricks_Builder_Addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rony-bricks-builder-addons-deactivator.php
 */
function deactivate_rony_bricks_builder_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rony-bricks-builder-addons-deactivator.php';
	Rony_Bricks_Builder_Addons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rony_bricks_builder_addons' );
register_deactivation_hook( __FILE__, 'deactivate_rony_bricks_builder_addons' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rony-bricks-builder-addons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rony_bricks_builder_addons() {

	$plugin = new Rony_Bricks_Builder_Addons();
	$plugin->run();

}
run_rony_bricks_builder_addons();
