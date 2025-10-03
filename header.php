<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (get_option('costheme_show_topbar')) : ?>
    <div class="topbar bg-light py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="topbar-left d-flex align-items-center">
                <?php if (get_option('costheme_topbar_title')) : ?>
                    <span class="topbar-title mr-3"><?php echo esc_html(get_option('costheme_topbar_title')); ?></span>
                <?php endif; ?>
                <?php if (get_option('costheme_topbar_address')) : ?>
                    <span class="topbar-address mr-3"><?php echo esc_html(get_option('costheme_topbar_address')); ?></span>
                <?php endif; ?>
                <?php if (get_option('costheme_topbar_phone')) : ?>
                    <span class="topbar-phone mr-3"><?php echo esc_html(get_option('costheme_topbar_phone')); ?></span>
                <?php endif; ?>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'secondary',
                    'container' => 'div',
                    'container_class' => 'topbar-menu',
                    'menu_class' => 'nav',
                    'fallback_cb' => '__return_false',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' => 1,
                ));
                ?>
            </div>
            <div class="topbar-right d-flex align-items-center">
                <?php if (get_option('costheme_topbar_facebook')) : ?>
                    <a href="<?php echo esc_url(get_option('costheme_topbar_facebook')); ?>" target="_blank" class="text-dark ml-3"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if (get_option('costheme_topbar_instagram')) : ?>
                    <a href="<?php echo esc_url(get_option('costheme_topbar_instagram')); ?>" target="_blank" class="text-dark ml-3"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
                <?php if (get_option('costheme_topbar_youtube')) : ?>
                    <a href="<?php echo esc_url(get_option('costheme_topbar_youtube')); ?>" target="_blank" class="text-dark ml-3"><i class="fab fa-youtube"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container d-flex align-items-center">
			
            <a class="navbar-brand d-flex align-items-center" href="<?php echo esc_url(home_url('/')); ?>">
                <h1 style="display: none;"><?php bloginfo('name'); ?></h1>
                <?php if (get_option('costheme_logo')) : ?>
                    <img src="<?php echo esc_url(get_option('costheme_logo')); ?>" alt="<?php bloginfo('name'); ?>" class="ml-2 logo_navbar">
                <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'costheme'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => 'div',
                'container_class' => 'collapse navbar-collapse',
                'container_id' => 'navbarNav',
                'menu_class' => 'navbar-nav ml-auto',
                'fallback_cb' => '__return_false',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 2,
                'walker' => new WP_Bootstrap_Navwalker(),
            ));
            ?>
        </div>
    </nav>

