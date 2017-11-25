<?php

return [
    'products' => [
        'menu_icon'   => 'dashicons-star-filled',
        'supports'    => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive' => true,
        'taxonomies'  => array('event_tag'),
        'public'      => true,
//        'no-single'   => true,
    ],
];
