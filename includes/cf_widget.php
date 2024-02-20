<?php

class CFplugin_Widget extends WP_Widget {

public function __construct() {
    parent::__construct(
        'cfplugin_widget',
        'Small Feedback',
        array(
            'customize_selective_refresh' => true
        )
    );
}
 
public function form( $instance ) {
    $defaults = array(
        'title' => '',
    );

    extract(wp_parse_args((array) $instance, $defaults)); ?>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title</label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
        name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
        value="<?php echo esc_attr($title); ?>">
    </p>

<?php
}
 
public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = isset($new_instance['title']) ? wp_strip_all_tags($new_instance['title']) : '';
    return $instance;
}

public function widget( $args, $instance ) {

    extract($args);

    $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
    $category = isset($instance['cateogry']) ? $instance['category'] : 'all';

    echo $before_widget;

    echo '<div class="wp-widget-cfplugin">';
    
    if($title) :
        echo $before_title . $title . $after_title;
    endif;

    if($category == 'all'):
        $args = array(
            'post_type' => 'cfplugin_review',
            'post_status' => 'publish',
            'orderby' => 'rand',
            'posts_per_page' => 1,
        );
    endif;

    $text = '';
        $loop = new WP_Query($args);
        if ($loop->have_posts()):
            while($loop->have_posts()) : $loop->the_post();
                $name = get_post_meta(get_the_ID(), '_cfplugin_meta_name', true);
                $text .= '<section class="customer-feedback"><h3>' . get_the_title() . '</h3>';
                $text .= get_the_post_thumbnail();
                $text .= '<p>' . get_the_content() . '</p>';
                $text .= '<p>' . $name . '</p></section>';
            endwhile;
        endif;

    echo $text;    
    
    wp_reset_postdata();

    echo '</div>';

    echo $after_widget;
}

}

function cfplugin_register_widget() {
    register_widget('CFplugin_Widget');
}

add_action('widgets_init', 'cfplugin_register_widget');

?>