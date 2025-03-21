<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Rony_Bricks_Builder_Addons
 * @subpackage Rony_Bricks_Builder_Addons/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rony_Bricks_Builder_Addons
 * @subpackage Rony_Bricks_Builder_Addons/admin
 * @author     t.i. rony <touhid_rony@yahoo.com>
 */
class Rony_Bricks_Builder_Addons_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Add the submenu to Bricks menu - using priority 999 to ensure the Bricks menu exists first
		add_action( 'admin_menu', array( $this, 'add_settings_page' ), 999 );

		// Register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rony_Bricks_Builder_Addons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rony_Bricks_Builder_Addons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rony-bricks-builder-addons-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rony_Bricks_Builder_Addons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rony_Bricks_Builder_Addons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rony-bricks-builder-addons-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add a submenu under the Bricks Builder menu
	 *
	 * @since    1.0.0
	 */
	public function add_settings_page() {
		// Check if Bricks Builder is active
		if ( class_exists( 'Bricks\Elements' ) ) {
			// Using the proper parent slug and making sure it runs late enough
			add_submenu_page(
				'bricks', // Parent slug (Bricks menu)
				__( 'Rony Addons Settings', 'rony-bricks-builder-addons' ), // Page title
				__( 'Rony Addons', 'rony-bricks-builder-addons' ), // Menu title
				'manage_options', // Capability
				'rony-bricks-addons', // Menu slug
				array( $this, 'render_settings_page' ) // Callback function
			);
		}
	}

	/**
	 * Register plugin settings
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {
		// Register a setting
		register_setting(
			'rony_bricks_addons_settings', // Option group
			'rony_bricks_addons_elements', // Option name
			array(
				'type' => 'array',
				'sanitize_callback' => array( $this, 'sanitize_elements_settings' ),
				'default' => array(
					'thumbnails-slider' => true,
					'dynamic-thumbnails-slider' => true,
				),
			)
		);

		// Add a settings section
		add_settings_section(
			'rony_bricks_addons_elements_section', // ID
			__( 'Elements Settings', 'rony-bricks-builder-addons' ), // Title
			array( $this, 'elements_section_callback' ), // Callback
			'rony-bricks-addons' // Page
		);

		// Get available elements
		$elements = $this->get_available_elements();

		// Add settings fields for each element
		foreach ( $elements as $element_id => $element_name ) {
			add_settings_field(
				'element_' . $element_id, // ID
				$element_name, // Title
				array( $this, 'element_field_callback' ), // Callback
				'rony-bricks-addons', // Page
				'rony_bricks_addons_elements_section', // Section
				array(
					'element_id' => $element_id, // Args
					'label_for' => 'element_' . $element_id,
				)
			);
		}
	}

	/**
	 * Get list of available elements
	 *
	 * @since    1.0.0
	 * @return   array    Array of element IDs and names
	 */
	private function get_available_elements() {
		return array(
			'thumbnails-slider' => __( 'Thumbnails Slider', 'rony-bricks-builder-addons' ),
			'dynamic-thumbnails-slider' => __( 'Dynamic Thumbnails Slider (requires ACF)', 'rony-bricks-builder-addons' ),
		);
	}

	/**
	 * Sanitize elements settings
	 *
	 * @since    1.0.0
	 * @param    array    $input    The input array to sanitize
	 * @return   array    Sanitized array
	 */
	public function sanitize_elements_settings( $input ) {
		$sanitized_input = array();
		
		$elements = $this->get_available_elements();
		
		foreach ( $elements as $element_id => $element_name ) {
			$sanitized_input[$element_id] = isset( $input[$element_id] ) ? (bool) $input[$element_id] : false;
		}
		
		return $sanitized_input;
	}

	/**
	 * Section callback
	 *
	 * @since    1.0.0
	 * @param    array    $args    The section arguments
	 */
	public function elements_section_callback( $args ) {
		echo '<p>' . __( 'Enable or disable individual elements from the Rony Bricks Builder Addons plugin.', 'rony-bricks-builder-addons' ) . '</p>';
	}

	/**
	 * Element field callback
	 *
	 * @since    1.0.0
	 * @param    array    $args    The field arguments
	 */
	public function element_field_callback( $args ) {
		$element_id = $args['element_id'];
		$option_name = 'rony_bricks_addons_elements';
		$options = get_option( $option_name, array(
			'thumbnails-slider' => true,
			'dynamic-thumbnails-slider' => true,
		) );
		$checked = isset( $options[$element_id] ) ? $options[$element_id] : true;
		
		echo '<label for="element_' . esc_attr( $element_id ) . '">';
		echo '<input type="checkbox" id="element_' . esc_attr( $element_id ) . '" name="' . esc_attr( $option_name ) . '[' . esc_attr( $element_id ) . ']" value="1" ' . checked( $checked, true, false ) . '>';
		echo ' ' . __( 'Enable', 'rony-bricks-builder-addons' );
		echo '</label>';
	}

	/**
	 * Render the settings page
	 *
	 * @since    1.0.0
	 */
	public function render_settings_page() {
		?>
		<div class="wrap rony-bricks-elements-settings">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'rony_bricks_addons_settings' );
				do_settings_sections( 'rony-bricks-addons' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

}
