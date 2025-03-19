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
        
        // List of custom elements to register
        $element_files = array(
            plugin_dir_path( dirname( __FILE__ ) ) . 'elements/test-element.php',
            plugin_dir_path( dirname( __FILE__ ) ) . 'elements/thumbnails-slider.php',
            // Add more element files here as needed
        );
        
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