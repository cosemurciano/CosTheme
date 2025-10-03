<?php
/*
Template Name: Three Columns
*/
get_header();
?>

<div class="container content_page">
    <div class="row">
        <div class="col-md-6">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    if (!get_post_meta(get_the_ID(), '_costheme_hide_title', true)) : ?>
                        <h2><?php the_title(); ?></h2>
                    <?php endif;
                    the_content();
                endwhile;
            else :
                echo '<p>' . __('No content found', 'costheme') . '</p>';
            endif;
            ?>
        </div>
        <div class="col-md-3">
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <?php dynamic_sidebar('sidebar-1'); ?>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <?php if (is_active_sidebar('sidebar-2')) : ?>
                <?php dynamic_sidebar('sidebar-2'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
