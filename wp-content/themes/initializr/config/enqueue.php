<?php

return [
    'styles'   => [
        'bootstrap-grid' => [
            'src' => get_template_directory_uri() . '/assets/css/lib/bootstrap-grid.css'
        ],
        'styles'         => [
            'src' => get_template_directory_uri() . '/assets/css/styles.css'
        ]
    ],
    'scripts'  => [
        'scripts' => [
            'src'  => get_template_directory_uri() . '/assets/js/scripts.js',
            'deps' => ['jquery', 'jquery-ui-selectmenu'],
        ],
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
