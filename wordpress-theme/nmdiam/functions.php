<?php
/**
 * NMDIAM functions and definitions
 *
 * @package NMDIAM
 */

if (!defined('NMDIAM_VERSION')) {
    // Replace the version number of the theme on each release.
    define('NMDIAM_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function nmdiam_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain('nmdiam', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');

    // Set default thumbnail size
    set_post_thumbnail_size(1200, 9999);

    // Add custom image sizes
    add_image_size('nmdiam-featured', 1200, 800, true);
    add_image_size('nmdiam-product', 600, 800, true);
    add_image_size('nmdiam-product-thumbnail', 300, 400, true);
    add_image_size('nmdiam-category', 400, 400, true);

    // This theme uses wp_nav_menu() in multiple locations.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'nmdiam'),
            'footer-1' => esc_html__('Footer 1', 'nmdiam'),
            'footer-2' => esc_html__('Footer 2', 'nmdiam'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'nmdiam_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
    
    // Add support for custom page templates
    add_theme_support('page-templates');
    
    // Add support for Woocommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'nmdiam_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nmdiam_content_width() {
    $GLOBALS['content_width'] = apply_filters('nmdiam_content_width', 1200);
}
add_action('after_setup_theme', 'nmdiam_content_width', 0);

/**
 * Register widget area.
 */
function nmdiam_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'nmdiam'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'nmdiam'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__('Shop Sidebar', 'nmdiam'),
            'id'            => 'sidebar-shop',
            'description'   => esc_html__('Add widgets here for WooCommerce shop pages.', 'nmdiam'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'nmdiam_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function nmdiam_scripts() {
    // Register and enqueue styles
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap', array(), null);
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4');
    
    if (function_exists('is_product') && (is_product() || is_shop() || is_product_category() || is_home())) {
        wp_enqueue_style('swiper', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), '7.0.0');
    }
    
    wp_enqueue_style('nmdiam-style', get_stylesheet_uri(), array(), NMDIAM_VERSION);
    
    // Register and enqueue scripts
    wp_enqueue_script('nmdiam-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), NMDIAM_VERSION, true);
    
    if (function_exists('is_product') && (is_product() || is_shop() || is_product_category() || is_home())) {
        wp_enqueue_script('swiper', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), '7.0.0', true);
    }
    
    wp_enqueue_script('nmdiam-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), NMDIAM_VERSION, true);
    
    // Localize script
    wp_localize_script('nmdiam-main', 'nmdiam_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nmdiam-nonce'),
        'newsletter_ajax' => get_theme_mod('nmdiam_newsletter_ajax', '1'),
        'subscribe_text' => esc_html__('Subscribe', 'nmdiam'),
        'email_required' => esc_html__('Please enter your email address.', 'nmdiam'),
        'ajax_error' => esc_html__('Something went wrong. Please try again.', 'nmdiam'),
        'custom_order_success_title' => esc_html__('Request Submitted', 'nmdiam'),
        'custom_order_success_message' => esc_html__('Thank you for your custom jewelry request. We will contact you shortly to discuss the details.', 'nmdiam'),
    ));
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'nmdiam_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom Post Types.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Shortcodes.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * AJAX Handlers.
 */
require get_template_directory() . '/inc/ajax-handlers.php';

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 */
function nmdiam_remove_wp_block_library_css() {
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
    }
}
add_action('wp_enqueue_scripts', 'nmdiam_remove_wp_block_library_css', 100);

/**
 * Disable the emoji's
 */
function nmdiam_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove the tinymce emoji plugin
    add_filter('tiny_mce_plugins', 'nmdiam_disable_emojis_tinymce');
}
add_action('init', 'nmdiam_disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin
 */
function nmdiam_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    
    return $plugins;
}

/**
 * Add preload to google fonts
 */
function nmdiam_preload_fonts() {
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" as="style">';
}
add_action('wp_head', 'nmdiam_preload_fonts', 1);

/**
 * Add custom body classes
 */
function nmdiam_body_classes($classes) {
    // Add page slug as class
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1') && !is_page() && !is_front_page()) {
        $classes[] = 'has-sidebar';
    }
    
    return $classes;
}
add_filter('body_class', 'nmdiam_body_classes');

/**
 * Change excerpt length
 */
function nmdiam_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'nmdiam_excerpt_length');

/**
 * Change excerpt more string
 */
