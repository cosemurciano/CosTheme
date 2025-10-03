<?php
// Aggiungi impostazioni e controlli al customizer
function costheme_customize_register($wp_customize) {
    $wp_customize->add_section('costheme_color_scheme', array(
        'title' => __('Color Scheme', 'costheme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('costheme_primary_color', array(
        'default' => '#007bff',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'costheme_primary_color', array(
        'label' => __('Primary Color', 'costheme'),
        'section' => 'costheme_color_scheme',
        'settings' => 'costheme_primary_color',
    )));

    // Aggiungi un'impostazione per caricare l'immagine
    $wp_customize->add_setting('costheme_header_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    // Aggiungi un controllo per caricare l'immagine
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'costheme_header_image', array(
        'label' => __('Header Image', 'costheme'),
        'section' => 'title_tagline',
        'settings' => 'costheme_header_image',
    )));
}
add_action('customize_register', 'costheme_customize_register');

function costheme_customizer_css() {
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo get_theme_mod('costheme_primary_color', '#007bff'); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'costheme_customizer_css');
?>
