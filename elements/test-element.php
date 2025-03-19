<?php
/**
 * Test Element for Bricks Builder
 *
 * @package     Rony_Bricks_Builder_Addons
 * @author      t.i. rony
 * @since       1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Rony_Bricks_Builder_Test_Element extends \Bricks\Element {
    // Element properties
    public $category = 'rony-addons';
    public $name = 'rony-test-element';
    public $icon = 'ti-bolt-alt';
    public $css_selector = '.rony-test-element-wrapper';
    public $scripts = [];
    public $nestable = false;

    // Return localized element label
    public function get_label() {
        return esc_html__('Test Element', 'rony-bricks-builder-addons');
    }

    // Set keywords to search for this element
    public function get_keywords() {
        return ['test', 'element', 'icon', 'rony', 'description', 'text'];
    }

    // Set builder control groups
    public function set_control_groups() {
        $this->control_groups['icon'] = [
            'title' => esc_html__('Icon', 'rony-bricks-builder-addons'),
            'tab' => 'content',
        ];

        $this->control_groups['content'] = [
            'title' => esc_html__('Content', 'rony-bricks-builder-addons'),
            'tab' => 'content',
        ];

        $this->control_groups['settings'] = [
            'title' => esc_html__('Settings', 'rony-bricks-builder-addons'),
            'tab' => 'content',
        ];
    }

    // Set builder controls
    public function set_controls() {
        // Icon Controls
        $this->controls['icon'] = [
            'tab' => 'content',
            'group' => 'icon',
            'label' => esc_html__('Icon', 'rony-bricks-builder-addons'),
            'type' => 'icon',
        ];

        $this->controls['iconSize'] = [
            'tab' => 'content',
            'group' => 'icon',
            'label' => esc_html__('Icon Size', 'rony-bricks-builder-addons'),
            'type' => 'number',
            'units' => true,
            'css' => [
                [
                    'property' => 'font-size',
                    'selector' => '.rony-test-element-icon',
                ],
            ],
            'default' => '24px',
        ];

        $this->controls['iconColor'] = [
            'tab' => 'content',
            'group' => 'icon',
            'label' => esc_html__('Icon Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.rony-test-element-icon',
                ],
            ],
        ];

        // Content Controls
        $this->controls['title'] = [
            'tab' => 'content',
            'group' => 'content',
            'label' => esc_html__('Title', 'rony-bricks-builder-addons'),
            'type' => 'text',
            'default' => esc_html__('Test Element Title', 'rony-bricks-builder-addons'),
        ];

        $this->controls['titleTag'] = [
            'tab' => 'content',
            'group' => 'content',
            'label' => esc_html__('Title HTML Tag', 'rony-bricks-builder-addons'),
            'type' => 'select',
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
            'default' => 'h3',
        ];

        $this->controls['content'] = [
            'tab' => 'content',
            'group' => 'content',
            'label' => esc_html__('Description', 'rony-bricks-builder-addons'),
            'type' => 'textarea',
            'default' => esc_html__('Add your test element description here. Edit the text as per your need.', 'rony-bricks-builder-addons'),
        ];

        // Style Controls
        $this->controls['titleColor'] = [
            'tab' => 'style',
            'label' => esc_html__('Title Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.rony-test-element-title',
                ],
            ],
        ];

        $this->controls['titleMargin'] = [
            'tab' => 'style',
            'label' => esc_html__('Title Margin', 'rony-bricks-builder-addons'),
            'type' => 'dimensions',
            'css' => [
                [
                    'property' => 'margin',
                    'selector' => '.rony-test-element-title',
                ],
            ],
        ];

        $this->controls['contentColor'] = [
            'tab' => 'style',
            'label' => esc_html__('Description Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'color',
                    'selector' => '.rony-test-element-description',
                ],
            ],
        ];

        $this->controls['backgroundColor'] = [
            'tab' => 'style',
            'label' => esc_html__('Background Color', 'rony-bricks-builder-addons'),
            'type' => 'color',
            'css' => [
                [
                    'property' => 'background-color',
                    'selector' => '',
                ],
            ],
        ];

        $this->controls['padding'] = [
            'tab' => 'style',
            'label' => esc_html__('Padding', 'rony-bricks-builder-addons'),
            'type' => 'dimensions',
            'css' => [
                [
                    'property' => 'padding',
                    'selector' => '',
                ],
            ],
            'default' => [
                'top' => '20px',
                'right' => '20px',
                'bottom' => '20px',
                'left' => '20px',
            ],
        ];

        $this->controls['borderRadius'] = [
            'tab' => 'style',
            'label' => esc_html__('Border Radius', 'rony-bricks-builder-addons'),
            'type' => 'dimensions',
            'css' => [
                [
                    'property' => 'border-radius',
                    'selector' => '',
                ],
            ],
        ];

        $this->controls['border'] = [
            'tab' => 'style',
            'label' => esc_html__('Border', 'rony-bricks-builder-addons'),
            'type' => 'border',
            'css' => [
                [
                    'property' => 'border',
                    'selector' => '',
                ],
            ],
        ];

        // Layout Settings
        $this->controls['layout'] = [
            'tab' => 'content',
            'group' => 'settings',
            'label' => esc_html__('Layout', 'rony-bricks-builder-addons'),
            'type' => 'select',
            'options' => [
                'top' => esc_html__('Icon Top', 'rony-bricks-builder-addons'),
                'left' => esc_html__('Icon Left', 'rony-bricks-builder-addons'),
                'right' => esc_html__('Icon Right', 'rony-bricks-builder-addons'),
            ],
            'default' => 'top',
        ];

        $this->controls['alignment'] = [
            'tab' => 'content',
            'group' => 'settings',
            'label' => esc_html__('Alignment', 'rony-bricks-builder-addons'),
            'type' => 'align-items',
            'exclude' => [
                'stretch',
            ],
            'inline' => true,
            'default' => 'center',
        ];
    }

    // Render element HTML
    public function render() {
        $settings = $this->settings;
        $layout = !empty($settings['layout']) ? $settings['layout'] : 'top';
        $alignment = !empty($settings['alignment']) ? $settings['alignment'] : 'center';
        $title_tag = !empty($settings['titleTag']) ? $settings['titleTag'] : 'h3';

        // Root classes
        $root_classes = ['rony-test-element-wrapper', 'layout-' . $layout, 'align-' . $alignment];
        $this->set_attribute('_root', 'class', $root_classes);

        echo "<div {$this->render_attributes('_root')}>";

        // Container for flexible layout
        echo '<div class="rony-test-element-container">';
        
        // Icon
        if (!empty($settings['icon'])) {
            echo '<div class="rony-test-element-icon">';
            echo self::render_icon($settings['icon']);
            echo '</div>';
        }

        // Content container
        echo '<div class="rony-test-element-content">';
        
        // Title
        if (!empty($settings['title'])) {
            echo "<{$title_tag} class=\"rony-test-element-title\">";
            echo $this->render_dynamic_data($settings['title']);
            echo "</{$title_tag}>";
        }
        
        // Description
        if (!empty($settings['content'])) {
            echo '<div class="rony-test-element-description">';
            echo $this->render_dynamic_data($settings['content']);
            echo '</div>';
        }
        
        echo '</div>'; // Close content container
        echo '</div>'; // Close flex container
        echo '</div>'; // Close root element
    }

    // Enqueue element styles
    public function enqueue_scripts() {
        $css = '
        .rony-test-element-wrapper {
            display: block;
            transition: all 0.3s ease;
        }
        .rony-test-element-wrapper .rony-test-element-container {
            display: flex;
        }
        .rony-test-element-wrapper.layout-top .rony-test-element-container {
            flex-direction: column;
        }
        .rony-test-element-wrapper.layout-left .rony-test-element-container {
            flex-direction: row;
        }
        .rony-test-element-wrapper.layout-right .rony-test-element-container {
            flex-direction: row-reverse;
        }
        .rony-test-element-wrapper.align-left {
            text-align: left;
        }
        .rony-test-element-wrapper.align-center {
            text-align: center;
        }
        .rony-test-element-wrapper.align-right {
            text-align: right;
        }
        .rony-test-element-wrapper.align-left.layout-top .rony-test-element-container,
        .rony-test-element-wrapper.align-center.layout-top .rony-test-element-container,
        .rony-test-element-wrapper.align-right.layout-top .rony-test-element-container {
            align-items: center;
        }
        .rony-test-element-wrapper.align-left.layout-top .rony-test-element-icon,
        .rony-test-element-wrapper.align-left.layout-top .rony-test-element-content {
            align-self: flex-start;
        }
        .rony-test-element-wrapper.align-center.layout-top .rony-test-element-icon,
        .rony-test-element-wrapper.align-center.layout-top .rony-test-element-content {
            align-self: center;
        }
        .rony-test-element-wrapper.align-right.layout-top .rony-test-element-icon,
        .rony-test-element-wrapper.align-right.layout-top .rony-test-element-content {
            align-self: flex-end;
        }
        .rony-test-element-wrapper .rony-test-element-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .rony-test-element-wrapper.layout-left .rony-test-element-icon,
        .rony-test-element-wrapper.layout-right .rony-test-element-icon {
            margin-bottom: 0;
            margin-right: 15px;
            margin-left: 15px;
        }
        .rony-test-element-wrapper.layout-left .rony-test-element-icon {
            margin-right: 15px;
            margin-left: 0;
        }
        .rony-test-element-wrapper.layout-right .rony-test-element-icon {
            margin-right: 0;
            margin-left: 15px;
        }
        .rony-test-element-wrapper .rony-test-element-title {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .rony-test-element-wrapper .rony-test-element-description {
            margin: 0;
        }
        ';

        wp_register_style('rony-test-element', false);
        wp_enqueue_style('rony-test-element');
        wp_add_inline_style('rony-test-element', $css);
    }
} 