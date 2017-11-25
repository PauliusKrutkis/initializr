<?php

return [
    'styles'   => [
        'bootstrap-grid' => [
            'src' => get_bloginfo('template_url') . '/assets/css/lib/bootstrap-grid.css',
        ],
        'styles'         => [
            'src' => get_bloginfo('template_url') . '/assets/css/styles.css',
        ]
    ],
    'scripts'  => [
        'scripts' => [
            'src'       => get_bloginfo('template_url') . '/assets/js/scripts.js',
            'deps'      => ['jquery', 'jquery-ui-selectmenu'],
            'ver'       => null,
            'in-footer' => true
        ]
    ],
    'localize' => [
        'scripts' => [
            'prefix'  => 'api',
            'strings' => [
                'ajaxUrl' => admin_url('admin-ajax.php'),
            ]
        ]
    ]
];
