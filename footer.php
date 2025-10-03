<footer class="footer bg-light">
    <div class="container">
        <div class="row">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="col-md-3">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="col-md-3">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-3')) : ?>
                <div class="col-md-3">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-4')) : ?>
                <div class="col-md-3">
                    <?php dynamic_sidebar('footer-4'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="footer-bottom text-center py-3">
            <span class="text-muted">
                <?php echo wp_kses_post(get_option('costheme_footer_text', '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.')); ?>
            </span>
        </div>
    </div>
	
    <?php wp_footer(); ?>
</footer>
<?php
$whatsapp_number = get_option('costheme_whatsapp_number', '');
if (!empty($whatsapp_number)) :
?>
    <a href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>" class="whatsapp-icon" target="_blank">
        <img src="<?php echo get_template_directory_uri(); ?>/images/whatsapp-icon.png" alt="WhatsApp">
    </a>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>




