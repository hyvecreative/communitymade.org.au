<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="index,follow,noarchive">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/images/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/site.webmanifest">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="wrapper">
<div class="wrapper__inner">

<header class="header">
    <div class="shell d-flex justify-content-between">

        <div class="header__logo col-auto">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="Back to home page">
        <img
            src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/images/community-made-logo-lozonge.svg"
            alt=""
            width="331"
            height="146"
            loading="eager"
        >
    </a>
</div>

        <div class="header__menu col-auto d-flex">
            <div class="header__nav col-auto">
                <?php
                if (has_nav_menu('main-menu')) {
                    wp_nav_menu([
                        'theme_location' => 'main-menu',
                        'container'      => 'nav',
                        'container_class'=> 'nav',
                        'menu_class'     => 'd-flex toplevel',
                        'depth'          => 3,
                    ]);
                }
                ?>
            </div>

            <?php get_template_part('fragments/header/button'); ?>
        </div>

        <div class="header__toggle">
            <?php get_template_part('fragments/header/button'); ?>
            <div class="menu-toggle js-toggle">
                <span></span><span></span><span></span>
            </div>
        </div>

    </div>
</header>
