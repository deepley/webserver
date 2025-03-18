<?php
/**
 * WooCommerce Compatibility File
 *
 * @package NMDIAM
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 *
 * @return void
 */
function nmdiam_woocommerce_setup() {
    add_theme_support(
        'woocommerce',
        array(
            'thumbnail_image_width' => 300,
            'single_image_width'    => 600,
            'product_grid'          => array(
                'default_rows'    => 3,
                'min_rows'        => 1,
                'default_columns' => 4,
                'min_columns'     => 1,
                'max_columns'     => 6,
            ),
        )
    );
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'nmdiam_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function nmdiam_woocommerce_scripts() {
    wp_enqueue_style('nmdiam-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), NMDIAM_VERSION);

    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';

    wp_add_inline_style('nmdiam-woocommerce-style', $inline_font);
    
    if (is_product()) {
        wp_enqueue_script('nmdiam-product', get_template_directory_uri() . '/assets/js/product.js', array('jquery'), NMDIAM_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'nmdiam_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function nmdiam_woocommerce_active_body_class($classes) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter('body_class', 'nmdiam_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function nmdiam_woocommerce_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'nmdiam_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('nmdiam_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function nmdiam_woocommerce_wrapper_before() {
        ?>
        <main id="primary" class="site-main">
            <div class="container">
                <?php nmdiam_breadcrumbs(); ?>
                
                <div class="shop-content">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'nmdiam_woocommerce_wrapper_before');

if (!function_exists('nmdiam_woocommerce_wrapper_after')) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function nmdiam_woocommerce_wrapper_after() {
        ?>
                </div><!-- .shop-content -->
            </div><!-- .container -->
        </main><!-- #main -->
        <?php
    }
}
add_action('woocommerce_after_main_content', 'nmdiam_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so:
 *
 * <?php
 * if ( function_exists( 'nmdiam_woocommerce_header_cart' ) ) {
 *     nmdiam_woocommerce_header_cart();
 * }
 * ?>
 */

if (!function_exists('nmdiam_woocommerce_cart_link_fragment')) {
    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param array $fragments Fragments to refresh via AJAX.
     * @return array Fragments to refresh via AJAX.
     */
    function nmdiam_woocommerce_cart_link_fragment($fragments) {
        ob_start();
        nmdiam_woocommerce_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'nmdiam_woocommerce_cart_link_fragment');

if (!function_exists('nmdiam_woocommerce_cart_link')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function nmdiam_woocommerce_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'nmdiam'); ?>">
            <i class="fas fa-shopping-bag"></i>
            <span class="cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
            <span class="screen-reader-text"><?php esc_html_e('View your shopping cart', 'nmdiam'); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('nmdiam_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function nmdiam_woocommerce_header_cart() {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <div class="cart-link <?php echo esc_attr($class); ?>">
            <?php nmdiam_woocommerce_cart_link(); ?>
            <div class="cart-dropdown widget_shopping_cart">
                <div class="widget_shopping_cart_content">
                    <?php
                    $instance = array(
                        'title' => '',
                    );
                    the_widget('WC_Widget_Cart', $instance);
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * Register WooCommerce shop sidebar
 */
function nmdiam_woocommerce_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Shop Sidebar', 'nmdiam'),
            'id'            => 'sidebar-shop',
            'description'   => esc_html__('Add widgets here to appear in your shop sidebar.', 'nmdiam'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'nmdiam_woocommerce_widgets_init');

/**
 * Move WooCommerce price and rating
 */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 15);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);

/**
 * Modify product loop title
 */
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'nmdiam_template_loop_product_title', 10);

if (!function_exists('nmdiam_template_loop_product_title')) {
    /**
     * Show the product title in the product loop.
     */
    function nmdiam_template_loop_product_title() {
        echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
    }
}

/**
 * Modify shop page layout
 */
if (!function_exists('nmdiam_before_shop_loop')) {
    /**
     * Add wrapper before shop loop
     */
    function nmdiam_before_shop_loop() {
        echo '<div class="products-top-bar">';
        echo '<div class="products-result-count">';
        woocommerce_result_count();
        echo '</div>';
        echo '<div class="products-ordering">';
        woocommerce_catalog_ordering();
        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_before_shop_loop', 'nmdiam_before_shop_loop', 20);

/**
 * Add quick view button to product loop
 */
function nmdiam_add_quick_view_button() {
    global $product;
    
    if ($product) {
        echo '<div class="product-actions">';
        echo '<a href="#" class="quick-view-btn" data-product-id="' . esc_attr($product->get_id()) . '">' . esc_html__('Quick View', 'nmdiam') . '</a>';
        echo '</div>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'nmdiam_add_quick_view_button', 10);

/**
 * AJAX handler for quick view
 */
function nmdiam_quick_view_ajax() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'nmdiam-nonce')) {
        wp_send_json_error(__('Security check failed.', 'nmdiam'));
    }
    
    // Check product ID
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        wp_send_json_error(__('Invalid product.', 'nmdiam'));
    }
    
    $product_id = absint($_POST['product_id']);
    $product = wc_get_product($product_id);
    
    if (!$product) {
        wp_send_json_error(__('Product not found.', 'nmdiam'));
    }
    
    ob_start();
    ?>
    <div class="quick-view-content">
        <div class="qv-product-images">
            <?php
            if (has_post_thumbnail($product_id)) {
                echo '<div class="qv-product-image">';
                echo get_the_post_thumbnail($product_id, 'medium');
                echo '</div>';
                
                $gallery_images = $product->get_gallery_image_ids();
                
                if (!empty($gallery_images)) {
                    echo '<div class="qv-product-gallery">';
                    foreach ($gallery_images as $gallery_image_id) {
                        echo '<div class="qv-gallery-item">';
                        echo wp_get_attachment_image($gallery_image_id, 'thumbnail');
                        echo '</div>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<div class="qv-product-image">';
                echo wc_placeholder_img('medium');
                echo '</div>';
            }
            ?>
        </div>
        
        <div class="qv-product-summary">
            <h2 class="qv-product-title"><?php echo esc_html($product->get_name()); ?></h2>
            
            <div class="qv-product-price">
                <?php echo $product->get_price_html(); ?>
            </div>
            
            <?php if ($product->get_average_rating()) : ?>
                <div class="qv-product-rating">
                    <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                    <?php if ($product->get_review_count()) : ?>
                        <span class="qv-review-count">(<?php echo $product->get_review_count(); ?> <?php echo _n('review', 'reviews', $product->get_review_count(), 'nmdiam'); ?>)</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="qv-product-description">
                <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
            </div>
            
            <?php if ($product->is_in_stock()) : ?>
                <?php if ($product->is_type('simple')) : ?>
                    <form class="qv-cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                        <div class="qv-quantity">
                            <?php
                            woocommerce_quantity_input(
                                array(
                                    'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                    'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                                )
                            );
                            ?>
                        </div>
                        
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="qv-add-to-cart"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
                    </form>
                <?php else : ?>
                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="qv-view-product"><?php esc_html_e('View Product', 'nmdiam'); ?></a>
                <?php endif; ?>
            <?php else : ?>
                <p class="qv-out-of-stock"><?php esc_html_e('Out of stock', 'nmdiam'); ?></p>
            <?php endif; ?>
            
            <div class="qv-product-meta">
                <?php if ($product->get_sku()) : ?>
                    <span class="qv-sku"><?php esc_html_e('SKU:', 'nmdiam'); ?> <?php echo esc_html($product->get_sku()); ?></span>
                <?php endif; ?>
                
                <?php echo wc_get_product_category_list($product->get_id(), ', ', '<span class="qv-category">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'nmdiam') . ' ', '</span>'); ?>
            </div>
            
            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="qv-view-details"><?php esc_html_e('View Full Details', 'nmdiam'); ?></a>
        </div>
    </div>
    <?php
    
    $html = ob_get_clean();
    
    wp_send_json_success($html);
}
add_action('wp_ajax_nmdiam_quick_view', 'nmdiam_quick_view_ajax');
add_action('wp_ajax_nopriv_nmdiam_quick_view', 'nmdiam_quick_view_ajax');

/**
 * Increase products per row
 */
function nmdiam_loop_columns() {
    return 4; // Set number of products per row
}
add_filter('loop_shop_columns', 'nmdiam_loop_columns');

/**
 * Related products count
 */
function nmdiam_related_products_args($args) {
    $args['posts_per_page'] = 4; // Set number of related products
    $args['columns'] = 4; // Set columns
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'nmdiam_related_products_args');

/**
 * Cross-sells products count
 */
function nmdiam_cross_sells_cols($args) {
    $args['posts_per_page'] = 4; // Set number of cross-sells
    $args['columns'] = 4; // Set columns
    return $args;
}
add_filter('woocommerce_cross_sells_columns', 'nmdiam_cross_sells_cols');
add_filter('woocommerce_cross_sells_total', function() { return 4; });

/**
 * Up-sells products count
 */
function nmdiam_upsells_cols($args) {
    $args['posts_per_page'] = 4; // Set number of up-sells
    $args['columns'] = 4; // Set columns
    return $args;
}
add_filter('woocommerce_upsell_display_args', 'nmdiam_upsells_cols');

/**
 * Modify checkout fields
 */
function nmdiam_checkout_fields($fields) {
    // Make phone number required
    $fields['billing']['billing_phone']['required'] = true;
    
    // Order fields
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_last_name']['priority'] = 20;
    $fields['billing']['billing_email']['priority'] = 30;
    $fields['billing']['billing_phone']['priority'] = 40;
    $fields['billing']['billing_company']['priority'] = 50;
    
    $fields['billing']['billing_country']['priority'] = 60;
    $fields['billing']['billing_address_1']['priority'] = 70;
    $fields['billing']['billing_address_2']['priority'] = 80;
    $fields['billing']['billing_city']['priority'] = 90;
    $fields['billing']['billing_state']['priority'] = 100;
    $fields['billing']['billing_postcode']['priority'] = 110;
    
    // Do the same for shipping fields
    $fields['shipping']['shipping_first_name']['priority'] = 10;
    $fields['shipping']['shipping_last_name']['priority'] = 20;
    $fields['shipping']['shipping_company']['priority'] = 30;
    
    $fields['shipping']['shipping_country']['priority'] = 40;
    $fields['shipping']['shipping_address_1']['priority'] = 50;
    $fields['shipping']['shipping_address_2']['priority'] = 60;
    $fields['shipping']['shipping_city']['priority'] = 70;
    $fields['shipping']['shipping_state']['priority'] = 80;
    $fields['shipping']['shipping_postcode']['priority'] = 90;
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'nmdiam_checkout_fields');

/**
 * Add custom product meta box
 */
function nmdiam_product_meta_boxes() {
    add_meta_box(
        'nmdiam_product_features',
        __('Product Features', 'nmdiam'),
        'nmdiam_product_features_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nmdiam_product_meta_boxes');

/**
 * Product features meta box callback
 */
function nmdiam_product_features_callback($post) {
    wp_nonce_field('nmdiam_product_features', 'nmdiam_product_features_nonce');
    
    $features = get_post_meta($post->ID, '_product_features', true);
    ?>
    <p>
        <label for="nmdiam_product_features"><?php _e('Enter product features, one per line', 'nmdiam'); ?></label>
        <textarea id="nmdiam_product_features" name="nmdiam_product_features" class="widefat" rows="5"><?php echo esc_textarea($features); ?></textarea>
    </p>
    <?php
}

/**
 * Save product features meta
 */
function nmdiam_save_product_features($post_id) {
    if (!isset($_POST['nmdiam_product_features_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['nmdiam_product_features_nonce'], 'nmdiam_product_features')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['nmdiam_product_features'])) {
        update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['nmdiam_product_features']));
    }
}
add_action('save_post_product', 'nmdiam_save_product_features');

/**
 * Add features to product tab
 */
function nmdiam_product_features_tab($tabs) {
    global $post;
    
    $features = get_post_meta($post->ID, '_product_features', true);
    
    if ($features) {
        $tabs['features'] = array(
            'title'    => __('Features', 'nmdiam'),
            'priority' => 15,
            'callback' => 'nmdiam_product_features_tab_content',
        );
    }
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'nmdiam_product_features_tab');

/**
 * Features tab content
 */
function nmdiam_product_features_tab_content() {
    global $post;
    
    $features = get_post_meta($post->ID, '_product_features', true);
    
    if ($features) {
        echo '<div class="product-features">';
        
        $features_array = explode("\n", $features);
        
        if (!empty($features_array)) {
            echo '<ul class="features-list">';
            
            foreach ($features_array as $feature) {
                $feature = trim($feature);
                
                if (!empty($feature)) {
                    echo '<li>' . esc_html($feature) . '</li>';
                }
            }
            
            echo '</ul>';
        }
        
        echo '</div>';
    }
}

/**
 * Display features on product page
 */
function nmdiam_product_features_display() {
    global $post;
    
    $features = get_post_meta($post->ID, '_product_features', true);
    
    if ($features) {
        echo '<div class="product-features-summary">';
        echo '<h3>' . esc_html__('Key Features', 'nmdiam') . '</h3>';
        
        $features_array = explode("\n", $features);
        $limited_features = array_slice($features_array, 0, 3);
        
        if (!empty($limited_features)) {
            echo '<ul class="features-list-summary">';
            
            foreach ($limited_features as $feature) {
                $feature = trim($feature);
                
                if (!empty($feature)) {
                    echo '<li>' . esc_html($feature) . '</li>';
                }
            }
            
            echo '</ul>';
        }
        
        if (count($features_array) > 3) {
            echo '<a href="#tab-features" class="view-all-features">' . esc_html__('View All Features', 'nmdiam') . '</a>';
        }
        
        echo '</div>';
    }
}
add_action('woocommerce_single_product_summary', 'nmdiam_product_features_display', 25);

/**
 * Custom product per page
 */
function nmdiam_products_per_page($cols) {
    return 12;
}
add_filter('loop_shop_per_page', 'nmdiam_products_per_page');