<?php
/**
 * Register Custom Bricks Builder Elements
 *
 * @package     Rony_Bricks_Builder_Addons
 * @author      t.i. rony
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rony_Bricks_Elements {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        // Register custom elements with Bricks
        add_action( 'init', array( $this, 'register_elements' ), 11 );
        
        // Add custom category for our elements
        add_filter( 'bricks/builder/i18n', array( $this, 'add_element_categories' ) );
    }
    
    /**
     * Register custom elements
     */
    public function register_elements() {
        // Check if Bricks is active
        if ( ! class_exists( '\Bricks\Elements' ) ) {
            return;
        }
        
        // Get element settings
        $element_settings = get_option( 'rony_bricks_addons_elements', array(
            'thumbnails-slider' => true,
            'dynamic-thumbnails-slider' => true,
        ) );
        
        // List of custom elements to register
        $element_files = array();
        
        // Add thumbnails-slider element if enabled
        if ( isset( $element_settings['thumbnails-slider'] ) && $element_settings['thumbnails-slider'] ) {
            $element_files[] = plugin_dir_path( dirname( __FILE__ ) ) . 'elements/thumbnails-slider.php';
        }
        
        // Add dynamic-thumbnails-slider element if enabled and ACF is active
        if ( isset( $element_settings['dynamic-thumbnails-slider'] ) && $element_settings['dynamic-thumbnails-slider'] ) {
            if ( function_exists( 'get_field' ) || class_exists( 'ACF' ) ) {
                $element_files[] = plugin_dir_path( dirname( __FILE__ ) ) . 'elements/dynamic-thumbnails-slider.php';
            } else if ( current_user_can( 'administrator' ) ) {
                error_log( 'ACF is not active, skipping dynamic-thumbnails-slider registration' );
            }
        }
        
        // Register each element
        foreach ( $element_files as $file ) {
            if ( file_exists( $file ) ) {
                \Bricks\Elements::register_element( $file );
            }
        }
    }
    
    /**
     * Add custom element categories
     * 
     * @param array $i18n The internationalization strings
     * @return array Modified i18n strings
     */
    public function add_element_categories( $i18n ) {
        // Add custom category
        if ( isset( $i18n['elementCategories'] ) ) {
            $i18n['elementCategories']['rony-addons'] = esc_html__( 'Rony Addons', 'rony-bricks-builder-addons' );
        }
        
        return $i18n;
    }
} 