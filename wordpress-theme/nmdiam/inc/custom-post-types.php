<?php
/**
 * Custom Post Types for NMDIAM Theme
 *
 * @package NMDIAM
 */

/**
 * Register Custom Post Types
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
        'featured_image'        => _x('Client Photo', 'Overrides the "Featured Image" phrase', 'nmdiam'),
        'set_featured_image'    => _x('Set client photo', 'Overrides the "Set featured image" phrase', 'nmdiam'),
        'remove_featured_image' => _x('Remove client photo', 'Overrides the "Remove featured image" phrase', 'nmdiam'),
        'use_featured_image'    => _x('Use as client photo', 'Overrides the "Use as featured image" phrase', 'nmdiam'),
        'archives'              => _x('Testimonial archives', 'The post type archive label used in nav menus', 'nmdiam'),
        'insert_into_item'      => _x('Insert into testimonial', 'Overrides the "Insert into post" phrase', 'nmdiam'),
        'uploaded_to_this_item' => _x('Uploaded to this testimonial', 'Overrides the "Uploaded to this post" phrase', 'nmdiam'),
        'filter_items_list'     => _x('Filter testimonials list', 'Screen reader text for the filter links heading on the post type listing screen', 'nmdiam'),
        'items_list_navigation' => _x('Testimonials list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'nmdiam'),
        'items_list'            => _x('Testimonials list', 'Screen reader text for the items list heading on the post type listing screen', 'nmdiam'),
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

    // Custom Order Post Type
    $custom_order_labels = array(
        'name'                  => _x('Custom Orders', 'Post type general name', 'nmdiam'),
        'singular_name'         => _x('Custom Order', 'Post type singular name', 'nmdiam'),
        'menu_name'             => _x('Custom Orders', 'Admin Menu text', 'nmdiam'),
        'name_admin_bar'        => _x('Custom Order', 'Add New on Toolbar', 'nmdiam'),
        'add_new'               => __('Add New', 'nmdiam'),
        'add_new_item'          => __('Add New Custom Order', 'nmdiam'),
        'new_item'              => __('New Custom Order', 'nmdiam'),
        'edit_item'             => __('Edit Custom Order', 'nmdiam'),
        'view_item'             => __('View Custom Order', 'nmdiam'),
        'all_items'             => __('All Custom Orders', 'nmdiam'),
        'search_items'          => __('Search Custom Orders', 'nmdiam'),
        'parent_item_colon'     => __('Parent Custom Orders:', 'nmdiam'),
        'not_found'             => __('No custom orders found.', 'nmdiam'),
        'not_found_in_trash'    => __('No custom orders found in Trash.', 'nmdiam'),
        'featured_image'        => _x('Order Image', 'Overrides the "Featured Image" phrase', 'nmdiam'),
        'set_featured_image'    => _x('Set order image', 'Overrides the "Set featured image" phrase', 'nmdiam'),
        'remove_featured_image' => _x('Remove order image', 'Overrides the "Remove featured image" phrase', 'nmdiam'),
        'use_featured_image'    => _x('Use as order image', 'Overrides the "Use as featured image" phrase', 'nmdiam'),
        'archives'              => _x('Custom Order archives', 'The post type archive label used in nav menus', 'nmdiam'),
        'insert_into_item'      => _x('Insert into custom order', 'Overrides the "Insert into post" phrase', 'nmdiam'),
        'uploaded_to_this_item' => _x('Uploaded to this custom order', 'Overrides the "Uploaded to this post" phrase', 'nmdiam'),
        'filter_items_list'     => _x('Filter custom orders list', 'Screen reader text for the filter links heading on the post type listing screen', 'nmdiam'),
        'items_list_navigation' => _x('Custom Orders list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'nmdiam'),
        'items_list'            => _x('Custom Orders list', 'Screen reader text for the items list heading on the post type listing screen', 'nmdiam'),
    );

    $custom_order_args = array(
        'labels'             => $custom_order_labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'editor'),
    );

    register_post_type('custom_order', $custom_order_args);

    // Subscription Post Type
    $subscription_labels = array(
        'name'                  => _x('Subscriptions', 'Post type general name', 'nmdiam'),
        'singular_name'         => _x('Subscription', 'Post type singular name', 'nmdiam'),
        'menu_name'             => _x('Newsletter Subscribers', 'Admin Menu text', 'nmdiam'),
        'name_admin_bar'        => _x('Subscription', 'Add New on Toolbar', 'nmdiam'),
        'add_new'               => __('Add New', 'nmdiam'),
        'add_new_item'          => __('Add New Subscription', 'nmdiam'),
        'new_item'              => __('New Subscription', 'nmdiam'),
        'edit_item'             => __('Edit Subscription', 'nmdiam'),
        'view_item'             => __('View Subscription', 'nmdiam'),
        'all_items'             => __('All Subscriptions', 'nmdiam'),
        'search_items'          => __('Search Subscriptions', 'nmdiam'),
        'parent_item_colon'     => __('Parent Subscriptions:', 'nmdiam'),
        'not_found'             => __('No subscriptions found.', 'nmdiam'),
        'not_found_in_trash'    => __('No subscriptions found in Trash.', 'nmdiam'),
    );

    $subscription_args = array(
        'labels'             => $subscription_labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-email',
        'supports'           => array('title'),
    );

    register_post_type('subscription', $subscription_args);
}
add_action('init', 'nmdiam_register_post_types');

/**
 * Add meta boxes for testimonials
 */
