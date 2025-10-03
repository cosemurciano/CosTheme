<?php
// Carica gli stili e gli script necessari
function costheme_enqueue_scripts() {
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    wp_enqueue_style('costheme-style', get_stylesheet_uri());
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'costheme_enqueue_scripts');

// Aggiungi il supporto per il logo personalizzato
function costheme_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'costheme_custom_logo_setup');

// Aggiungi il supporto per i menu di navigazione
function costheme_setup() {
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'costheme'),
        'secondary' => __('Secondary Menu', 'costheme'),
    ));
}
add_action('after_setup_theme', 'costheme_setup');

// Aggiungi il supporto per i widget
function costheme_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar 1', 'costheme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your first sidebar.', 'costheme'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => __('Sidebar 2', 'costheme'),
        'id' => 'sidebar-2',
        'description' => __('Add widgets here to appear in your second sidebar.', 'costheme'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    // Registrare le aree widget nel footer
    register_sidebar(array(
        'name' => __('Footer Widget Area 1', 'costheme'),
        'id' => 'footer-1',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Widget Area 2', 'costheme'),
        'id' => 'footer-2',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Widget Area 3', 'costheme'),
        'id' => 'footer-3',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Widget Area 4', 'costheme'),
        'id' => 'footer-4',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'costheme_widgets_init');

// Includi il pannello di amministrazione
require get_template_directory() . '/inc/admin-panel.php';

// Includi le personalizzazioni del customizer
require get_template_directory() . '/inc/customizer.php';

// Include il file del walker
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// Includi la Media Library per l'admin panel
function costheme_enqueue_admin_scripts() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'costheme_enqueue_admin_scripts');

// Aggiungi metabox per nascondere il titolo della pagina
function costheme_add_meta_boxes() {
    add_meta_box('costheme_hide_title', __('Hide Page Title', 'costheme'), 'costheme_hide_title_callback', 'page', 'side');
}
add_action('add_meta_boxes', 'costheme_add_meta_boxes');

function costheme_hide_title_callback($post) {
    $value = get_post_meta($post->ID, '_costheme_hide_title', true);
    wp_nonce_field('costheme_hide_title_save', 'costheme_hide_title_nonce');
    ?>
    <label for="costheme_hide_title">
        <input type="checkbox" name="costheme_hide_title" id="costheme_hide_title" value="1" <?php checked($value, '1'); ?> />
        <?php _e('Hide the title for this page', 'costheme'); ?>
    </label>
    <?php
}

function costheme_save_meta_boxes($post_id) {
    if (!isset($_POST['costheme_hide_title_nonce']) || !wp_verify_nonce($_POST['costheme_hide_title_nonce'], 'costheme_hide_title_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['costheme_hide_title'])) {
        update_post_meta($post_id, '_costheme_hide_title', '1');
    } else {
        delete_post_meta($post_id, '_costheme_hide_title');
    }
}
add_action('save_post', 'costheme_save_meta_boxes');

require get_template_directory() . '/widget/custom-posts-widget.php';




?>


