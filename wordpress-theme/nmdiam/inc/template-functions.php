<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package NMDIAM
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function nmdiam_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    } else {
        $classes[] = 'has-sidebar';
    }

    // Add a class if shop sidebar is present
    if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) {
        if (is_active_sidebar('sidebar-shop')) {
            $classes[] = 'shop-has-sidebar';
        } else {
            $classes[] = 'shop-no-sidebar';
        }
    }

    return $classes;
}
add_filter('body_class', 'nmdiam_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function nmdiam_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'nmdiam_pingback_header');

/**
 * Format price to display currency symbol
 * 
 * @param float $price The price to format
 * @return string Formatted price
 */
function nmdiam_format_price($price) {
    if (function_exists('wc_price')) {
        return wc_price($price);
    }
    
    // Fallback if WooCommerce is not active
    $currency_symbol = '$';
    return $currency_symbol . number_format($price, 2);
}

/**
 * Get limited excerpt
 * 
 * @param int $limit Character limit
 * @return string Limited excerpt
 */
function nmdiam_get_limited_excerpt($limit = 150) {
    $excerpt = get_the_excerpt();
    if (strlen($excerpt) > $limit) {
        $excerpt = substr($excerpt, 0, $limit) . '...';
    }
    return $excerpt;
}

/**
 * Get post featured image URL
 * 
 * @param int $post_id Post ID
 * @param string $size Image size
 * @return string|false URL for the featured image, or false if no image is available
 */
function nmdiam_get_featured_image_url($post_id = null, $size = 'full') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    if (has_post_thumbnail($post_id)) {
        $image_url = get_the_post_thumbnail_url($post_id, $size);
        return $image_url;
    }
    
    return false;
}

/**
 * Get all product categories
 * 
 * @param array $args Additional arguments for get_terms
 * @return array Categories
 */
function nmdiam_get_product_categories($args = array()) {
    $defaults = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
        'number' => 4,
        'exclude' => get_option('default_product_cat'),
    );
    
    $args = wp_parse_args($args, $defaults);
    
    if (taxonomy_exists('product_cat')) {
        $categories = get_terms($args);
        
        if (!empty($categories) && !is_wp_error($categories)) {
            return $categories;
        }
    }
    
    // Fallback if WooCommerce not active or no categories
    return array();
}

/**
 * Get category image URL
 * 
 * @param int $category_id Category ID
 * @param string $size Image size
 * @return string URL for the category image
 */
function nmdiam_get_category_image_url($category_id, $size = 'full') {
    $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
    
    if ($thumbnail_id) {
        $image = wp_get_attachment_image_src($thumbnail_id, $size);
        if ($image) {
            return $image[0];
        }
    }
    
    // Fallback image
    return get_template_directory_uri() . '/assets/images/category-default.jpg';
}

/**
 * Get featured products
 * 
 * @param int $limit Number of products to retrieve
 * @return array Products
 */
