<?php
class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {
    // Start Level
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
    }

    // Start Element
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        if (isset($args->has_children) && $args->has_children) {
            $class_names .= ' dropdown';
        }

        if (in_array('current-menu-item', $classes)) {
            $class_names .= ' active';
        }

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        if (isset($args->has_children) && $args->has_children) {
            $atts['class'] = 'dropdown-toggle';
            $atts['data-toggle'] = 'dropdown';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= (isset($args->has_children) && $args->has_children) ? ' <span class="caret"></span></a>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // Display Element
    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        }

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    // Menu Fallback
    function fallback( $args ) {
        if ( current_user_can( 'edit_theme_options' ) ) {
            $container = $args['container'];
            $container_id = $args['container_id'];
            $container_class = $args['container_class'];
            $menu_class = $args['menu_class'];
            $menu_id = $args['menu_id'];
            $output = '';

            if ( $container ) {
                $output = '<' . $container;
                if ( $container_id ) {
                    $output .= ' id="' . $container_id . '"';
                }
                if ( $container_class ) {
                    $output .= ' class="' . $container_class . '"';
                }
                $output .= '>';
            }

            $output .= '<ul';
            if ( $menu_id ) {
                $output .= ' id="' . $menu_id . '"';
            }
            if ( $menu_class ) {
                $output .= ' class="' . $menu_class . '"';
            }
            $output .= '>';
            $output .= '<li class="nav-item"><a href="' . admin_url( 'nav-menus.php' ) . '" class="nav-link">' . __( 'Add a menu', 'costheme' ) . '</a></li>';
            $output .= '</ul>';

            if ( $container ) {
                $output .= '</' . $container . '>';
            }

            echo $output;
        }
    }
}
?>
