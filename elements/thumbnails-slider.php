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
        $settings = $this->settings;
        $slides = !empty($settings['slides']) ? $settings['slides'] : [];
        
        if (empty($slides)) {
            return;
        }

        // Root element classes
        $this->set_attribute('_root', 'class', 'rony-thumbnails-slider-wrapper');

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

        // Render element
        echo "<div {$this->render_attributes('_root')}>";

        // Main slider
        echo '<div id="main-slider" class="splide main-slider">';
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
        echo '<div id="thumbnail-slider" class="splide thumbnail-slider">';
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
        
        echo '</div>'; // Close root element
    }

    // Enqueue element styles and scripts
    public function enqueue_scripts() {
        // Splide CSS
        wp_enqueue_style(
            'splide', 
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css',
            [],
            '3.6.12'
        );

        // Splide JS
        wp_enqueue_script(
            'splide',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js',
            [],
            '3.6.12',
            true
        );

        // Custom CSS
        $css = '
            .rony-thumbnails-slider-wrapper {
                margin-bottom: 20px;
            }
            
            .rony-thumbnails-slider-wrapper .main-slider {
                margin-bottom: 10px;
            }
            
            .rony-thumbnails-slider-wrapper .splide__slide {
                position: relative;
                overflow: hidden;
            }
            
            .rony-thumbnails-slider-wrapper .main-slider img {
                width: 100%;
                height: 100%;
                display: block;
            }
            
            .rony-thumbnails-slider-wrapper .thumbnail-slider .splide__slide {
                opacity: 0.6;
                transition: opacity 0.3s ease;
                cursor: pointer;
            }
            
            .rony-thumbnails-slider-wrapper .thumbnail-slider .splide__slide.is-active {
                opacity: 1;
            }
            
            .rony-thumbnails-slider-wrapper .thumbnail-slider .splide__slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            
            .rony-thumbnails-slider-wrapper .placeholder-image {
                background-color: #f0f0f0;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 200px;
            }
            
            .rony-thumbnails-slider-wrapper .placeholder-image::after {
                content: "No Image";
                color: #888;
                font-size: 14px;
            }
            
            .rony-thumbnails-slider-wrapper .thumbnail-slider .placeholder-image {
                min-height: 60px;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content {
                position: absolute;
                color: #fff;
                z-index: 2;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-top-left {
                top: 0;
                left: 0;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-top-center {
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-top-right {
                top: 0;
                right: 0;
                text-align: right;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-center-left {
                top: 50%;
                left: 0;
                transform: translateY(-50%);
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-center {
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-center-right {
                top: 50%;
                right: 0;
                transform: translateY(-50%);
                text-align: right;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-bottom-left {
                bottom: 0;
                left: 0;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-bottom-center {
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
            }
            
            .rony-thumbnails-slider-wrapper .slide-content.position-bottom-right {
                bottom: 0;
                right: 0;
                text-align: right;
            }
            
            .rony-thumbnails-slider-wrapper .slide-title {
                margin-top: 0;
                margin-bottom: 8px;
            }
            
            .rony-thumbnails-slider-wrapper .slide-description {
                margin: 0;
            }
        ';

        wp_register_style('rony-thumbnails-slider', false);
        wp_enqueue_style('rony-thumbnails-slider');
        wp_add_inline_style('rony-thumbnails-slider', $css);

        // Custom JS
        $js = '
            document.addEventListener("DOMContentLoaded", function() {
                const thumbnailsSliders = document.querySelectorAll(".rony-thumbnails-slider-wrapper");
                
                if (thumbnailsSliders.length > 0) {
                    thumbnailsSliders.forEach(function(sliderWrapper, index) {
                        // Get slider settings from data attributes
                        const sliderType = sliderWrapper.dataset.sliderType || "fade";
                        const showArrows = sliderWrapper.dataset.showArrows === "true";
                        const showPagination = sliderWrapper.dataset.showPagination === "true";
                        const autoplay = sliderWrapper.dataset.autoplay === "true";
                        const autoplayInterval = parseInt(sliderWrapper.dataset.autoplayInterval) || 5000;
                        const thumbnailsPerPage = parseInt(sliderWrapper.dataset.thumbnailsPerPage) || 5;
                        const thumbnailsSpacing = parseInt(sliderWrapper.dataset.thumbnailsSpacing) || 10;
                        const thumbnailsWidth = parseInt(sliderWrapper.dataset.thumbnailsWidth) || 100;
                        const thumbnailsHeight = parseInt(sliderWrapper.dataset.thumbnailsHeight) || 60;
                        const thumbnailsGap = parseInt(sliderWrapper.dataset.thumbnailsGap) || 10;
                        
                        // Unique IDs for this slider instance
                        const mainSliderId = `main-slider-${index}`;
                        const thumbnailSliderId = `thumbnail-slider-${index}`;
                        
                        // Update IDs
                        sliderWrapper.querySelector(".main-slider").id = mainSliderId;
                        sliderWrapper.querySelector(".thumbnail-slider").id = thumbnailSliderId;
                        
                        // Initialize main slider
                        const mainSlider = new Splide(`#${mainSliderId}`, {
                            type: sliderType,
                            rewind: true,
                            pagination: showPagination,
                            arrows: showArrows,
                            autoplay: autoplay,
                            interval: autoplayInterval,
                        });
                        
                        // Initialize thumbnail slider
                        const thumbnailSlider = new Splide(`#${thumbnailSliderId}`, {
                            fixedWidth: thumbnailsWidth,
                            fixedHeight: thumbnailsHeight,
                            gap: thumbnailsGap,
                            rewind: true,
                            pagination: false,
                            arrows: true,
                            perPage: thumbnailsPerPage,
                            perMove: 1,
                            isNavigation: true,
                            cover: true,
                            breakpoints: {
                                768: {
                                    fixedWidth: Math.max(60, thumbnailsWidth * 0.75),
                                    fixedHeight: Math.max(40, thumbnailsHeight * 0.75),
                                },
                            },
                        });
                        
                        // Sync the sliders
                        mainSlider.sync(thumbnailSlider);
                        
                        // Mount the sliders
                        mainSlider.mount();
                        thumbnailSlider.mount();
                    });
                }
            });
        ';

        wp_add_inline_script('splide', $js);
    }
} 