function nmdiam_get_featured_products($limit = 8) {
    if (function_exists('wc_get_products')) {
        $args = array(
            'limit' => $limit,
            'featured' => true,
            'status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        $products = wc_get_products($args);
        
        if (!empty($products)) {
            return $products;
        }
    }
    
    // Fallback if WooCommerce not active or no products
    return array();
}

/**
 * Get recent products
 * 
 * @param int $limit Number of products to retrieve
 * @return array Products
 */
function nmdiam_get_recent_products($limit = 8) {
    if (function_exists('wc_get_products')) {
        $args = array(
            'limit' => $limit,
            'status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        $products = wc_get_products($args);
        
        if (!empty($products)) {
            return $products;
        }
    }
    
    // Fallback if WooCommerce not active or no products
    return array();
}

/**
 * Get product price HTML
 * 
 * @param int $product_id Product ID
 * @return string Price HTML
 */
function nmdiam_get_product_price_html($product_id) {
    if (function_exists('wc_get_product')) {
        $product = wc_get_product($product_id);
        
        if ($product) {
            return $product->get_price_html();
        }
    }
    
    // Fallback
    return '';
}

/**
 * Get testimonials
 * 
 * @param int $limit Number of testimonials to retrieve
 * @return WP_Query Testimonials query
 */
function nmdiam_get_testimonials($limit = 6) {
    $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $testimonials = new WP_Query($args);
    
    return $testimonials;
}

/**
 * Get testimonial rating stars HTML
 * 
 * @param int $post_id Testimonial post ID
 * @return string HTML output for rating stars
 */
function nmdiam_get_testimonial_rating_html($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $rating = get_post_meta($post_id, '_testimonial_rating', true);
    
    if (!$rating) {
        return '';
    }
    
    $html = '<div class="testimonial-rating">';
    
    // Add filled stars
    for ($i = 1; $i <= $rating; $i++) {
        $html .= '<i class="fas fa-star"></i>';
    }
    
    // Add empty stars
    for ($i = $rating + 1; $i <= 5; $i++) {
        $html .= '<i class="far fa-star"></i>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Display breadcrumbs
 * 
 * @return void
 */
function nmdiam_breadcrumbs() {
    if (function_exists('woocommerce_breadcrumb') && (is_woocommerce() || is_cart() || is_checkout())) {
        woocommerce_breadcrumb(array(
            'delimiter' => '<span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>',
            'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs" itemprop="breadcrumb">',
            'wrap_after' => '</nav>',
            'home' => __('Home', 'nmdiam'),
        ));
        return;
    }
    
    // Standard breadcrumbs for non-WooCommerce pages
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="breadcrumbs" itemprop="breadcrumb">';
    
    echo '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'nmdiam') . '</a>';
    echo '<span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>';
    
    if (is_category() || is_single()) {
        if (is_single()) {
            if (get_post_type() !== 'post') {
                $post_type = get_post_type_object(get_post_type());
                echo '<a href="' . esc_url(get_post_type_archive_link(get_post_type())) . '">' . esc_html($post_type->labels->name) . '</a>';
                echo '<span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>';
            } else {
                the_category(' <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span> ');
                echo '<span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>';
            }
            the_title();
        } elseif (is_category()) {
            single_cat_title();
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $ancestors = array_reverse($ancestors);
            
            foreach ($ancestors as $ancestor) {
                echo '<a href="' . esc_url(get_permalink($ancestor)) . '">' . get_the_title($ancestor) . '</a>';
                echo '<span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>';
            }
        }
        
        the_title();
    } elseif (is_search()) {
        echo __('Search Results for: ', 'nmdiam') . get_search_query();
    } elseif (is_404()) {
        echo __('404 - Page Not Found', 'nmdiam');
    } elseif (is_archive()) {
        if (is_day()) {
            echo __('Archives for: ', 'nmdiam') . get_the_date();
        } elseif (is_month()) {
            echo __('Archives for: ', 'nmdiam') . get_the_date('F Y');
        } elseif (is_year()) {
            echo __('Archives for: ', 'nmdiam') . get_the_date('Y');
        } else {
            echo __('Archives', 'nmdiam');
        }
    }
    
    echo '</nav>';
}

/**
 * Get related products
 * 
 * @param int $product_id Product ID
 * @param int $limit Number of products to retrieve
 * @return array Products
 */
function nmdiam_get_related_products($product_id, $limit = 4) {
    if (function_exists('wc_get_product') && function_exists('wc_get_related_products')) {
        $product = wc_get_product($product_id);
        
        if ($product) {
            $related_products_ids = wc_get_related_products($product_id, $limit);
            
            if (!empty($related_products_ids)) {
                $related_products = array();
                
                foreach ($related_products_ids as $product_id) {
                    $related_product = wc_get_product($product_id);
                    
                    if ($related_product) {
                        $related_products[] = $related_product;
                    }
                }
                
                return $related_products;
            }
        }
    }
    
    // Fallback
    return array();
}

/**
 * Get product gallery images
 * 
 * @param int $product_id Product ID
 * @return array Gallery images
 */
function nmdiam_get_product_gallery_images($product_id) {
    if (function_exists('wc_get_product')) {
        $product = wc_get_product($product_id);
        
        if ($product) {
            $attachment_ids = $product->get_gallery_image_ids();
            
            if (!empty($attachment_ids)) {
                $gallery_images = array();
                
                foreach ($attachment_ids as $attachment_id) {
                    $gallery_images[] = array(
                        'id' => $attachment_id,
                        'url' => wp_get_attachment_url($attachment_id),
                        'thumbnail' => wp_get_attachment_image_url($attachment_id, 'thumbnail'),
                        'full' => wp_get_attachment_image_url($attachment_id, 'full'),
                    );
                }
                
                return $gallery_images;
            }
        }
    }
    
    // Fallback
    return array();
}

/**
 * Add custom query vars
 * 
 * @param array $vars Query vars
 * @return array Modified query vars
 */
function nmdiam_add_query_vars($vars) {
    $vars[] = 'filter_jewelry_type';
    $vars[] = 'filter_price';
    $vars[] = 'filter_metal';
    $vars[] = 'filter_gemstone';
    $vars[] = 'sort_by';
    
    return $vars;
}
add_filter('query_vars', 'nmdiam_add_query_vars');

/**
 * Search products by SKU
 * 
 * @param WP_Query $query WP Query object
 * @return WP_Query Modified query
 */
function nmdiam_search_by_sku($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_search() || !function_exists('wc_get_product')) {
        return $query;
    }
    
    global $wpdb;
    
    $search_term = $query->get('s');
    
    if (!$search_term) {
        return $query;
    }
    
    // Search for products with matching SKU
    $sku_to_parent_id = $wpdb->get_col($wpdb->prepare("
        SELECT p.post_id FROM {$wpdb->postmeta} p
        WHERE p.meta_key='_sku' AND p.meta_value LIKE %s
    ", '%' . $wpdb->esc_like($search_term) . '%'));
    
    if (empty($sku_to_parent_id)) {
        return $query;
    }
    
    // Get product IDs
    $product_ids = array();
    
    foreach ($sku_to_parent_id as $post_id) {
        $product_ids[] = $post_id;
        
        $product = wc_get_product($post_id);
        
        if ($product && $product->is_type('variable')) {
            $product_ids[] = $product->get_id();
        }
    }
    
    // Add SKU search results to regular search results
    $post_in = $query->get('post__in');
    
    if (!empty($post_in)) {
        $post_in = array_merge($post_in, $product_ids);
    } else {
        $post_in = $product_ids;
    }
    
    // Update the query
    $query->set('post__in', $post_in);
    $query->set('s', '');
    
    return $query;
}
add_filter('pre_get_posts', 'nmdiam_search_by_sku');

/**
 * Add product data to REST API
 */
function nmdiam_add_product_data_to_rest_api() {
    if (!function_exists('register_rest_field') || !function_exists('wc_get_product')) {
        return;
    }
    
    register_rest_field('product', 'price_html', array(
        'get_callback' => function($post) {
            $product = wc_get_product($post['id']);
            return $product ? $product->get_price_html() : '';
        },
        'schema' => array(
            'description' => __('Formatted product price', 'nmdiam'),
            'type' => 'string',
        ),
    ));
    
    register_rest_field('product', 'average_rating', array(
        'get_callback' => function($post) {
            $product = wc_get_product($post['id']);
            return $product ? $product->get_average_rating() : 0;
        },
        'schema' => array(
            'description' => __('Average product rating', 'nmdiam'),
            'type' => 'number',
        ),
    ));
    
    register_rest_field('product', 'features', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], '_product_features', true);
        },
        'schema' => array(
            'description' => __('Product features', 'nmdiam'),
            'type' => 'string',
        ),
    ));
}
add_action('rest_api_init', 'nmdiam_add_product_data_to_rest_api');