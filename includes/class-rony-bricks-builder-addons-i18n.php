<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Rony_Bricks_Builder_Addons
 * @subpackage Rony_Bricks_Builder_Addons/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rony_Bricks_Builder_Addons
 * @subpackage Rony_Bricks_Builder_Addons/includes
 * @author     t.i. rony <touhid_rony@yahoo.com>
 */
class Rony_Bricks_Builder_Addons_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rony-bricks-builder-addons',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
