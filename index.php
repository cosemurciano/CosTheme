<?php get_header(); ?>
<div class="container main-content">
    <div class="content-area">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('templates/content', get_post_format());
            endwhile;
            the_posts_navigation();
        else :
            get_template_part('templates/content', 'none');
        endif;
        ?>
    </div>
    <div class="sidebar-area">
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
