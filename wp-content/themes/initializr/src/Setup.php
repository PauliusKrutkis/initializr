<?php

namespace App;


class Setup
{
    private $styles;
    private $scripts;
    private $localize;
    private $widgetAreas;
    private $logo;
    private $excerpt;
    private $imageSizes;
    private $navMenus;
    private $postTypes;
    private $taxonomies;
    private $shortcodes;
    private $shortcodeDir;
    private $helper;
    private $config;

    function __construct()
    {
        $this->helper = new Helper();
        $this->config = new Config();

        $this->config->load();

        $this->styles       = $this->config->get('enqueue')['styles'];
        $this->scripts      = $this->config->get('enqueue')['scripts'];
        $this->localize     = $this->config->get('enqueue')['localize'];
        $this->widgetAreas  = $this->config->get('general')['widget-areas'];
        $this->imageSizes   = $this->config->get('image-sizes');
        $this->logo         = $this->config->get('general')['logo'];
        $this->excerpt      = $this->config->get('general')['excerpt'];
        $this->navMenus     = $this->config->get('general')['nav-menus'];
        $this->postTypes    = $this->config->get('post-types');
        $this->taxonomies   = $this->config->get('taxonomies');
        $this->shortcodes   = $this->config->get('shortcodes');
        $this->shortcodeDir = $this->config->get('general')['shortcode-dir'];

        $this->addActions();
        $this->addImageSizes();

        new Shortcodes();
    }

    public function addAssets()
    {
        $styles   = apply_filters('theme_styles', $this->styles);
        $scripts  = apply_filters('theme_scripts', $this->scripts);
        $localize = apply_filters('theme_localize', $this->localize);

        foreach ($styles as $name => $options) {
            $defaults = [
                'src' => null,
            ];

            $options = wp_parse_args($options, $defaults);

            wp_enqueue_style($name, $options['src']);
        }

        foreach ($scripts as $name => $options) {
            $defaults = [
                'src'       => null,
                'deps'      => null,
                'ver'       => null,
                'in-footer' => true
            ];

            $options = wp_parse_args($options, $defaults);

            wp_enqueue_script(
                $name,
                $options['src'],
                $options['deps'],
                $options['ver'],
                $options['in-footer']
            );
        }

        foreach ($localize as $name => $options) {
            wp_localize_script(
                $name,
                $options['prefix'],
                $options['strings']
            );
        }
    }

    public function changeExcerptEnd()
    {
        return $this->excerpt;
    }

    public function themeSetup()
    {
        load_theme_textdomain('initializr', get_template_directory() . '/languages');

        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        add_theme_support(
            'custom-logo',
            ['width' => $this->logo['width'], 'height' => $this->logo['height']]
        );

        add_theme_support(
            'html5',
            ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']
        );

        // add excerpt field to page post type
        add_post_type_support('page', 'excerpt');

        $this->addNavMenus();
    }

    public function addWidgetAreas()
    {
        $i = 0;

        foreach ($this->widgetAreas as $area) {
            register_sidebar(
                [
                    'name'          => __(ucfirst($area), 'initializr'),
                    'id'            => 'widget-area-sidebar-' . $i,
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h3 class="widget-title">',
                    'after_title'   => '</h3>',
                ]
            );

            $i++;
        }
    }

    public function addPostTypes()
    {
        foreach ($this->postTypes as $name => $args) {

            $slug = (get_option($name . '_slug')) ? get_option($name . '_slug') : $name;

            $args['labels'] = [
                'name' => __(ucfirst($name), 'initializr'),
            ];

            if (isset($args['no-single']) && $args['no-single']) {
                $args['exclude_from_search'] = true;
            }

            $args['rewrite'] = ['slug' => $slug];

            register_post_type($name, $args);
        }
    }

    public function addSlugOptions()
    {
        if (function_exists('icl_object_id')) {
            return;
        }

        foreach ($this->postTypes as $name => $args) {
            if (isset($_POST[$name . '_slug'])) {
                update_option($name . '_slug', sanitize_title_with_dashes($_POST[$name . '_slug']));
            }

            if (isset($args['no-single']) && $args['no-single']) {
                continue;
            }

            add_settings_field(
                $name . '_slug',
                __(ucfirst($name) . ' slug', 'initializr'),
                function () use ($name) {
                    $value = get_option($name . '_slug');
                    echo '
                        <input
                            type="text"
                            value="' . esc_attr($value) . '"
                            name="' . $name . '_slug"
                            id="' . $name . '_slug"
                            class="regular-text"/>';
                },
                'permalink',
                'optional'
            );
        }
    }

    public function addPostTypeRedirects()
    {
        foreach ($this->postTypes as $name => $args) {
            if ( ! isset($args['no-single'])) {
                continue;
            }

            if ( ! $args['no-single']) {
                continue;
            }

            if (is_single() && $name == get_query_var('post_type')) {
                wp_redirect(home_url(), 301);
                exit;
            }
        }
    }

    public function addVisualComposerSetup()
    {
        remove_action('admin_bar_menu', [vc_frontend_editor(), 'adminBarEditLink'], 1000);
        vc_disable_frontend();
        vc_remove_element("my_hello_world");
        vc_set_shortcodes_templates_dir(get_stylesheet_directory() . '/' . $this->shortcodeDir);
    }

    public function addTaxonomies()
    {
        foreach ($this->taxonomies as $name => $args) {

            if (isset($args['label'])) {
                $args['options']['label'] = __($args['label'], 'initializr');
            } else {
                $args['options']['label'] = ucfirst($name);
            }

            register_taxonomy(
                $name,
                $args['post-type'],
                $args['options']
            );
        }
    }

    private function addNavMenus()
    {
        $navMenus = array_reduce($this->navMenus, function ($result, $menu) {
            $result[$menu] = __(ucfirst($menu), 'initializr');

            return $result;
        }, []);

        register_nav_menus($navMenus);
    }

    private function addImageSizes()
    {
        foreach ($this->imageSizes as $name => $options) {
            add_image_size($name, $options['width'], $options['height'], $options['crop']);
        }
    }

    public function removeAdminBarInlineStyle()
    {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

    private function addActions()
    {
        add_action('get_header', [$this, 'removeAdminBarInlineStyle']);
        add_action('wp_enqueue_scripts', [$this, 'addAssets']);
        add_action('widgets_init', [$this, 'addWidgetAreas']);
        add_action('after_setup_theme', [$this, 'themeSetup']);
        add_filter('excerpt_more', [$this, 'changeExcerptEnd']);
        add_filter('init', [$this, 'addPostTypes']);
        add_filter('init', [$this, 'addTaxonomies']);
        add_action('load-options-permalink.php', [$this, 'addSlugOptions']);
        add_action('template_redirect', [$this, 'addPostTypeRedirects']);

        if (function_exists('vc_map')) {
            add_action('vc_after_init', [$this, 'addVisualComposerSetup']);
        }
    }
}
