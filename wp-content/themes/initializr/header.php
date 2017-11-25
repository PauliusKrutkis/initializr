<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="page-wrapper">

    <header role="banner" class="page-head">
        <?php
        the_custom_logo();
        get_template_part('partials/nav')
        ?>
    </header>

    <main role="main" class="page-content">
