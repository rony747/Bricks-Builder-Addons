<?php
/**
 * Dynamic Thumbnails Slider Element for Bricks Builder
 * Uses ACF Gallery Field
 *
 * @package     Rony_Bricks_Builder_Addons
 * @author      t.i. rony
 * @since       1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Rony_Bricks_Builder_Dynamic_Thumbnails_Slider extends \Bricks\Element {
    // Element properties
    public $category = 'rony-addons';
    public $name = 'rony-dynamic-thumbnails-slider';
    public $icon = 'ti-layout-slider-alt';
    public $css_selector = '.rony-dynamic-thumbnails-slider-wrapper';
    public $scripts = ['ronyDynamicThumbnailsSlider'];
    public $nestable = false;

    // Return localized element label
    public function get_label() {
        return esc_html__('Dynamic Thumbnails Slider', 'rony-bricks-builder-addons');
    }

    // Set keywords to search for this element
    public function get_keywords() {
        return ['slider', 'thumbnails', 'gallery', 'carousel', 'images', 'splide', 'acf', 'dynamic'];
    }

    // Enqueue element styles and scripts
    public function enqueue_scripts() {
        wp_enqueue_script('bricks-splide');
        wp_enqueue_style('bricks-splide');
        
        // Add version timestamp to force reload and prevent caching issues
        $version = '1.0.0-' . time();
        wp_enqueue_style('rony-dynamic-thumbnails-slider-style', plugins_url('assets/css/dynamic-thumbnails-slider.css', __FILE__), ['bricks-splide'], $version);
        wp_enqueue_script('ronyDynamicThumbnailsSlider', plugins_url('assets/js/dynamic-thumbnails-slider.js', __FILE__), ['bricks-splide', 'jquery'], $version, true);
    }

    // Helper function to render arrow icon
    private function get_arrow_icon($icon_settings, $default_icon) {
        if (empty($icon_settings)) {
            // Use SVG files as fallback instead of default icon class
            $is_prev = strpos($default_icon, 'back') !== false || strpos($default_icon, 'left') !== false;
            $svg_file = $is_prev ? 'arrow-left.svg' : 'arrow-right.svg';
            $svg_path = plugins_url('assets/images/' . $svg_file, __FILE__);
            return '<span class="arrow-svg-icon"><img src="' . esc_url($svg_path) . '" alt="Arrow"></span>';
        }
        
        return '<span>' . $this->render_icon($icon_settings, ['echo' => false]) . '</span>';
    }

    // Set builder control groups
    public function set_control_groups() {
        $this->control_groups['acf_field'] = [
            'title' => esc_html__('ACF Field', 'rony-bricks-builder-addons'),
            'tab' => 'content',
        ];

        $this->control_groups['main_slider'] = [
            'title' => esc_html__('Main Slider', 'rony-bricks-builder-addons'),
            'tab' => 'content',
        ];

        $this->control_groups['thumbnails'] = [
            'title' => esc_html__('Thumbnails', 'rony-bricks-builder-addons'),
            'tab' => 'content',
        ];
    }

    // Set builder controls
    public function set_controls() {
        // ACF Field Controls
        $this->controls['acfField'] = [
            'tab' => 'content',
            'group' => 'acf_field',
            'label' => esc_html__('Gallery Field / Dynamic Tag', 'rony-bricks-builder-addons'),
            'type' => 'text',
            'placeholder' => esc_html__('Enter field name or use dynamic tag', 'rony-bricks-builder-addons'),
            'description' => esc_html__('Enter an ACF gallery field name or use any dynamic tag that returns images. Supports ACF gallery fields, attachment IDs, image URLs, or a comma-separated list of URLs.', 'rony-bricks-builder-addons'),
            'hasDynamicData' => true,
        ];

        $this->controls['showTitle'] = [
            'tab' => 'content',
            'group' => 'acf_field',
            'label' => esc_html__('Show Image Title', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => true,
        ];

        $this->controls['showCaption'] = [
            'tab' => 'content',
            'group' => 'acf_field',
            'label' => esc_html__('Show Image Caption', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => true,
        ];

        // Main Slider Controls
        $this->controls['mainSliderType'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Slider Type', 'rony-bricks-builder-addons'),
            'type' => 'select',
            'options' => [
                'fade' => esc_html__('Fade', 'rony-bricks-builder-addons'),
                'slide' => esc_html__('Slide', 'rony-bricks-builder-addons'),
                'loop' => esc_html__('Loop', 'rony-bricks-builder-addons'),
            ],
            'default' => 'fade',
        ];

        $this->controls['mainSliderArrows'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Show Arrows', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => true,
        ];

        $this->controls['mainSliderPagination'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Show Pagination', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => false,
        ];

        $this->controls['mainSliderAutoplay'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Autoplay', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => false,
        ];

        $this->controls['mainSliderAutoplayInterval'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Autoplay Interval (ms)', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'default' => 5000,
            'required' => [['mainSliderAutoplay', '=', true]],
        ];

        $this->controls['mainSliderArrowsIcons'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Custom Arrow Icons', 'rony-bricks-builder-addons'),
            'type' => 'separator',
            'required' => [['mainSliderArrows', '=', true]],
        ];

        $this->controls['mainSliderPrevArrowIcon'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Previous Arrow Icon', 'rony-bricks-builder-addons'),
            'type' => 'icon',
            'default' => [
                'library' => 'ionicons',
                'icon' => 'ion-chevron-left',
            ],
            'required' => [['mainSliderArrows', '=', true]],
        ];

        $this->controls['mainSliderNextArrowIcon'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Next Arrow Icon', 'rony-bricks-builder-addons'),
            'type' => 'icon',
            'default' => [
                'library' => 'ionicons',
                'icon' => 'ion-chevron-right',
            ],
            'required' => [['mainSliderArrows', '=', true]],
        ];

        // Arrow Color Settings
        $this->controls['mainSliderArrowColors'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Arrow Colors', 'rony-bricks-builder-addons'),
            'type' => 'separator',
            'required' => [['mainSliderArrows', '=', true]],
        ];
        
        $this->controls['mainSliderArrowBgColor'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Arrow Background', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background',
                    'selector' => '.rony-main-slider .splide__arrow',
                ],
            ],
            'default' => 'rgba(0, 0, 0, 0.6)',
            'required' => [['mainSliderArrows', '=', true]],
        ];
        
        $this->controls['mainSliderArrowBgHoverColor'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Arrow Background Hover', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background',
                    'selector' => '.rony-main-slider .splide__arrow:hover',
                ],
            ],
            'default' => 'rgba(0, 0, 0, 0.8)',
            'required' => [['mainSliderArrows', '=', true]],
        ];
        
        $this->controls['mainSliderArrowIconColor'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Arrow Icon Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.rony-main-slider .splide__arrow span',
                ],
                [
                    'property' => 'filter',
                    'selector' => '.rony-main-slider .splide__arrow span.arrow-svg-icon img',
                    'value' => 'brightness(0) invert(1)',
                ],
            ],
            'default' => '#ffffff',
            'required' => [['mainSliderArrows', '=', true]],
        ];

        $this->controls['mainSliderHeight'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Height', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'units' => true,
            'css' => [
                [
                    'property' => 'height',
                    'selector' => '.main-slider .splide__slide',
                ],
            ],
            'default' => '400px',
        ];

        $this->controls['mainSliderObjectFit'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Object Fit', 'rony-bricks-builder-addons'),
            'type' => 'select',
            'options' => [
                'cover' => esc_html__('Cover', 'rony-bricks-builder-addons'),
                'contain' => esc_html__('Contain', 'rony-bricks-builder-addons'),
                'fill' => esc_html__('Fill', 'rony-bricks-builder-addons'),
                'none' => esc_html__('None', 'rony-bricks-builder-addons'),
            ],
            'default' => 'cover',
            'css' => [
                [
                    'property' => 'object-fit',
                    'selector' => '.main-slider img',
                ],
            ],
        ];

        // Content Overlay
        $this->controls['showContentOverlay'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Show Content Overlay', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => true,
        ];

        $this->controls['overlayBackground'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Overlay Background', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background-color',
                    'selector' => '.slide-content',
                ],
            ],
            'default' => 'rgba(0, 0, 0, 0.3)',
            'required' => [['showContentOverlay', '=', true]],
        ];

        $this->controls['contentPosition'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Content Position', 'rony-bricks-builder-addons'),
            'type' => 'select',
            'options' => [
                'top-left' => esc_html__('Top Left', 'rony-bricks-builder-addons'),
                'top-center' => esc_html__('Top Center', 'rony-bricks-builder-addons'),
                'top-right' => esc_html__('Top Right', 'rony-bricks-builder-addons'),
                'center-left' => esc_html__('Center Left', 'rony-bricks-builder-addons'),
                'center' => esc_html__('Center', 'rony-bricks-builder-addons'),
                'center-right' => esc_html__('Center Right', 'rony-bricks-builder-addons'),
                'bottom-left' => esc_html__('Bottom Left', 'rony-bricks-builder-addons'),
                'bottom-center' => esc_html__('Bottom Center', 'rony-bricks-builder-addons'),
                'bottom-right' => esc_html__('Bottom Right', 'rony-bricks-builder-addons'),
            ],
            'default' => 'bottom-left',
            'required' => [['showContentOverlay', '=', true]],
        ];

        $this->controls['contentPadding'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Content Padding', 'rony-bricks-builder-addons'),
            'type' => 'dimensions',
            'css' => [
                [
                    'property' => 'padding',
                    'selector' => '.slide-content',
                ],
            ],
            'default' => [
                'top' => '20px',
                'right' => '20px',
                'bottom' => '20px',
                'left' => '20px',
            ],
            'required' => [['showContentOverlay', '=', true]],
        ];

        $this->controls['titleColor'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Title Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.slide-title',
                ],
            ],
            'default' => '#ffffff',
            'required' => [['showContentOverlay', '=', true]],
        ];

        $this->controls['descriptionColor'] = [
            'tab' => 'content',
            'group' => 'main_slider',
            'label' => esc_html__('Description Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.slide-description',
                ],
            ],
            'default' => '#ffffff',
            'required' => [['showContentOverlay', '=', true]],
        ];

        // Thumbnails Slider Controls
        $this->controls['thumbnailsPerPage'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Visible Thumbnails', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'min' => 1,
            'max' => 10,
            'default' => 5,
        ];

        $this->controls['thumbnailsSpacing'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Thumbnails Spacing', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'default' => 10,
        ];

        $this->controls['thumbnailsWidth'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Thumbnail Width', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'default' => 100,
        ];

        $this->controls['thumbnailsHeight'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Thumbnail Height', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'default' => 60,
        ];

        $this->controls['thumbnailsGap'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Thumbnails Gap', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'default' => 10,
        ];

        $this->controls['thumbnailsArrows'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Show Arrows', 'rony-bricks-builder-addons'),
            'type' => 'checkbox',
            'default' => true,
        ];

        $this->controls['thumbnailsArrowsIcons'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Custom Arrow Icons', 'rony-bricks-builder-addons'),
            'type' => 'separator',
            'required' => [['thumbnailsArrows', '=', true]],
        ];

        $this->controls['thumbnailsPrevArrowIcon'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Previous Arrow Icon', 'rony-bricks-builder-addons'),
            'type' => 'icon',
            'default' => [
                'library' => 'ionicons',
                'icon' => 'ion-chevron-left',
            ],
            'required' => [['thumbnailsArrows', '=', true]],
        ];

        $this->controls['thumbnailsNextArrowIcon'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Next Arrow Icon', 'rony-bricks-builder-addons'),
            'type' => 'icon',
            'default' => [
                'library' => 'ionicons',
                'icon' => 'ion-chevron-right',
            ],
            'required' => [['thumbnailsArrows', '=', true]],
        ];

        // Thumbnail Arrow Color Settings
        $this->controls['thumbnailsArrowColors'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Arrow Colors', 'rony-bricks-builder-addons'),
            'type' => 'separator',
            'required' => [['thumbnailsArrows', '=', true]],
        ];
        
        $this->controls['thumbnailsArrowBgColor'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Arrow Background', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background',
                    'selector' => '.rony-thumbnail-slider .splide__arrow',
                ],
            ],
            'default' => 'rgba(0, 0, 0, 0.6)',
            'required' => [['thumbnailsArrows', '=', true]],
        ];
        
        $this->controls['thumbnailsArrowBgHoverColor'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Arrow Background Hover', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background',
                    'selector' => '.rony-thumbnail-slider .splide__arrow:hover',
                ],
            ],
            'default' => 'rgba(0, 0, 0, 0.8)',
            'required' => [['thumbnailsArrows', '=', true]],
        ];
        
        $this->controls['thumbnailsArrowIconColor'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Arrow Icon Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.rony-thumbnail-slider .splide__arrow span',
                ],
                [
                    'property' => 'filter',
                    'selector' => '.rony-thumbnail-slider .splide__arrow span.arrow-svg-icon img',
                    'value' => 'brightness(0) invert(1)',
                ],
            ],
            'default' => '#ffffff',
            'required' => [['thumbnailsArrows', '=', true]],
        ];

        $this->controls['thumbnailsPosition'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Thumbnails Position', 'rony-bricks-builder-addons'),
            'type' => 'select',
            'options' => [
                'bottom' => esc_html__('Bottom', 'rony-bricks-builder-addons'),
                'left' => esc_html__('Left', 'rony-bricks-builder-addons'),
                'right' => esc_html__('Right', 'rony-bricks-builder-addons'),
            ],
            'default' => 'bottom',
        ];

        $this->controls['verticalThumbnailsWidth'] = [
            'tab' => 'content',
            'group' => 'thumbnails',
            'label' => esc_html__('Vertical Thumbnails Width', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'default' => 120,
            'min' => 60,
            'max' => 300,
            'description' => esc_html__('Width of the thumbnails container when positioned left or right', 'rony-bricks-builder-addons'),
            'required' => [[
                'thumbnailsPosition', 
                'in', 
                ['left', 'right']
            ]],
        ];

        $this->controls['thumbnailsPadding'] = [
            'tab' => 'style',
            'label' => esc_html__('Thumbnails Padding', 'rony-bricks-builder-addons'),
            'type' => 'dimensions',
            'css' => [
                [
                    'property' => 'padding',
                    'selector' => '.thumbnail-slider',
                ],
            ],
            'default' => [
                'top' => '10px',
                'right' => '0',
                'bottom' => '0',
                'left' => '0',
            ],
        ];

        $this->controls['thumbnailsBorder'] = [
            'tab' => 'style',
            'label' => esc_html__('Thumbnail Border', 'rony-bricks-builder-addons'),
            'type' => 'border',
            'css' => [
                [
                    'property' => 'border',
                    'selector' => '.thumbnail-slider .splide__slide',
                ],
            ],
        ];

        $this->controls['thumbnailsActiveBorder'] = [
            'tab' => 'style',
            'label' => esc_html__('Thumbnail Active Border', 'rony-bricks-builder-addons'),
            'type' => 'border',
            'css' => [
                [
                    'property' => 'border',
                    'selector' => '.thumbnail-slider .splide__slide.is-active',
                ],
            ],
            'default' => [
                'width' => '2px',
                'style' => 'solid',
                'color' => [
                    'hex' => '#007bff',
                ],
            ],
        ];
    }

    // Render element HTML
    public function render() {
        $root_classes[] = 'rony-dynamic-thumbnails-slider-wrapper';
        $settings = $this->settings;
        
        // Debug output for settings
        if (current_user_can('administrator')) {
            echo '<!-- Debug: Element Settings: ' . print_r($settings, true) . ' -->';
        }
        
        // Get ACF gallery field value
        $acf_field = !empty($settings['acfField']) ? $settings['acfField'] : '';
        
        // Debug output for field name
        if (current_user_can('administrator')) {
            echo '<!-- Debug: Field Name or Dynamic Tag: ' . esc_html($acf_field) . ' -->';
        }
        
        // Check for dynamic tag or direct ACF field and process accordingly
        $gallery_images = [];
        
        // If using ACF but it's not active, show warning and check for dynamic tag anyway
        if (!function_exists('get_field') && strpos($acf_field, '{') === false) {
            if (current_user_can('administrator')) {
                echo '<div class="rony-dynamic-thumbnails-slider-error">Advanced Custom Fields (ACF) is not active, but required for direct field names. Please use dynamic tags or activate ACF.</div>';
            }
            return;
        }
        
        // Try to get the field value - handling both direct field names and dynamic data
        if (strpos($acf_field, '{') !== false) {
            $dynamic_field = \Bricks\Integrations\Dynamic_Data\Providers::render_dynamic_data($acf_field);
            
            // Debug dynamic field data
            if (current_user_can('administrator')) {
                echo '<!-- Debug: Dynamic Field Data Type: ' . gettype($dynamic_field) . ' -->';
                echo '<!-- Debug: Dynamic Field Data: ' . print_r($dynamic_field, true) . ' -->';
            }
            
            // Handle dynamic data value based on the result type
            if (is_string($dynamic_field)) {
                // Try to decode if it's JSON string
                $decoded = json_decode($dynamic_field, true);
                if (is_array($decoded)) {
                    $gallery_images = $decoded;
                }
                // If not JSON, check if it's a field name
                else if (!empty($dynamic_field)) {
                    $possible_field_value = get_field($dynamic_field);
                    if (!empty($possible_field_value) && is_array($possible_field_value)) {
                        $gallery_images = $possible_field_value;
                    } else {
                        // It might be a comma-separated list of image URLs
                        $gallery_images = array_map('trim', explode(',', $dynamic_field));
                    }
                }
            } 
            else if (is_array($dynamic_field)) {
                // It's already an array, use it directly
                $gallery_images = $dynamic_field;
                
                // Special handling for Bricks ACF gallery dynamic tag
                // This typically returns an array of attachment IDs
                if (count($gallery_images) > 0 && is_numeric($gallery_images[0])) {
                    // These are likely attachment IDs, keep them as they are
                    // The rendering code will handle attachment IDs
                }
            }
            else if (is_numeric($dynamic_field)) {
                // Single attachment ID
                $gallery_images = [$dynamic_field];
            }
            else if (is_object($dynamic_field)) {
                // Convert object to array
                $gallery_images = [$dynamic_field];
            }
        } 
        // Handle direct ACF field name
        else {
            $gallery_images = get_field($acf_field);
            
            // If we got a single image instead of an array, convert it to array
            if (!is_array($gallery_images) && !empty($gallery_images)) {
                $gallery_images = [$gallery_images];
            }
        }
        
        // If we received a comma-separated string, handle it
        if (is_string($gallery_images) && !empty($gallery_images)) {
            $gallery_images = array_map('trim', explode(',', $gallery_images));
        }
        
        // Ensure we always have an array even if empty
        if (!is_array($gallery_images)) {
            $gallery_images = [];
        }
        
        // Debug output for gallery images
        if (current_user_can('administrator')) {
            echo '<!-- Debug: Gallery Images: ' . print_r($gallery_images, true) . ' -->';
        }
        
        if (empty($gallery_images)) {
            if (current_user_can('administrator')) {
                echo '<div class="rony-dynamic-thumbnails-slider-error">No gallery images found for field "' . esc_html($acf_field) . '". Please check your ACF field name or dynamic tag.</div>';
            }
            return;
        }

        // Root element classes
        $this->set_attribute('_root', 'class', $root_classes);

        // Main slider attributes
        $slider_type = !empty($settings['mainSliderType']) ? $settings['mainSliderType'] : 'fade';
        $show_arrows = !empty($settings['mainSliderArrows']) ? true : false;
        $show_pagination = !empty($settings['mainSliderPagination']) ? true : false;
        $autoplay = !empty($settings['mainSliderAutoplay']) ? true : false;
        $autoplay_interval = !empty($settings['mainSliderAutoplayInterval']) ? (int)$settings['mainSliderAutoplayInterval'] : 5000;
        
        // Thumbnails slider attributes
        $thumbnails_per_page = !empty($settings['thumbnailsPerPage']) ? (int)$settings['thumbnailsPerPage'] : 5;
        $thumbnails_spacing = !empty($settings['thumbnailsSpacing']) ? (int)$settings['thumbnailsSpacing'] : 10;
        $thumbnails_width = !empty($settings['thumbnailsWidth']) ? (int)$settings['thumbnailsWidth'] : 100;
        $thumbnails_height = !empty($settings['thumbnailsHeight']) ? (int)$settings['thumbnailsHeight'] : 60;
        $thumbnails_gap = !empty($settings['thumbnailsGap']) ? (int)$settings['thumbnailsGap'] : 10;
        $thumbnails_arrows = isset($settings['thumbnailsArrows']) ? (bool)$settings['thumbnailsArrows'] : false;
        $thumbnails_position = !empty($settings['thumbnailsPosition']) ? $settings['thumbnailsPosition'] : 'bottom';
        $vertical_thumbnails_width = !empty($settings['verticalThumbnailsWidth']) ? (int)$settings['verticalThumbnailsWidth'] : 120;
        
        // Arrow icon settings
        $main_prev_arrow_icon = $this->get_arrow_icon($settings['mainSliderPrevArrowIcon'], 'ion-ios-arrow-back');
        $main_next_arrow_icon = $this->get_arrow_icon($settings['mainSliderNextArrowIcon'], 'ion-ios-arrow-forward');
        $thumbnails_prev_arrow_icon = $this->get_arrow_icon($settings['thumbnailsPrevArrowIcon'], 'ion-ios-arrow-back');
        $thumbnails_next_arrow_icon = $this->get_arrow_icon($settings['thumbnailsNextArrowIcon'], 'ion-ios-arrow-forward');
        
        // Content overlay settings
        $show_content_overlay = !empty($settings['showContentOverlay']) ? true : false;
        $content_position = !empty($settings['contentPosition']) ? $settings['contentPosition'] : 'bottom-left';
        $show_title = !empty($settings['showTitle']) ? true : false;
        $show_caption = !empty($settings['showCaption']) ? true : false;

        // Store slider data as a data attribute
        $this->set_attribute('_root', 'data-slider-type', $slider_type);
        $this->set_attribute('_root', 'data-show-arrows', $show_arrows ? 'true' : 'false');
        $this->set_attribute('_root', 'data-show-pagination', $show_pagination ? 'true' : 'false');
        $this->set_attribute('_root', 'data-autoplay', $autoplay ? 'true' : 'false');
        $this->set_attribute('_root', 'data-autoplay-interval', $autoplay_interval);
        $this->set_attribute('_root', 'data-thumbnails-per-page', $thumbnails_per_page);
        $this->set_attribute('_root', 'data-thumbnails-spacing', $thumbnails_spacing);
        $this->set_attribute('_root', 'data-thumbnails-width', $thumbnails_width);
        $this->set_attribute('_root', 'data-thumbnails-height', $thumbnails_height);
        $this->set_attribute('_root', 'data-thumbnails-gap', $thumbnails_gap);
        $this->set_attribute('_root', 'data-thumbnails-arrows', $thumbnails_arrows ? 'true' : 'false');
        $this->set_attribute('_root', 'data-thumbnails-position', $thumbnails_position);
        $this->set_attribute('_root', 'data-vertical-thumbnails-width', $vertical_thumbnails_width);
        $this->set_attribute('_root', 'class', 'thumbnails-position-' . $thumbnails_position);
        
        // Add additional debug for JavaScript
        $this->set_attribute('_root', 'data-debug', true);

        // Render element
        echo "<div {$this->render_attributes( '_root' )}>";

        // Determine the order to render sliders based on position
        if ($thumbnails_position === 'left') {
            // For left position, render thumbnails first, then main slider
            // Thumbnails slider
            echo '<div id="thumbnail-slider" class="splide thumbnail-slider rony-thumbnail-slider">';
            
            // Custom thumbnails arrows
            if ($thumbnails_arrows) {
                echo '<div class="splide__arrows">';
                echo '<button class="splide__arrow splide__arrow--prev">' . $thumbnails_prev_arrow_icon . '</button>';
                echo '<button class="splide__arrow splide__arrow--next">' . $thumbnails_next_arrow_icon . '</button>';
                echo '</div>';
            }
            
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            // First thumbnail section (for left position)
            foreach ($gallery_images as $image) {
                echo '<li class="splide__slide">';
                
                // Different formats handling for thumbnails
                if (is_array($image) && isset($image['sizes']) && isset($image['sizes']['thumbnail'])) {
                    // Standard ACF gallery format
                    $thumbnail_url = esc_url($image['sizes']['thumbnail']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                } elseif (is_array($image) && isset($image['thumbnail'])) {
                    // Custom format with thumbnail key
                    $thumbnail_url = esc_url($image['thumbnail']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                } elseif (is_array($image) && isset($image['url'])) {
                    // Format with just URL
                    $thumbnail_url = esc_url($image['url']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                } elseif (is_numeric($image)) {
                    // Attachment ID
                    $thumbnail_data = wp_get_attachment_image_src($image, 'thumbnail');
                    $thumbnail_url = $thumbnail_data ? esc_url($thumbnail_data[0]) : '';
                    $alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);
                } elseif (is_string($image)) {
                    // Direct URL
                    $thumbnail_url = esc_url($image);
                    $alt_text = '';
                } else {
                    // Fallback
                    $thumbnail_url = '';
                    $alt_text = '';
                }
                
                echo '<img src="' . $thumbnail_url . '" alt="' . $alt_text . '">';
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</div>';
            
            // Main slider
            echo '<div id="main-slider" class="splide main-slider rony-main-slider">';
            
            // Custom main slider arrows
            if ($show_arrows) {
                echo '<div class="splide__arrows">';
                echo '<button class="splide__arrow splide__arrow--prev">' . $main_prev_arrow_icon . '</button>';
                echo '<button class="splide__arrow splide__arrow--next">' . $main_next_arrow_icon . '</button>';
                echo '</div>';
            }
            
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            foreach ($gallery_images as $image) {
                echo '<li class="splide__slide">';
                
                // Different formats handling for main image
                if (is_array($image) && isset($image['url'])) {
                    // Standard ACF gallery format
                    $image_url = esc_url($image['url']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                    $title = isset($image['title']) ? esc_html($image['title']) : '';
                    $caption = isset($image['caption']) ? wp_kses_post($image['caption']) : '';
                } elseif (is_numeric($image)) {
                    // Attachment ID
                    $image_url = wp_get_attachment_url($image);
                    $alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);
                    $attachment = get_post($image);
                    $title = $attachment ? esc_html($attachment->post_title) : '';
                    $caption = $attachment ? wp_kses_post($attachment->post_excerpt) : '';
                } elseif (is_string($image)) {
                    // Direct URL
                    $image_url = esc_url($image);
                    $alt_text = '';
                    $title = '';
                    $caption = '';
                } elseif (is_object($image) && isset($image->url)) {
                    // Object with URL property
                    $image_url = esc_url($image->url);
                    $alt_text = isset($image->alt) ? esc_attr($image->alt) : '';
                    $title = isset($image->title) ? esc_html($image->title) : '';
                    $caption = isset($image->caption) ? wp_kses_post($image->caption) : '';
                } else {
                    // Fallback
                    $image_url = '';
                    $alt_text = '';
                    $title = '';
                    $caption = '';
                }
                
                echo '<img src="' . $image_url . '" alt="' . $alt_text . '">';
                
                // Slide content overlay
                if ($show_content_overlay && ($show_title || $show_caption) && (!empty($title) || !empty($caption))) {
                    echo '<div class="slide-content position-' . esc_attr($content_position) . '">';
                    
                    if ($show_title && !empty($title)) {
                        echo '<h3 class="slide-title">' . $title . '</h3>';
                    }
                    
                    if ($show_caption && !empty($caption)) {
                        echo '<div class="slide-description">' . $caption . '</div>';
                    }
                    
                    echo '</div>';
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        } else {
            // For bottom or right position, render main slider first, then thumbnails
            // Main slider
            echo '<div id="main-slider" class="splide main-slider rony-main-slider">';
            
            // Custom main slider arrows
            if ($show_arrows) {
                echo '<div class="splide__arrows">';
                echo '<button class="splide__arrow splide__arrow--prev">' . $main_prev_arrow_icon . '</button>';
                echo '<button class="splide__arrow splide__arrow--next">' . $main_next_arrow_icon . '</button>';
                echo '</div>';
            }
            
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            foreach ($gallery_images as $image) {
                echo '<li class="splide__slide">';
                
                // Different formats handling for main image
                if (is_array($image) && isset($image['url'])) {
                    // Standard ACF gallery format
                    $image_url = esc_url($image['url']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                    $title = isset($image['title']) ? esc_html($image['title']) : '';
                    $caption = isset($image['caption']) ? wp_kses_post($image['caption']) : '';
                } elseif (is_numeric($image)) {
                    // Attachment ID
                    $image_url = wp_get_attachment_url($image);
                    $alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);
                    $attachment = get_post($image);
                    $title = $attachment ? esc_html($attachment->post_title) : '';
                    $caption = $attachment ? wp_kses_post($attachment->post_excerpt) : '';
                } elseif (is_string($image)) {
                    // Direct URL
                    $image_url = esc_url($image);
                    $alt_text = '';
                    $title = '';
                    $caption = '';
                } elseif (is_object($image) && isset($image->url)) {
                    // Object with URL property
                    $image_url = esc_url($image->url);
                    $alt_text = isset($image->alt) ? esc_attr($image->alt) : '';
                    $title = isset($image->title) ? esc_html($image->title) : '';
                    $caption = isset($image->caption) ? wp_kses_post($image->caption) : '';
                } else {
                    // Fallback
                    $image_url = '';
                    $alt_text = '';
                    $title = '';
                    $caption = '';
                }
                
                echo '<img src="' . $image_url . '" alt="' . $alt_text . '">';
                
                // Slide content overlay
                if ($show_content_overlay && ($show_title || $show_caption) && (!empty($title) || !empty($caption))) {
                    echo '<div class="slide-content position-' . esc_attr($content_position) . '">';
                    
                    if ($show_title && !empty($title)) {
                        echo '<h3 class="slide-title">' . $title . '</h3>';
                    }
                    
                    if ($show_caption && !empty($caption)) {
                        echo '<div class="slide-description">' . $caption . '</div>';
                    }
                    
                    echo '</div>';
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</div>';
            
            // Thumbnails slider
            echo '<div id="thumbnail-slider" class="splide thumbnail-slider rony-thumbnail-slider">';
            
            // Custom thumbnails arrows
            if ($thumbnails_arrows) {
                echo '<div class="splide__arrows">';
                echo '<button class="splide__arrow splide__arrow--prev">' . $thumbnails_prev_arrow_icon . '</button>';
                echo '<button class="splide__arrow splide__arrow--next">' . $thumbnails_next_arrow_icon . '</button>';
                echo '</div>';
            }
            
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            // Second thumbnail section (for bottom position)
            foreach ($gallery_images as $image) {
                echo '<li class="splide__slide">';
                
                // Different formats handling for thumbnails
                if (is_array($image) && isset($image['sizes']) && isset($image['sizes']['thumbnail'])) {
                    // Standard ACF gallery format
                    $thumbnail_url = esc_url($image['sizes']['thumbnail']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                } elseif (is_array($image) && isset($image['thumbnail'])) {
                    // Custom format with thumbnail key
                    $thumbnail_url = esc_url($image['thumbnail']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                } elseif (is_array($image) && isset($image['url'])) {
                    // Format with just URL
                    $thumbnail_url = esc_url($image['url']);
                    $alt_text = isset($image['alt']) ? esc_attr($image['alt']) : '';
                } elseif (is_numeric($image)) {
                    // Attachment ID
                    $thumbnail_data = wp_get_attachment_image_src($image, 'thumbnail');
                    $thumbnail_url = $thumbnail_data ? esc_url($thumbnail_data[0]) : '';
                    $alt_text = get_post_meta($image, '_wp_attachment_image_alt', true);
                } elseif (is_string($image)) {
                    // Direct URL
                    $thumbnail_url = esc_url($image);
                    $alt_text = '';
                } else {
                    // Fallback
                    $thumbnail_url = '';
                    $alt_text = '';
                }
                
                echo '<img src="' . $thumbnail_url . '" alt="' . $alt_text . '">';
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; // Close root element
    }
} 