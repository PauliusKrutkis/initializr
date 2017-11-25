<?php

return [
    'product_category' => [
        'label'     => 'Product categories',
        'post-type' => 'products',
        'options'   => [
            'hierarchical' => true,
            'query_var'    => true,
        ]
    ],
    'product_tag'      => [
        'label'     => 'Product tags',
        'post-type' => 'products',
        'options'   => [
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'query_var'          => true,
            'rewrite'            => true,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => null,
            'taxonomies'         => array('tag')
        ]
    ]
];
