<?php get_header(); ?>

<div class="container content_page">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="entry-meta">
                                <span class="posted-on"><?php echo get_the_date(); ?></span>
                                <span class="byline"> by <?php the_author_posts_link(); ?></span>
                                <span class="cat-links"> in <?php the_category(', '); ?></span>
                            </div>
                        </header>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        <footer class="entry-footer">
                            <?php the_tags('<span class="tags-links">', ', ', '</span>'); ?>
                        </footer>
                    </article>

                    <div class="comments-section">
                        <?php
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    </div>
                <?php
                endwhile;
            else :
                echo '<p>' . __('Sorry, no posts matched your criteria.', 'costheme') . '</p>';
            endif;
            ?>
        </div>
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
