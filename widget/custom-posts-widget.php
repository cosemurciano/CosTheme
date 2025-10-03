<?php
class Custom_Posts_Widget extends WP_Widget {

    // Costruttore
    public function __construct() {
        parent::__construct(
            'custom_posts_widget', // Base ID
            __('Custom Posts Widget', 'text_domain'), // Nome del widget
            array('description' => __('Un widget che visualizza un elenco di post personalizzato', 'text_domain'))
        );
    }

    // Formulario nel backend
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $category = !empty($instance['category']) ? $instance['category'] : '';
        $number = !empty($instance['number']) ? $instance['number'] : 5;
        $order = !empty($instance['order']) ? $instance['order'] : 'date';
        $show_excerpt = !empty($instance['show_excerpt']) ? $instance['show_excerpt'] : false;
        $show_image = !empty($instance['show_image']) ? $instance['show_image'] : false;
        $show_date = !empty($instance['show_date']) ? $instance['show_date'] : false; // Aggiungi questa linea
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'text_domain'); ?></label>
            <?php wp_dropdown_categories(array(
                'name' => $this->get_field_name('category'),
                'id' => $this->get_field_id('category'),
                'selected' => $category,
                'show_option_all' => __('All Categories', 'text_domain')
            )); ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', 'text_domain'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:', 'text_domain'); ?></label>
            <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat">
                <option value="date" <?php selected($order, 'date'); ?>><?php _e('Chronological', 'text_domain'); ?></option>
                <option value="rand" <?php selected($order, 'rand'); ?>><?php _e('Random', 'text_domain'); ?></option>
            </select>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_excerpt, 'on'); ?> id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" />
            <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show Excerpt', 'text_domain'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_image, 'on'); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" />
            <label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show Image', 'text_domain'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_date, 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show Date', 'text_domain'); ?></label>
        </p>
        <?php
    }

    // Salvataggio delle opzioni del widget
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        $instance['order'] = (!empty($new_instance['order'])) ? strip_tags($new_instance['order']) : 'date';
        $instance['show_excerpt'] = (!empty($new_instance['show_excerpt'])) ? strip_tags($new_instance['show_excerpt']) : false;
        $instance['show_image'] = (!empty($new_instance['show_image'])) ? strip_tags($new_instance['show_image']) : false;
        $instance['show_date'] = (!empty($new_instance['show_date'])) ? strip_tags($new_instance['show_date']) : false; // Aggiungi questa linea

        return $instance;
    }

    // Output nel frontend
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $category = !empty($instance['category']) ? $instance['category'] : '';
        $number = !empty($instance['number']) ? $instance['number'] : 5;
        $order = !empty($instance['order']) ? $instance['order'] : 'date';
        $show_excerpt = !empty($instance['show_excerpt']) ? $instance['show_excerpt'] : false;
        $show_image = !empty($instance['show_image']) ? $instance['show_image'] : false;
        $show_date = !empty($instance['show_date']) ? $instance['show_date'] : false; // Aggiungi questa linea

        echo $args['before_widget'];

        if (!empty($title)) {
            $cat_link = get_category_link($category);
            echo $args['before_title'] . '<a href="' . esc_url($cat_link) . '">' . $title . '</a>' . $args['after_title'];
        }

        $query_args = array(
            'cat' => $category,
            'posts_per_page' => $number,
            'orderby' => $order
        );
        $query = new WP_Query($query_args);

        if ($query->have_posts()) {
            echo '<ul>';
            while ($query->have_posts()) : $query->the_post();
                echo '<li>';
                if ($show_image && has_post_thumbnail()) {
                    echo '<a href="' . get_the_permalink() . '">';
                    the_post_thumbnail('medium', array('alt' => get_the_title(), 'title' => get_the_title()));
                    echo '</a>';
                }
                echo '<h4><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h4>';
                if ($show_date) {
                    echo '<p class="post-date">' . get_the_date() . '</p>';
                }
                if ($show_excerpt) {
                    echo '<p>' . get_the_excerpt() . '</p>';
                }
                echo '</li>';
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }
}

// Registrare il widget
function register_custom_posts_widget() {
    register_widget('Custom_Posts_Widget');
}
add_action('widgets_init', 'register_custom_posts_widget');
?>
