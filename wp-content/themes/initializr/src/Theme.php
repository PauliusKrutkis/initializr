<?php


namespace App;


class Theme
{
    public function __construct()
    {
        $this->addOptionPage();
        add_action('rest_api_init', [$this, 'registerQueryRoute']);
    }

    public function registerQueryRoute()
    {
        $controller = new WP_REST_MultiplePostType_Controller();
        $controller->register_routes();
    }

    private function addOptionPage()
    {
        if ( ! function_exists('acf_add_options_page')) {
            return;
        }

        acf_add_options_page(array(
            'page_title' => __('Theme Settings', 'initializr'),
            'menu_slug'  => 'theme-settings',
            'capability' => 'edit_posts',
            'icon_url'   => 'dashicons-laptop',
        ));
    }
}