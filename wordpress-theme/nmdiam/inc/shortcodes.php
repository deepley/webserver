<?php
/**
 * Custom shortcodes for NMDIAM theme
 *
 * @package NMDIAM
 */

/**
 * Testimonials Shortcode
 * Usage: [testimonials count="3"]
 */
function nmdiam_testimonials_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'count' => 3,
        ),
        $atts,
        'testimonials'
    );
    
    $count = intval($atts['count']);
    
    // Query testimonials
    $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $testimonials = new WP_Query($args);
    
    ob_start();
    
    if ($testimonials->have_posts()) :
        ?>
        <div class="testimonials-slider">
            <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="testimonial-author">
                        <?php the_title(); ?>
                        <?php if (get_post_meta(get_the_ID(), '_testimonial_location', true)) : ?>
                            <span><?php echo esc_html(get_post_meta(get_the_ID(), '_testimonial_location', true)); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
    else :
        ?>
        <div class="testimonials-placeholder">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p><?php esc_html_e('The craftsmanship is exceptional! My custom-designed ring exceeded all expectations. Every time I wear it, I receive countless compliments.', 'nmdiam'); ?></p>
                </div>
                <div class="testimonial-author">
                    <?php esc_html_e('Sarah Johnson', 'nmdiam'); ?>
                    <span><?php esc_html_e('New York', 'nmdiam'); ?></span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p><?php esc_html_e('I purchased a necklace for my wife\'s anniversary and she absolutely loves it. The attention to detail and quality is outstanding. Will definitely be coming back!', 'nmdiam'); ?></p>
                </div>
                <div class="testimonial-author">
                    <?php esc_html_e('Michael Chen', 'nmdiam'); ?>
                    <span><?php esc_html_e('Chicago', 'nmdiam'); ?></span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p><?php esc_html_e('The pearl earrings I ordered are stunning! The customer service was impeccable from start to finish. Highly recommended for quality jewelry.', 'nmdiam'); ?></p>
                </div>
                <div class="testimonial-author">
                    <?php esc_html_e('Emily Rodriguez', 'nmdiam'); ?>
                    <span><?php esc_html_e('Miami', 'nmdiam'); ?></span>
                </div>
            </div>
        </div>
        <?php
    endif;
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('testimonials', 'nmdiam_testimonials_shortcode');

/**
 * Custom Order Form Shortcode
 * Usage: [custom_order_form]
 */
