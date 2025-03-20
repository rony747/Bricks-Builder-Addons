<?php
/**
 * Thumbnails Slider Element for Bricks Builder
 *
 * @package     Rony_Bricks_Builder_Addons
 * @author      t.i. rony
 * @since       1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Rony_Bricks_Builder_Thumbnails_Slider extends \Bricks\Element {
    // Element properties
    public $category = 'rony-addons';
    public $name = 'rony-thumbnails-slider';
    public $icon = 'ti-layout-slider-alt';
    public $css_selector = '.rony-thumbnails-slider-wrapper';
    public $scripts = ['ronyThumbnailsSlider'];
    public $nestable = false;

    // Return localized element label
    public function get_label() {
        return esc_html__('Thumbnails Slider', 'rony-bricks-builder-addons');
    }

    // Set keywords to search for this element
    public function get_keywords() {
        return ['slider', 'thumbnails', 'gallery', 'carousel', 'images', 'splide'];
    }

       // Enqueue element styles and scripts
       public function enqueue_scripts() {
		wp_enqueue_script( 'bricks-splide' );
		wp_enqueue_style( 'bricks-splide' );
        wp_enqueue_style('rony-thumbnails-slider-style', plugins_url('assets/css/thumbnails-slider.css', __FILE__), ['bricks-splide'], '1.0.0');
        wp_enqueue_script('ronyThumbnailsSlider', plugins_url('assets/js/thumbnails-slider.js', __FILE__), ['bricks-splide'], '1.0.0', true);
        wp_localize_script('ronyThumbnailsSlider', 'ronyThumbnailsSliderData', [
            'thumbnailsArrows' => $this->settings['thumbnailsArrows'] ?? true,
        ]);
 
    }
    // Set builder control groups
    public function set_control_groups() {
        $this->control_groups['slides'] = [
            'title' => esc_html__('Slides', 'rony-bricks-builder-addons'),
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
        // Slides Controls
        $this->controls['slides'] = [
            'tab' => 'content',
            'group' => 'slides',
            'label' => esc_html__('Slides', 'rony-bricks-builder-addons'),
            'type' => 'repeater',
            'titleProperty' => 'title',
            'fields' => [
                'image' => [
                    'label' => esc_html__('Image', 'rony-bricks-builder-addons'),
                    'type' => 'image',
                ],
                'title' => [
                    'label' => esc_html__('Title', 'rony-bricks-builder-addons'),
                    'type' => 'text',
                    'placeholder' => esc_html__('Slide title', 'rony-bricks-builder-addons'),
                ],
                'description' => [
                    'label' => esc_html__('Description', 'rony-bricks-builder-addons'),
                    'type' => 'textarea',
                    'placeholder' => esc_html__('Slide description', 'rony-bricks-builder-addons'),
                ],
            ],
            'default' => [
                [
                    'title' => esc_html__('Slide 1', 'rony-bricks-builder-addons'),
                ],
                [
                    'title' => esc_html__('Slide 2', 'rony-bricks-builder-addons'),
                ],
                [
                    'title' => esc_html__('Slide 3', 'rony-bricks-builder-addons'),
                ],
            ],
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
            'default' => false,
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
            'default' => false,
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
        $root_classes[] = 'rony-thumbnails-slider-wrapper';
        $settings = $this->settings;
        $slides = !empty($settings['slides']) ? $settings['slides'] : [];
        
        if (empty($slides)) {
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
        $main_prev_arrow_icon = !empty($settings['mainSliderPrevArrowIcon']) ? '<span>'.$this->render_icon($settings['mainSliderPrevArrowIcon'], ['echo' => false]).'</span>' : '<span><i class="ion-ios-arrow-back"></i></span>';

        $main_next_arrow_icon = !empty($settings['mainSliderNextArrowIcon']) ? '<span>'.$this->render_icon($settings['mainSliderNextArrowIcon'], ['echo' => false]).'</span>' : '<span><i class="ion-ios-arrow-forward"></i></span>';
        $thumbnails_prev_arrow_icon = !empty($settings['thumbnailsPrevArrowIcon']) ? '<span>'.$this->render_icon($settings['thumbnailsPrevArrowIcon'], ['echo' => false]).'</span>' : '<span><i class="ion-ios-arrow-back"></i></span>';
        $thumbnails_next_arrow_icon = !empty($settings['thumbnailsNextArrowIcon']) ? '<span>'.$this->render_icon($settings['thumbnailsNextArrowIcon'], ['echo' => false]).'</span>' : '<span><i class="ion-ios-arrow-forward"></i></span>';
        
        // Content overlay settings
        $show_content_overlay = !empty($settings['showContentOverlay']) ? true : false;
        $content_position = !empty($settings['contentPosition']) ? $settings['contentPosition'] : 'bottom-left';

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
        $this->set_attribute('_root', 'data-main-prev-arrow', htmlspecialchars($main_prev_arrow_icon, ENT_QUOTES, 'UTF-8'));
        $this->set_attribute('_root', 'data-main-next-arrow', htmlspecialchars($main_next_arrow_icon, ENT_QUOTES, 'UTF-8'));
        $this->set_attribute('_root', 'data-thumbnails-prev-arrow', htmlspecialchars($thumbnails_prev_arrow_icon, ENT_QUOTES, 'UTF-8'));
        $this->set_attribute('_root', 'data-thumbnails-next-arrow', htmlspecialchars($thumbnails_next_arrow_icon, ENT_QUOTES, 'UTF-8'));
        $this->set_attribute('_root', 'class', 'thumbnails-position-' . $thumbnails_position);

        // Render element
        echo "<div {$this->render_attributes( '_root' )}>";

        // Determine the order to render sliders based on position
        if ($thumbnails_position === 'left') {
            // For left position, render thumbnails first, then main slider
            // Thumbnails slider
            echo '<div id="thumbnail-slider" class="splide thumbnail-slider rony-thumbnail-slider">';
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            foreach ($slides as $slide) {
                echo '<li class="splide__slide">';
                
                if (!empty($slide['image'])) {
                    $image_url = $slide['image']['url'];
                    $image_alt = !empty($slide['title']) ? $slide['title'] : 'Thumbnail image';
                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
                } else {
                    // Placeholder
                    echo '<div class="placeholder-image"></div>';
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</div>';
            
            // Main slider
            echo '<div id="main-slider" class="splide main-slider rony-main-slider">';
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            foreach ($slides as $slide) {
                echo '<li class="splide__slide">';
                
                // Slide image
                if (!empty($slide['image'])) {
                    $image_url = $slide['image']['url'];
                    $image_alt = !empty($slide['title']) ? $slide['title'] : 'Slide image';
                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
                } else {
                    // Placeholder
                    echo '<div class="placeholder-image"></div>';
                }
                
                // Slide content overlay
                if ($show_content_overlay && (!empty($slide['title']) || !empty($slide['description']))) {
                    echo '<div class="slide-content position-' . esc_attr($content_position) . '">';
                    
                    if (!empty($slide['title'])) {
                        echo '<h3 class="slide-title">' . esc_html($slide['title']) . '</h3>';
                    }
                    
                    if (!empty($slide['description'])) {
                        echo '<div class="slide-description">' . wp_kses_post($slide['description']) . '</div>';
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
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            foreach ($slides as $slide) {
                echo '<li class="splide__slide">';
                
                // Slide image
                if (!empty($slide['image'])) {
                    $image_url = $slide['image']['url'];
                    $image_alt = !empty($slide['title']) ? $slide['title'] : 'Slide image';
                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
                } else {
                    // Placeholder
                    echo '<div class="placeholder-image"></div>';
                }
                
                // Slide content overlay
                if ($show_content_overlay && (!empty($slide['title']) || !empty($slide['description']))) {
                    echo '<div class="slide-content position-' . esc_attr($content_position) . '">';
                    
                    if (!empty($slide['title'])) {
                        echo '<h3 class="slide-title">' . esc_html($slide['title']) . '</h3>';
                    }
                    
                    if (!empty($slide['description'])) {
                        echo '<div class="slide-description">' . wp_kses_post($slide['description']) . '</div>';
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
            echo '<div class="splide__track">';
            echo '<ul class="splide__list">';
            
            foreach ($slides as $slide) {
                echo '<li class="splide__slide">';
                
                if (!empty($slide['image'])) {
                    $image_url = $slide['image']['url'];
                    $image_alt = !empty($slide['title']) ? $slide['title'] : 'Thumbnail image';
                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
                } else {
                    // Placeholder
                    echo '<div class="placeholder-image"></div>';
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; // Close root element
    }

 
} 