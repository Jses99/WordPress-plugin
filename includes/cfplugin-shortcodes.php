<?php

function cfplugin_shortcode($cfp_attr) {
    $default = array(
        'category' => 'all'
    );
    $cat = shortcode_atts($default, $cfp_attr);

    if($cat['category'] == 'all'):
        $args = array(
            'post_type' => 'cfplugin_review',
            'post_status' => 'publish',
            'orderby' => 'rand',
            'posts_per_page' => 6,
        );
    endif;

    $text = '<div class="cf_plugin">';
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

    $text .= '</div>';

    wp_reset_postdata();

    return $text;
}

add_shortcode('customer-feedback-plugin', 'cfplugin_shortcode');

?>