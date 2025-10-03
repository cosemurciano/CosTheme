<?php
/*
Template Name: Blank Page
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Content -->
                <div class="content">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                    else :
                        echo '<p>' . __('No content found', 'costheme') . '</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
