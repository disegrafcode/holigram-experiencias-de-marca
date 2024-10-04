<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="wrapper" class="hfeed">
        <header id="header" role="banner">
            <nav class="navbar navbar-expand-md fixed-top bg-white custom-menu shadow-lg" aria-label="menu-principal">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo home_url(); ?>">
                        <?php $logo_url = get_theme_mod('logotipo'); ?>
                        <?php if ($logo_url) {
                            ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>"
                            class="logo-brand">
                        <?php } else {
                            echo esc_html(get_bloginfo('name'));
                        } ?>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#isil-menu"
                        aria-controls="isil-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="isil-menu">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'main-menu',
                                'container' => false,
                                'menu_class' => 'navbar-nav'
                            )
                        );
                        ?>
                        <?php
                        /* PERSONALIZADO CON FUNCTIONS*/
                        $hide_menu_search = get_theme_mod('hide_menu_search'); //ocultar el menu
                        if (!$hide_menu_search) {
                            get_search_form();
                        }
                        /* PERSONALIZADO CON PHP PLUGIN */
                        ?>
                    </div>
                </div>
            </nav>

            <!-- SEO Y POSICIONAMIENTO -->
            <div id="branding" style="display: none;">
                <div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                    <?php
                    if (is_front_page() || is_home() || is_front_page() && is_home()) {
                        echo '<h1>';
                    }
                    echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home" itemprop="url"><span itemprop="name">' . esc_html(get_bloginfo('name')) . '</span></a>';
                    if (is_front_page() || is_home() || is_front_page() && is_home()) {
                        echo '</h1>';
                    }
                    ?>
                </div>
                <div id="site-description" <?php if (!is_single()) {
                    echo ' itemprop="description"';
                } ?>><?php bloginfo('description'); ?></div>
            </div>
            <!-- SEO Y POSICIONAMIENTO -->
        </header>
        <div id="container">
             <div id="content" role="main" class="container"> <!-- ajuste temporal -->