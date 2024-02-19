<?php
/* Register a new post type: feedback */

function cfplugin_register_post_type() {
    add_theme_support('post-thumbnails');

    $labels = array(
        'name' => 'Reviews',
        'singular_name' => 'Review',
        'add_new' => 'New Review',
        'add_new_item' => 'Add new Review',
        'edit_item' => 'Edit Review',
        'new_item' => 'New review',
        'view_item' => 'View Reviews',
        'not_found' => 'Reviews not found',
        'not_found_in_trash' => 'Reviews not found in trashcan'
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'custom-fields'
        ),
        'rewrite' => array('slug' => 'review'),
        'show_in_rest' => true
    );

    register_post_type('cfplugin_review', $args);
}

add_action('init', 'cfplugin_register_post_type');

//Add a name field
function cfplugin_add_custom_box() {
    add_meta_box(
        'cfplugin_name_id',
        'Name',
        'cfplugin_name_box_html',
        'cfplugin_review'
    );
}

add_action('add_meta_boxes', 'cfplugin_add_custom_box');

function cfplugin_name_box_html($post) {
    $value = get_post_meta($post->ID, '_cfplugin_meta_name', true);
    ?>
    <label for="cfplugin_name">Name</label>
    <input type="text" name="cfplugin_name" id="cfplugin_name" value="<?php echo $value; ?>">
    <?php
}

function cfplugin_save_postdata($post_id) {
    if(array_key_exists('cfplugin_name', $_POST)):
        update_post_meta(
            $post_id,
            '_cfplugin_meta_name',
            sanitize_text_field($_POST['cfplugin_name'])
        );
    endif;
}

add_action('save_post', 'cfplugin_save_postdata');

?>
