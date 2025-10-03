<?php get_header(); ?>

<div class="container content_page">
    <div class="row">
        <div class="col-md-8">
            <?php if ( have_posts() ) : ?>
                <header class="page-header">
                    <h1 class="page-title">
                        <?php single_cat_title(); ?>
                    </h1>
                    <?php if ( category_description() ) : ?>
                        <div class="archive-meta"><?php echo category_description(); ?></div>
                    <?php endif; ?>
                </header>
                
                <?php
                // Definire i parametri per la paginazione
                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 10,
                    'paged' => $paged,
                );
                $wp_query = new WP_Query( $args );

                // Loop degli articoli
                while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h3 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h3>
                        </header>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                        <footer class="entry-footer">
                            <span class="posted-on"><?php echo get_the_date(); ?></span>
                            <span class="byline"> by <?php the_author_posts_link(); ?></span>
                            <span class="cat-links"> in <?php the_category(', '); ?></span>
                        </footer>
                    </article>
                <?php endwhile; ?>

                <!-- Paginazione -->
                <div class="pagination">
                    <?php
                    echo paginate_links( array(
                        'total' => $wp_query->max_num_pages,
                    ) );
                    ?>
                </div>

                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p><?php _e('Sorry, no posts matched your criteria.', 'costheme'); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