function nmdiam_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'nmdiam_excerpt_more');

/**
 * Add Responsive Image Class to Post Thumbnails
 */
function nmdiam_post_thumbnail_class($html) {
    $html = str_replace('class="', 'class="img-fluid ', $html);
    return $html;
}
add_filter('post_thumbnail_html', 'nmdiam_post_thumbnail_class');

/**
 * SVG Upload Support
 */
function nmdiam_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'nmdiam_mime_types');

/**
 * Register custom query vars
 */
function nmdiam_register_query_vars($vars) {
    $vars[] = 'product_cat';
    $vars[] = 'product_tag';
    return $vars;
}
add_filter('query_vars', 'nmdiam_register_query_vars');

/**
 * Handler for newsletter signup
 */
function nmdiam_newsletter_signup() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'nmdiam-nonce')) {
        wp_send_json_error(__('Security check failed.', 'nmdiam'));
    }
    
    // Check if email is provided
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        wp_send_json_error(__('Please provide a valid email address.', 'nmdiam'));
    }
    
    $email = sanitize_email($_POST['email']);
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(__('Please provide a valid email address.', 'nmdiam'));
    }
    
    // Store the email in the database
    $subscription_data = array(
        'post_title'  => $email,
        'post_status' => 'publish',
        'post_type'   => 'subscription',
    );
    
    $subscription_id = wp_insert_post($subscription_data);
    
    if ($subscription_id) {
        // Send confirmation email if enabled
        if (get_theme_mod('nmdiam_send_confirmation_email', true)) {
            $to = $email;
            $subject = get_theme_mod('nmdiam_confirmation_email_subject', __('Thank you for subscribing!', 'nmdiam'));
            $message = get_theme_mod('nmdiam_confirmation_email_message', __('Thank you for subscribing to our newsletter. We\'ll keep you updated with our latest products and offers.', 'nmdiam'));
            
            wp_mail($to, $subject, $message);
        }
        
        // Send notification email to admin
        if (get_theme_mod('nmdiam_send_admin_notification', true)) {
            $admin_email = get_option('admin_email');
            $subject = __('New Newsletter Subscription', 'nmdiam');
            $message = sprintf(__('New subscriber: %s', 'nmdiam'), $email);
            
            wp_mail($admin_email, $subject, $message);
        }
        
        wp_send_json_success(__('Thank you for subscribing to our newsletter!', 'nmdiam'));
    } else {
        wp_send_json_error(__('An error occurred. Please try again.', 'nmdiam'));
    }
}
add_action('wp_ajax_nmdiam_newsletter_signup', 'nmdiam_newsletter_signup');
add_action('wp_ajax_nopriv_nmdiam_newsletter_signup', 'nmdiam_newsletter_signup');

/**
 * Handler for custom order form submission
 */