function nmdiam_custom_order_form_shortcode() {
    ob_start();
    
    // Check if form is submitted
    $form_submitted = false;
    $form_error = false;
    
    if (isset($_POST['nmdiam_custom_order_submit'])) {
        // Validate fields
        $required_fields = array('name', 'email', 'phone', 'jewelry_type', 'budget', 'timeline', 'description');
        $form_data = array();
        $validation_errors = array();
        
        foreach ($required_fields as $field) {
            if (empty($_POST['nmdiam_' . $field])) {
                $validation_errors[] = sprintf(__('Please enter your %s', 'nmdiam'), str_replace('_', ' ', $field));
            } else {
                $form_data[$field] = sanitize_text_field($_POST['nmdiam_' . $field]);
            }
        }
        
        // Additional non-required fields
        $optional_fields = array('materials', 'gemstones', 'inspiration_images');
        foreach ($optional_fields as $field) {
            $form_data[$field] = !empty($_POST['nmdiam_' . $field]) ? sanitize_text_field($_POST['nmdiam_' . $field]) : '';
        }
        
        // If no errors, process the form
        if (empty($validation_errors)) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'nmdiam_custom_orders';
            
            $result = $wpdb->insert(
                $table_name,
                array(
                    'name' => $form_data['name'],
                    'email' => $form_data['email'],
                    'phone' => $form_data['phone'],
                    'jewelry_type' => $form_data['jewelry_type'],
                    'budget' => $form_data['budget'],
                    'timeline' => $form_data['timeline'],
                    'description' => $form_data['description'],
                    'materials' => $form_data['materials'],
                    'gemstones' => $form_data['gemstones'],
                    'inspiration_images' => $form_data['inspiration_images'],
                    'created_at' => current_time('mysql')
                )
            );
            
            if ($result) {
                $form_submitted = true;
                
                // Send email notification
                $to = get_option('admin_email');
                $subject = __('New Custom Jewelry Order', 'nmdiam');
                $message = sprintf(
                    __('Name: %1$s
Email: %2$s
Phone: %3$s
Jewelry Type: %4$s
Budget: %5$s
Timeline: %6$s
Description: %7$s', 'nmdiam'),
                    $form_data['name'],
                    $form_data['email'],
                    $form_data['phone'],
                    $form_data['jewelry_type'],
                    $form_data['budget'],
                    $form_data['timeline'],
                    $form_data['description']
                );
                
                wp_mail($to, $subject, $message);
            } else {
                $form_error = true;
            }
        }
    }
    
    // Display success message or form
    if ($form_submitted) {
        ?>
        <div class="form-success">
            <h3><?php esc_html_e('Thank You!', 'nmdiam'); ?></h3>
            <p><?php esc_html_e('Your custom order request has been submitted successfully. Our design team will contact you within 24-48 hours to discuss your vision.', 'nmdiam'); ?></p>
        </div>
        <?php
    } elseif ($form_error) {
        ?>
        <div class="form-error">
            <p><?php esc_html_e('There was an error submitting your custom order. Please try again or contact us directly.', 'nmdiam'); ?></p>
        </div>
        <?php
    } else {
        // Display validation errors if any
        if (!empty($validation_errors)) {
            echo '<div class="form-errors">';
            echo '<ul>';
            foreach ($validation_errors as $error) {
                echo '<li>' . esc_html($error) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
        <form method="post" class="custom-order-form">
            <div class="form-group">
                <label for="nmdiam_name"><?php esc_html_e('Full Name', 'nmdiam'); ?> <span class="required">*</span></label>
                <input type="text" id="nmdiam_name" name="nmdiam_name" required value="<?php echo isset($_POST['nmdiam_name']) ? esc_attr($_POST['nmdiam_name']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="nmdiam_email"><?php esc_html_e('Email Address', 'nmdiam'); ?> <span class="required">*</span></label>
                <input type="email" id="nmdiam_email" name="nmdiam_email" required value="<?php echo isset($_POST['nmdiam_email']) ? esc_attr($_POST['nmdiam_email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="nmdiam_phone"><?php esc_html_e('Phone Number', 'nmdiam'); ?> <span class="required">*</span></label>
                <input type="tel" id="nmdiam_phone" name="nmdiam_phone" required value="<?php echo isset($_POST['nmdiam_phone']) ? esc_attr($_POST['nmdiam_phone']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="nmdiam_jewelry_type"><?php esc_html_e('Jewelry Type', 'nmdiam'); ?> <span class="required">*</span></label>
                <select id="nmdiam_jewelry_type" name="nmdiam_jewelry_type" required>
                    <option value=""><?php esc_html_e('Select Type', 'nmdiam'); ?></option>
                    <option value="ring" <?php selected(isset($_POST['nmdiam_jewelry_type']) && $_POST['nmdiam_jewelry_type'] == 'ring'); ?>><?php esc_html_e('Ring', 'nmdiam'); ?></option>
                    <option value="necklace" <?php selected(isset($_POST['nmdiam_jewelry_type']) && $_POST['nmdiam_jewelry_type'] == 'necklace'); ?>><?php esc_html_e('Necklace', 'nmdiam'); ?></option>
                    <option value="bracelet" <?php selected(isset($_POST['nmdiam_jewelry_type']) && $_POST['nmdiam_jewelry_type'] == 'bracelet'); ?>><?php esc_html_e('Bracelet', 'nmdiam'); ?></option>
                    <option value="earrings" <?php selected(isset($_POST['nmdiam_jewelry_type']) && $_POST['nmdiam_jewelry_type'] == 'earrings'); ?>><?php esc_html_e('Earrings', 'nmdiam'); ?></option>
                    <option value="other" <?php selected(isset($_POST['nmdiam_jewelry_type']) && $_POST['nmdiam_jewelry_type'] == 'other'); ?>><?php esc_html_e('Other', 'nmdiam'); ?></option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="nmdiam_budget"><?php esc_html_e('Budget Range', 'nmdiam'); ?> <span class="required">*</span></label>
                <select id="nmdiam_budget" name="nmdiam_budget" required>
                    <option value=""><?php esc_html_e('Select Budget', 'nmdiam'); ?></option>
                    <option value="under-1000" <?php selected(isset($_POST['nmdiam_budget']) && $_POST['nmdiam_budget'] == 'under-1000'); ?>><?php esc_html_e('Under $1,000', 'nmdiam'); ?></option>
                    <option value="1000-3000" <?php selected(isset($_POST['nmdiam_budget']) && $_POST['nmdiam_budget'] == '1000-3000'); ?>><?php esc_html_e('$1,000 - $3,000', 'nmdiam'); ?></option>
                    <option value="3000-5000" <?php selected(isset($_POST['nmdiam_budget']) && $_POST['nmdiam_budget'] == '3000-5000'); ?>><?php esc_html_e('$3,000 - $5,000', 'nmdiam'); ?></option>
                    <option value="5000-10000" <?php selected(isset($_POST['nmdiam_budget']) && $_POST['nmdiam_budget'] == '5000-10000'); ?>><?php esc_html_e('$5,000 - $10,000', 'nmdiam'); ?></option>
                    <option value="above-10000" <?php selected(isset($_POST['nmdiam_budget']) && $_POST['nmdiam_budget'] == 'above-10000'); ?>><?php esc_html_e('Above $10,000', 'nmdiam'); ?></option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="nmdiam_timeline"><?php esc_html_e('Timeline', 'nmdiam'); ?> <span class="required">*</span></label>
                <select id="nmdiam_timeline" name="nmdiam_timeline" required>
                    <option value=""><?php esc_html_e('Select Timeline', 'nmdiam'); ?></option>
                    <option value="1-month" <?php selected(isset($_POST['nmdiam_timeline']) && $_POST['nmdiam_timeline'] == '1-month'); ?>><?php esc_html_e('Within 1 month', 'nmdiam'); ?></option>
                    <option value="1-3-months" <?php selected(isset($_POST['nmdiam_timeline']) && $_POST['nmdiam_timeline'] == '1-3-months'); ?>><?php esc_html_e('1-3 months', 'nmdiam'); ?></option>
                    <option value="3-6-months" <?php selected(isset($_POST['nmdiam_timeline']) && $_POST['nmdiam_timeline'] == '3-6-months'); ?>><?php esc_html_e('3-6 months', 'nmdiam'); ?></option>
                    <option value="6-plus-months" <?php selected(isset($_POST['nmdiam_timeline']) && $_POST['nmdiam_timeline'] == '6-plus-months'); ?>><?php esc_html_e('6+ months', 'nmdiam'); ?></option>
                </select>
            </div>
            
            <div class="form-group full-width">
                <label for="nmdiam_description"><?php esc_html_e('Design Description', 'nmdiam'); ?> <span class="required">*</span></label>
                <textarea id="nmdiam_description" name="nmdiam_description" rows="5" required><?php echo isset($_POST['nmdiam_description']) ? esc_textarea($_POST['nmdiam_description']) : ''; ?></textarea>
                <small><?php esc_html_e('Please describe your vision in detail. Include any specific elements, style preferences, or symbolic meanings you want incorporated.', 'nmdiam'); ?></small>
            </div>
            
            <div class="form-group">
                <label for="nmdiam_materials"><?php esc_html_e('Preferred Materials', 'nmdiam'); ?></label>
                <input type="text" id="nmdiam_materials" name="nmdiam_materials" value="<?php echo isset($_POST['nmdiam_materials']) ? esc_attr($_POST['nmdiam_materials']) : ''; ?>">
                <small><?php esc_html_e('E.g., White gold, Yellow gold, Platinum, etc.', 'nmdiam'); ?></small>
            </div>
            
            <div class="form-group">
                <label for="nmdiam_gemstones"><?php esc_html_e('Preferred Gemstones', 'nmdiam'); ?></label>
                <input type="text" id="nmdiam_gemstones" name="nmdiam_gemstones" value="<?php echo isset($_POST['nmdiam_gemstones']) ? esc_attr($_POST['nmdiam_gemstones']) : ''; ?>">
                <small><?php esc_html_e('E.g., Diamonds, Sapphires, Emeralds, etc.', 'nmdiam'); ?></small>
            </div>
            
            <div class="form-group full-width">
                <label for="nmdiam_inspiration_images"><?php esc_html_e('Inspiration Images', 'nmdiam'); ?></label>
                <input type="text" id="nmdiam_inspiration_images" name="nmdiam_inspiration_images" value="<?php echo isset($_POST['nmdiam_inspiration_images']) ? esc_attr($_POST['nmdiam_inspiration_images']) : ''; ?>">
                <small><?php esc_html_e('Please provide links to any inspiration images or references you have.', 'nmdiam'); ?></small>
            </div>
            
            <div class="form-group full-width">
                <button type="submit" name="nmdiam_custom_order_submit" class="btn btn-primary"><?php esc_html_e('Submit Custom Order Request', 'nmdiam'); ?></button>
            </div>
        </form>
        <?php
    }
    
    return ob_get_clean();
}
add_shortcode('custom_order_form', 'nmdiam_custom_order_form_shortcode');

/**
 * Featured Products Shortcode
 * Usage: [featured_products count="4"]
 */
function nmdiam_featured_products_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'count' => 4,
        ),
        $atts,
        'featured_products'
    );
    
    $count = intval($atts['count']);
    
    ob_start();
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $count,
        'meta_key' => '_featured',
        'meta_value' => 'yes',
    );
    
    $featured_products = new WP_Query($args);
    
    if ($featured_products->have_posts()) :
        ?>
        <div class="products-grid">
            <?php while ($featured_products->have_posts()) : $featured_products->the_post();
                global $product;
                ?>
                <div class="product-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('woocommerce_thumbnail', array('class' => 'product-card-image')); ?>
                        <?php endif; ?>
                        <div class="product-card-content">
                            <h3 class="product-title"><?php the_title(); ?></h3>
                            <div class="product-price"><?php echo $product->get_price_html(); ?></div>
                            <span class="btn btn-primary add-to-cart-btn"><?php esc_html_e('Add to Cart', 'nmdiam'); ?></span>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
    else :
        echo '<p>' . esc_html__('No featured products found', 'nmdiam') . '</p>';
    endif;
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('featured_products', 'nmdiam_featured_products_shortcode');

/**
 * Categories Grid Shortcode
 * Usage: [product_categories count="4"]
 */
function nmdiam_product_categories_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'count' => 4,
        ),
        $atts,
        'product_categories'
    );
    
    $count = intval($atts['count']);
    
    ob_start();
    
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'exclude' => array(get_option('default_product_cat')),
        'number' => $count
    ));
    
    if (!empty($categories) && !is_wp_error($categories)) :
        ?>
        <div class="categories-grid">
            <?php foreach ($categories as $category) :
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card">
                    <?php if ($image) : ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>" class="category-image">
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" alt="<?php echo esc_attr($category->name); ?>" class="category-image">
                    <?php endif; ?>
                    <div class="category-card-content">
                        <h3 class="category-title"><?php echo esc_html($category->name); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    else :
        echo '<p>' . esc_html__('No product categories found', 'nmdiam') . '</p>';
    endif;
    
    return ob_get_clean();
}
add_shortcode('product_categories', 'nmdiam_product_categories_shortcode');