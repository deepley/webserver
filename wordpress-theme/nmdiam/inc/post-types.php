<?php
/**
 * Custom Post Types for NMDIAM theme
 *
 * @package NMDIAM
 */

/**
 * Register custom post types
 */
function nmdiam_register_post_types() {
    // Testimonial Post Type
    $testimonial_labels = array(
        'name'                  => _x('Testimonials', 'Post type general name', 'nmdiam'),
        'singular_name'         => _x('Testimonial', 'Post type singular name', 'nmdiam'),
        'menu_name'             => _x('Testimonials', 'Admin Menu text', 'nmdiam'),
        'name_admin_bar'        => _x('Testimonial', 'Add New on Toolbar', 'nmdiam'),
        'add_new'               => __('Add New', 'nmdiam'),
        'add_new_item'          => __('Add New Testimonial', 'nmdiam'),
        'new_item'              => __('New Testimonial', 'nmdiam'),
        'edit_item'             => __('Edit Testimonial', 'nmdiam'),
        'view_item'             => __('View Testimonial', 'nmdiam'),
        'all_items'             => __('All Testimonials', 'nmdiam'),
        'search_items'          => __('Search Testimonials', 'nmdiam'),
        'parent_item_colon'     => __('Parent Testimonials:', 'nmdiam'),
        'not_found'             => __('No testimonials found.', 'nmdiam'),
        'not_found_in_trash'    => __('No testimonials found in Trash.', 'nmdiam'),
        'featured_image'        => _x('Testimonial Author Image', 'Overrides the "Featured Image" phrase', 'nmdiam'),
        'set_featured_image'    => _x('Set author image', 'Overrides the "Set featured image" phrase', 'nmdiam'),
        'remove_featured_image' => _x('Remove author image', 'Overrides the "Remove featured image" phrase', 'nmdiam'),
        'use_featured_image'    => _x('Use as author image', 'Overrides the "Use as featured image" phrase', 'nmdiam'),
        'archives'              => _x('Testimonial archives', 'The post type archive label used in nav menus', 'nmdiam'),
        'insert_into_item'      => _x('Insert into testimonial', 'Overrides the "Insert into post" phrase', 'nmdiam'),
        'uploaded_to_this_item' => _x('Uploaded to this testimonial', 'Overrides the "Uploaded to this post" phrase', 'nmdiam'),
        'filter_items_list'     => _x('Filter testimonials list', 'Screen reader text for the filter links', 'nmdiam'),
        'items_list_navigation' => _x('Testimonials list navigation', 'Screen reader text for the pagination', 'nmdiam'),
        'items_list'            => _x('Testimonials list', 'Screen reader text for the items list', 'nmdiam'),
    );

    $testimonial_args = array(
        'labels'             => $testimonial_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'testimonial'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('testimonial', $testimonial_args);

    // Team Member Post Type
    $team_labels = array(
        'name'                  => _x('Team Members', 'Post type general name', 'nmdiam'),
        'singular_name'         => _x('Team Member', 'Post type singular name', 'nmdiam'),
        'menu_name'             => _x('Team', 'Admin Menu text', 'nmdiam'),
        'name_admin_bar'        => _x('Team Member', 'Add New on Toolbar', 'nmdiam'),
        'add_new'               => __('Add New', 'nmdiam'),
        'add_new_item'          => __('Add New Team Member', 'nmdiam'),
        'new_item'              => __('New Team Member', 'nmdiam'),
        'edit_item'             => __('Edit Team Member', 'nmdiam'),
        'view_item'             => __('View Team Member', 'nmdiam'),
        'all_items'             => __('All Team Members', 'nmdiam'),
        'search_items'          => __('Search Team Members', 'nmdiam'),
        'parent_item_colon'     => __('Parent Team Members:', 'nmdiam'),
        'not_found'             => __('No team members found.', 'nmdiam'),
        'not_found_in_trash'    => __('No team members found in Trash.', 'nmdiam'),
        'featured_image'        => _x('Team Member Photo', 'Overrides the "Featured Image" phrase', 'nmdiam'),
        'set_featured_image'    => _x('Set team member photo', 'Overrides the "Set featured image" phrase', 'nmdiam'),
        'remove_featured_image' => _x('Remove team member photo', 'Overrides the "Remove featured image" phrase', 'nmdiam'),
        'use_featured_image'    => _x('Use as team member photo', 'Overrides the "Use as featured image" phrase', 'nmdiam'),
        'archives'              => _x('Team Member archives', 'The post type archive label used in nav menus', 'nmdiam'),
        'insert_into_item'      => _x('Insert into team member', 'Overrides the "Insert into post" phrase', 'nmdiam'),
        'uploaded_to_this_item' => _x('Uploaded to this team member', 'Overrides the "Uploaded to this post" phrase', 'nmdiam'),
        'filter_items_list'     => _x('Filter team members list', 'Screen reader text for the filter links', 'nmdiam'),
        'items_list_navigation' => _x('Team members list navigation', 'Screen reader text for the pagination', 'nmdiam'),
        'items_list'            => _x('Team members list', 'Screen reader text for the items list', 'nmdiam'),
    );

    $team_args = array(
        'labels'             => $team_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'team'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('team_member', $team_args);
}
add_action('init', 'nmdiam_register_post_types');

/**
 * Add meta boxes to testimonials
 */
function nmdiam_add_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'nmdiam'),
        'nmdiam_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nmdiam_add_testimonial_meta_boxes');