function nmdiam_submit_custom_order() {
    // Verify nonce
    if (!isset($_POST['nmdiam_custom_order_nonce']) || !wp_verify_nonce($_POST['nmdiam_custom_order_nonce'], 'nmdiam_custom_order_nonce')) {
        wp_send_json_error(__('Security check failed.', 'nmdiam'));
    }
    
    // Validate required fields
    $required_fields = array('name', 'email', 'jewelry_type', 'description');
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            wp_send_json_error(sprintf(__('Please fill in the %s field.', 'nmdiam'), $field));
        }
    }
    
    // Validate email
    if (!is_email($_POST['email'])) {
        wp_send_json_error(__('Please provide a valid email address.', 'nmdiam'));
    }
    
    // Check terms agreement
    if (!isset($_POST['terms']) || $_POST['terms'] !== 'on') {
        wp_send_json_error(__('Please agree to the terms and conditions.', 'nmdiam'));
    }
    
    // Prepare custom order data
    $order_data = array(
        'post_title'  => sanitize_text_field($_POST['name']) . ' - ' . sanitize_text_field($_POST['jewelry_type']),
        'post_content'=> sanitize_textarea_field($_POST['description']),
        'post_status' => 'publish',
        'post_type'   => 'custom_order',
    );
    
    // Insert custom order
    $order_id = wp_insert_post($order_data);
    
    if ($order_id) {
        // Save meta data
        update_post_meta($order_id, '_custom_order_name', sanitize_text_field($_POST['name']));
        update_post_meta($order_id, '_custom_order_email', sanitize_email($_POST['email']));
        
        if (isset($_POST['phone'])) {
            update_post_meta($order_id, '_custom_order_phone', sanitize_text_field($_POST['phone']));
        }
        
        update_post_meta($order_id, '_custom_order_jewelry_type', sanitize_text_field($_POST['jewelry_type']));
        
        if (isset($_POST['metal_preference'])) {
            update_post_meta($order_id, '_custom_order_metal', sanitize_text_field($_POST['metal_preference']));
        }
        
        if (isset($_POST['gemstone_preference'])) {
            update_post_meta($order_id, '_custom_order_gemstone', sanitize_text_field($_POST['gemstone_preference']));
        }
        
        if (isset($_POST['budget'])) {
            update_post_meta($order_id, '_custom_order_budget', sanitize_text_field($_POST['budget']));
        }
        
        if (isset($_POST['deadline'])) {
            update_post_meta($order_id, '_custom_order_deadline', sanitize_text_field($_POST['deadline']));
        }
        
        // Handle file uploads
        if (!empty($_FILES['reference_images']) && !empty($_FILES['reference_images']['name'][0])) {
            $uploaded_files = array();
            
            // Include required files for media handling
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            foreach ($_FILES['reference_images']['name'] as $key => $value) {
                if ($_FILES['reference_images']['name'][$key]) {
                    $file = array(
                        'name'     => $_FILES['reference_images']['name'][$key],
                        'type'     => $_FILES['reference_images']['type'][$key],
                        'tmp_name' => $_FILES['reference_images']['tmp_name'][$key],
                        'error'    => $_FILES['reference_images']['error'][$key],
                        'size'     => $_FILES['reference_images']['size'][$key]
                    );
                    
                    $_FILES = array('reference_image' => $file);
                    
                    $attachment_id = media_handle_upload('reference_image', $order_id);
                    
                    if (!is_wp_error($attachment_id)) {
                        $uploaded_files[] = $attachment_id;
                    }
                }
            }
            
            if (!empty($uploaded_files)) {
                update_post_meta($order_id, '_custom_order_images', $uploaded_files);
            }
        }
        
        // Send notification email
        $admin_email = get_option('admin_email');
        $subject = __('New Custom Jewelry Order Request', 'nmdiam');
        $message = sprintf(
            __("Name: %s\nEmail: %s\nPhone: %s\nJewelry Type: %s\nMetal Preference: %s\nGemstone: %s\nBudget: %s\nDeadline: %s\n\nDescription:\n%s", 'nmdiam'),
            sanitize_text_field($_POST['name']),
            sanitize_email($_POST['email']),
            isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : __('Not provided', 'nmdiam'),
            sanitize_text_field($_POST['jewelry_type']),
            isset($_POST['metal_preference']) ? sanitize_text_field($_POST['metal_preference']) : __('Not specified', 'nmdiam'),
            isset($_POST['gemstone_preference']) ? sanitize_text_field($_POST['gemstone_preference']) : __('Not specified', 'nmdiam'),
            isset($_POST['budget']) ? sanitize_text_field($_POST['budget']) : __('Not specified', 'nmdiam'),
            isset($_POST['deadline']) ? sanitize_text_field($_POST['deadline']) : __('Not specified', 'nmdiam'),
            sanitize_textarea_field($_POST['description'])
        );
        
        wp_mail($admin_email, $subject, $message);
        
        // Send confirmation email to customer
        if (get_theme_mod('nmdiam_send_custom_order_confirmation', true)) {
            $to = sanitize_email($_POST['email']);
            $subject = get_theme_mod('nmdiam_custom_order_email_subject', __('Your Custom Jewelry Request', 'nmdiam'));
            $message = get_theme_mod('nmdiam_custom_order_email_message', __("Thank you for your custom jewelry request. We have received your inquiry and will contact you shortly to discuss the details.\n\nBest regards,\nNMDIAM Team", 'nmdiam'));
            
            wp_mail($to, $subject, $message);
        }
        
        wp_send_json_success(__('Thank you for your custom jewelry request. We will contact you shortly.', 'nmdiam'));
    } else {
        wp_send_json_error(__('An error occurred. Please try again.', 'nmdiam'));
    }
}
add_action('wp_ajax_nmdiam_submit_custom_order', 'nmdiam_submit_custom_order');
add_action('wp_ajax_nopriv_nmdiam_submit_custom_order', 'nmdiam_submit_custom_order');