function nmdiam_testimonial_meta_boxes() {
    add_meta_box(
        'nmdiam_testimonial_meta',
        __('Testimonial Details', 'nmdiam'),
        'nmdiam_testimonial_meta_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nmdiam_testimonial_meta_boxes');

/**
 * Testimonial meta box callback
 */
function nmdiam_testimonial_meta_callback($post) {
    wp_nonce_field('nmdiam_testimonial_meta', 'nmdiam_testimonial_meta_nonce');
    
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    $position = get_post_meta($post->ID, '_testimonial_position', true);
    
    ?>
    <p>
        <label for="nmdiam_testimonial_rating"><?php _e('Rating (1-5)', 'nmdiam'); ?></label>
        <select id="nmdiam_testimonial_rating" name="nmdiam_testimonial_rating" class="widefat">
            <option value=""><?php _e('Select Rating', 'nmdiam'); ?></option>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> <?php echo _n('Star', 'Stars', $i, 'nmdiam'); ?></option>
            <?php endfor; ?>
        </select>
    </p>
    <p>
        <label for="nmdiam_testimonial_position"><?php _e('Position/Company', 'nmdiam'); ?></label>
        <input type="text" id="nmdiam_testimonial_position" name="nmdiam_testimonial_position" value="<?php echo esc_attr($position); ?>" class="widefat">
        <span class="description"><?php _e('E.g., "CEO, Company Name" or "New York, NY"', 'nmdiam'); ?></span>
    </p>
    <?php
}

/**
 * Save testimonial meta box data
 */
function nmdiam_save_testimonial_meta($post_id) {
    if (!isset($_POST['nmdiam_testimonial_meta_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['nmdiam_testimonial_meta_nonce'], 'nmdiam_testimonial_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['nmdiam_testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', intval($_POST['nmdiam_testimonial_rating']));
    }
    
    if (isset($_POST['nmdiam_testimonial_position'])) {
        update_post_meta($post_id, '_testimonial_position', sanitize_text_field($_POST['nmdiam_testimonial_position']));
    }
}
add_action('save_post_testimonial', 'nmdiam_save_testimonial_meta');

/**
 * Custom columns for testimonials
 */
function nmdiam_testimonial_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['rating'] = __('Rating', 'nmdiam');
    $new_columns['position'] = __('Position/Company', 'nmdiam');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_testimonial_posts_columns', 'nmdiam_testimonial_columns');

/**
 * Display testimonial custom column data
 */
function nmdiam_testimonial_column_data($column, $post_id) {
    switch ($column) {
        case 'rating':
            $rating = get_post_meta($post_id, '_testimonial_rating', true);
            echo $rating ? $rating . ' ' . _n('Star', 'Stars', $rating, 'nmdiam') : __('Not set', 'nmdiam');
            break;
        case 'position':
            $position = get_post_meta($post_id, '_testimonial_position', true);
            echo $position ? esc_html($position) : __('Not set', 'nmdiam');
            break;
    }
}
add_action('manage_testimonial_posts_custom_column', 'nmdiam_testimonial_column_data', 10, 2);

/**
 * Add meta boxes for custom orders
 */
function nmdiam_custom_order_meta_boxes() {
    add_meta_box(
        'nmdiam_custom_order_meta',
        __('Order Details', 'nmdiam'),
        'nmdiam_custom_order_meta_callback',
        'custom_order',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nmdiam_custom_order_meta_boxes');

/**
 * Custom order meta box callback
 */
function nmdiam_custom_order_meta_callback($post) {
    wp_nonce_field('nmdiam_custom_order_meta', 'nmdiam_custom_order_meta_nonce');
    
    $name = get_post_meta($post->ID, '_custom_order_name', true);
    $email = get_post_meta($post->ID, '_custom_order_email', true);
    $phone = get_post_meta($post->ID, '_custom_order_phone', true);
    $jewelry_type = get_post_meta($post->ID, '_custom_order_jewelry_type', true);
    $metal = get_post_meta($post->ID, '_custom_order_metal', true);
    $gemstone = get_post_meta($post->ID, '_custom_order_gemstone', true);
    $budget = get_post_meta($post->ID, '_custom_order_budget', true);
    $deadline = get_post_meta($post->ID, '_custom_order_deadline', true);
    $images = get_post_meta($post->ID, '_custom_order_images', true);
    $status = get_post_meta($post->ID, '_custom_order_status', true) ?: 'new';
    
    ?>
    <div class="custom-order-meta-wrapper">
        <div class="custom-order-meta-contact">
            <h3><?php _e('Contact Information', 'nmdiam'); ?></h3>
            <p>
                <strong><?php _e('Name:', 'nmdiam'); ?></strong>
                <?php echo esc_html($name); ?>
            </p>
            <p>
                <strong><?php _e('Email:', 'nmdiam'); ?></strong>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </p>
            <p>
                <strong><?php _e('Phone:', 'nmdiam'); ?></strong>
                <?php if ($phone) : ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                <?php else : ?>
                    <?php _e('Not provided', 'nmdiam'); ?>
                <?php endif; ?>
            </p>
        </div>

        <div class="custom-order-meta-details">
            <h3><?php _e('Order Details', 'nmdiam'); ?></h3>
            <p>
                <strong><?php _e('Jewelry Type:', 'nmdiam'); ?></strong>
                <?php echo esc_html($jewelry_type); ?>
            </p>
            <p>
                <strong><?php _e('Metal Preference:', 'nmdiam'); ?></strong>
                <?php echo $metal ? esc_html($metal) : __('Not specified', 'nmdiam'); ?>
            </p>
            <p>
                <strong><?php _e('Gemstone Preference:', 'nmdiam'); ?></strong>
                <?php echo $gemstone ? esc_html($gemstone) : __('Not specified', 'nmdiam'); ?>
            </p>
            <p>
                <strong><?php _e('Budget Range:', 'nmdiam'); ?></strong>
                <?php echo $budget ? esc_html($budget) : __('Not specified', 'nmdiam'); ?>
            </p>
            <p>
                <strong><?php _e('Completion Timeframe:', 'nmdiam'); ?></strong>
                <?php echo $deadline ? esc_html($deadline) : __('Not specified', 'nmdiam'); ?>
            </p>
        </div>

        <div class="custom-order-meta-status">
            <h3><?php _e('Order Status', 'nmdiam'); ?></h3>
            <p>
                <label for="nmdiam_custom_order_status"><?php _e('Status:', 'nmdiam'); ?></label>
                <select id="nmdiam_custom_order_status" name="nmdiam_custom_order_status" class="widefat">
                    <option value="new" <?php selected($status, 'new'); ?>><?php _e('New', 'nmdiam'); ?></option>
                    <option value="in_progress" <?php selected($status, 'in_progress'); ?>><?php _e('In Progress', 'nmdiam'); ?></option>
                    <option value="design_approval" <?php selected($status, 'design_approval'); ?>><?php _e('Design Approval', 'nmdiam'); ?></option>
                    <option value="production" <?php selected($status, 'production'); ?>><?php _e('In Production', 'nmdiam'); ?></option>
                    <option value="completed" <?php selected($status, 'completed'); ?>><?php _e('Completed', 'nmdiam'); ?></option>
                    <option value="delivered" <?php selected($status, 'delivered'); ?>><?php _e('Delivered', 'nmdiam'); ?></option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php _e('Cancelled', 'nmdiam'); ?></option>
                </select>
            </p>
        </div>

        <?php if ($images && is_array($images)) : ?>
            <div class="custom-order-meta-images">
                <h3><?php _e('Reference Images', 'nmdiam'); ?></h3>
                <div class="custom-order-images">
                    <?php foreach ($images as $image_id) : ?>
                        <div class="custom-order-image">
                            <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                            <a href="<?php echo esc_url(wp_get_attachment_url($image_id)); ?>" target="_blank"><?php _e('View Full Size', 'nmdiam'); ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="custom-order-meta-notes">
            <h3><?php _e('Admin Notes', 'nmdiam'); ?></h3>
            <textarea name="nmdiam_custom_order_notes" id="nmdiam_custom_order_notes" rows="5" class="widefat"><?php echo esc_textarea(get_post_meta($post->ID, '_custom_order_notes', true)); ?></textarea>
        </div>
    </div>
    <?php
}

/**
 * Save custom order meta box data
 */
function nmdiam_save_custom_order_meta($post_id) {
    if (!isset($_POST['nmdiam_custom_order_meta_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['nmdiam_custom_order_meta_nonce'], 'nmdiam_custom_order_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['nmdiam_custom_order_status'])) {
        update_post_meta($post_id, '_custom_order_status', sanitize_text_field($_POST['nmdiam_custom_order_status']));
    }
    
    if (isset($_POST['nmdiam_custom_order_notes'])) {
        update_post_meta($post_id, '_custom_order_notes', sanitize_textarea_field($_POST['nmdiam_custom_order_notes']));
    }
}
add_action('save_post_custom_order', 'nmdiam_save_custom_order_meta');

/**
 * Custom columns for custom orders
 */
function nmdiam_custom_order_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['customer'] = __('Customer', 'nmdiam');
    $new_columns['jewelry_type'] = __('Jewelry Type', 'nmdiam');
    $new_columns['status'] = __('Status', 'nmdiam');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_custom_order_posts_columns', 'nmdiam_custom_order_columns');

/**
 * Display custom order custom column data
 */
function nmdiam_custom_order_column_data($column, $post_id) {
    switch ($column) {
        case 'customer':
            $name = get_post_meta($post_id, '_custom_order_name', true);
            $email = get_post_meta($post_id, '_custom_order_email', true);
            echo $name ? esc_html($name) : __('Unknown', 'nmdiam');
            if ($email) {
                echo '<br><a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            }
            break;
        case 'jewelry_type':
            $jewelry_type = get_post_meta($post_id, '_custom_order_jewelry_type', true);
            echo $jewelry_type ? esc_html($jewelry_type) : __('Not specified', 'nmdiam');
            break;
        case 'status':
            $status = get_post_meta($post_id, '_custom_order_status', true) ?: 'new';
            $status_labels = array(
                'new' => __('New', 'nmdiam'),
                'in_progress' => __('In Progress', 'nmdiam'),
                'design_approval' => __('Design Approval', 'nmdiam'),
                'production' => __('In Production', 'nmdiam'),
                'completed' => __('Completed', 'nmdiam'),
                'delivered' => __('Delivered', 'nmdiam'),
                'cancelled' => __('Cancelled', 'nmdiam'),
            );
            
            $status_class = 'status-' . $status;
            echo '<span class="order-status ' . esc_attr($status_class) . '">' . esc_html($status_labels[$status]) . '</span>';
            break;
    }
}
add_action('manage_custom_order_posts_custom_column', 'nmdiam_custom_order_column_data', 10, 2);