/**
 * Testimonial meta box callback
 */
function nmdiam_testimonial_meta_box_callback($post) {
    wp_nonce_field('nmdiam_testimonial_meta_box', 'nmdiam_testimonial_meta_box_nonce');

    $location = get_post_meta($post->ID, '_testimonial_location', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);

    ?>
    <p>
        <label for="testimonial_location"><?php esc_html_e('Location', 'nmdiam'); ?></label><br>
        <input type="text" id="testimonial_location" name="testimonial_location" value="<?php echo esc_attr($location); ?>" class="widefat">
        <span class="description"><?php esc_html_e('Enter the location of the person giving the testimonial (e.g., New York, Chicago)', 'nmdiam'); ?></span>
    </p>
    <p>
        <label for="testimonial_rating"><?php esc_html_e('Rating (1-5)', 'nmdiam'); ?></label><br>
        <select id="testimonial_rating" name="testimonial_rating" class="widefat">
            <option value=""><?php esc_html_e('Select Rating', 'nmdiam'); ?></option>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> <?php echo ($i === 1) ? esc_html__('Star', 'nmdiam') : esc_html__('Stars', 'nmdiam'); ?></option>
            <?php endfor; ?>
        </select>
    </p>
    <?php
}

/**
 * Save testimonial meta box data
 */
function nmdiam_save_testimonial_meta_box_data($post_id) {
    if (!isset($_POST['nmdiam_testimonial_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['nmdiam_testimonial_meta_box_nonce'], 'nmdiam_testimonial_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'testimonial' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (isset($_POST['testimonial_location'])) {
        update_post_meta($post_id, '_testimonial_location', sanitize_text_field($_POST['testimonial_location']));
    }

    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', intval($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'nmdiam_save_testimonial_meta_box_data');

/**
 * Add meta boxes to team members
 */
function nmdiam_add_team_member_meta_boxes() {
    add_meta_box(
        'team_member_details',
        __('Team Member Details', 'nmdiam'),
        'nmdiam_team_member_meta_box_callback',
        'team_member',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nmdiam_add_team_member_meta_boxes');

/**
 * Team member meta box callback
 */
function nmdiam_team_member_meta_box_callback($post) {
    wp_nonce_field('nmdiam_team_member_meta_box', 'nmdiam_team_member_meta_box_nonce');

    $position = get_post_meta($post->ID, '_team_member_position', true);
    $social_links = get_post_meta($post->ID, '_team_member_social_links', true);

    if (!is_array($social_links)) {
        $social_links = array(
            'facebook' => '',
            'twitter' => '',
            'linkedin' => '',
            'instagram' => '',
        );
    }

    ?>
    <p>
        <label for="team_member_position"><?php esc_html_e('Position/Title', 'nmdiam'); ?></label><br>
        <input type="text" id="team_member_position" name="team_member_position" value="<?php echo esc_attr($position); ?>" class="widefat">
    </p>
    <p>
        <strong><?php esc_html_e('Social Media Links', 'nmdiam'); ?></strong>
    </p>
    <p>
        <label for="team_member_facebook"><?php esc_html_e('Facebook', 'nmdiam'); ?></label><br>
        <input type="url" id="team_member_facebook" name="team_member_social_links[facebook]" value="<?php echo esc_url($social_links['facebook']); ?>" class="widefat">
    </p>
    <p>
        <label for="team_member_twitter"><?php esc_html_e('Twitter', 'nmdiam'); ?></label><br>
        <input type="url" id="team_member_twitter" name="team_member_social_links[twitter]" value="<?php echo esc_url($social_links['twitter']); ?>" class="widefat">
    </p>
    <p>
        <label for="team_member_linkedin"><?php esc_html_e('LinkedIn', 'nmdiam'); ?></label><br>
        <input type="url" id="team_member_linkedin" name="team_member_social_links[linkedin]" value="<?php echo esc_url($social_links['linkedin']); ?>" class="widefat">
    </p>
    <p>
        <label for="team_member_instagram"><?php esc_html_e('Instagram', 'nmdiam'); ?></label><br>
        <input type="url" id="team_member_instagram" name="team_member_social_links[instagram]" value="<?php echo esc_url($social_links['instagram']); ?>" class="widefat">
    </p>
    <?php
}

/**
 * Save team member meta box data
 */
function nmdiam_save_team_member_meta_box_data($post_id) {
    if (!isset($_POST['nmdiam_team_member_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['nmdiam_team_member_meta_box_nonce'], 'nmdiam_team_member_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'team_member' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (isset($_POST['team_member_position'])) {
        update_post_meta($post_id, '_team_member_position', sanitize_text_field($_POST['team_member_position']));
    }

    if (isset($_POST['team_member_social_links']) && is_array($_POST['team_member_social_links'])) {
        $social_links = array();
        foreach ($_POST['team_member_social_links'] as $platform => $url) {
            $social_links[$platform] = esc_url_raw($url);
        }
        update_post_meta($post_id, '_team_member_social_links', $social_links);
    }
}
add_action('save_post', 'nmdiam_save_team_member_meta_box_data');