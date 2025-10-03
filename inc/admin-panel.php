<?php
// Aggiungi un pannello di amministrazione accessibile
function costheme_add_admin_menu() {
    add_menu_page(
        __('CosTheme Settings', 'costheme'),
        __('CosTheme', 'costheme'),
        'manage_options',
        'costheme-settings',
        'costheme_admin_page',
        'dashicons-admin-generic',
        20
    );
}
add_action('admin_menu', 'costheme_add_admin_menu');

function costheme_admin_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('CosTheme Settings', 'costheme'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('costheme-settings-group');
            do_settings_sections('costheme-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function costheme_register_settings() {
    register_setting('costheme-settings-group', 'costheme_logo', 'esc_url_raw');
    register_setting('costheme-settings-group', 'costheme_footer_text', 'wp_kses_post');
    register_setting('costheme-settings-group', 'costheme_show_topbar', 'sanitize_text_field');
    register_setting('costheme-settings-group', 'costheme_topbar_title', 'sanitize_text_field');
    register_setting('costheme-settings-group', 'costheme_topbar_address', 'sanitize_text_field');
    register_setting('costheme-settings-group', 'costheme_topbar_phone', 'sanitize_text_field');
    register_setting('costheme-settings-group', 'costheme_topbar_facebook', 'esc_url_raw');
    register_setting('costheme-settings-group', 'costheme_topbar_instagram', 'esc_url_raw');
    register_setting('costheme-settings-group', 'costheme_topbar_youtube', 'esc_url_raw');
    register_setting('costheme-settings-group', 'costheme_whatsapp_number', 'sanitize_text_field'); // Aggiungi questa riga

    add_settings_section('costheme-settings-section', __('General Settings', 'costheme'), null, 'costheme-settings');

    add_settings_field('costheme-logo', __('Upload Logo', 'costheme'), 'costheme_logo_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-footer-text', __('Footer Text', 'costheme'), 'costheme_footer_text_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-show-topbar', __('Show Topbar', 'costheme'), 'costheme_show_topbar_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-topbar-title', __('Topbar Site Title', 'costheme'), 'costheme_topbar_title_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-topbar-address', __('Topbar Address', 'costheme'), 'costheme_topbar_address_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-topbar-phone', __('Topbar Phone', 'costheme'), 'costheme_topbar_phone_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-topbar-facebook', __('Facebook URL', 'costheme'), 'costheme_topbar_facebook_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-topbar-instagram', __('Instagram URL', 'costheme'), 'costheme_topbar_instagram_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-topbar-youtube', __('YouTube URL', 'costheme'), 'costheme_topbar_youtube_callback', 'costheme-settings', 'costheme-settings-section');
    add_settings_field('costheme-whatsapp-number', __('WhatsApp Phone Number', 'costheme'), 'costheme_whatsapp_number_callback', 'costheme-settings', 'costheme-settings-section'); // Aggiungi questa riga
}
add_action('admin_init', 'costheme_register_settings');

// Callback per il campo del numero di telefono di WhatsApp
function costheme_whatsapp_number_callback() {
    $whatsapp_number = get_option('costheme_whatsapp_number');
    ?>
    <input type="text" name="costheme_whatsapp_number" id="costheme_whatsapp_number" value="<?php echo esc_attr($whatsapp_number); ?>" class="regular-text" />
    <p class="description"><?php _e('Enter your WhatsApp phone number including country code. Example: 1234567890', 'costheme'); ?></p>
    <?php
}

function costheme_logo_callback() {
    $logo = get_option('costheme_logo');
    ?>
    <input type="hidden" name="costheme_logo" id="costheme_logo" value="<?php echo esc_attr($logo); ?>">
    <input id="upload_logo_button" type="button" class="button" value="<?php _e('Upload Logo', 'costheme'); ?>" />
    <input id="remove_logo_button" type="button" class="button" value="<?php _e('Remove Logo', 'costheme'); ?>" />
    <div id="logo_preview">
        <?php if ($logo) : ?>
            <img src="<?php echo esc_url($logo); ?>" alt="Logo" style="max-width: 300px; display: block; margin-top: 10px;">
        <?php endif; ?>
    </div>
    <script>
        jQuery(document).ready(function($) {
            var frame;
            $('#upload_logo_button').on('click', function(event) {
                event.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: '<?php _e('Select or Upload Logo', 'costheme'); ?>',
                    button: {
                        text: '<?php _e('Use this logo', 'costheme'); ?>'
                    },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#costheme_logo').val(attachment.url);
                    $('#logo_preview').html('<img src="' + attachment.url + '" alt="Logo" style="max-width: 300px; display: block; margin-top: 10px;">');
                });
                frame.open();
            });
            $('#remove_logo_button').on('click', function(event) {
                event.preventDefault();
                $('#costheme_logo').val('');
                $('#logo_preview').html('');
            });
        });
    </script>
    <?php
}

function costheme_footer_text_callback() {
    $footer_text = get_option('costheme_footer_text');
    ?>
    <textarea name="costheme_footer_text" id="costheme_footer_text" rows="5" cols="50" class="large-text"><?php echo esc_textarea($footer_text); ?></textarea>
    <?php
}

function costheme_show_topbar_callback() {
    $show_topbar = get_option('costheme_show_topbar');
    ?>
    <input type="checkbox" name="costheme_show_topbar" id="costheme_show_topbar" value="1" <?php checked($show_topbar, '1'); ?> />
    <label for="costheme_show_topbar"><?php _e('Show Topbar', 'costheme'); ?></label>
    <?php
}

function costheme_topbar_title_callback() {
    $topbar_title = get_option('costheme_topbar_title');
    ?>
    <input type="text" name="costheme_topbar_title" id="costheme_topbar_title" value="<?php echo esc_attr($topbar_title); ?>" class="regular-text" />
    <?php
}

function costheme_topbar_address_callback() {
    $topbar_address = get_option('costheme_topbar_address');
    ?>
    <input type="text" name="costheme_topbar_address" id="costheme_topbar_address" value="<?php echo esc_attr($topbar_address); ?>" class="regular-text" />
    <?php
}

function costheme_topbar_phone_callback() {
    $topbar_phone = get_option('costheme_topbar_phone');
    ?>
    <input type="text" name="costheme_topbar_phone" id="costheme_topbar_phone" value="<?php echo esc_attr($topbar_phone); ?>" class="regular-text" />
    <?php
}

function costheme_topbar_facebook_callback() {
    $topbar_facebook = get_option('costheme_topbar_facebook');
    ?>
    <input type="url" name="costheme_topbar_facebook" id="costheme_topbar_facebook" value="<?php echo esc_url($topbar_facebook); ?>" class="regular-text" />
    <?php
}

function costheme_topbar_instagram_callback() {
    $topbar_instagram = get_option('costheme_topbar_instagram');
    ?>
    <input type="url" name="costheme_topbar_instagram" id="costheme_topbar_instagram" value="<?php echo esc_url($topbar_instagram); ?>" class="regular-text" />
    <?php
}

function costheme_topbar_youtube_callback() {
    $topbar_youtube = get_option('costheme_topbar_youtube');
    ?>
    <input type="url" name="costheme_topbar_youtube" id="costheme_topbar_youtube" value="<?php echo esc_url($topbar_youtube); ?>" class="regular-text" />
    <?php
}
?>


