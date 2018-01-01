<?php


namespace App;


class Theme
{
    public function __construct()
    {
        $this->addOptionPage();
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