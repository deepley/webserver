<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package NMDIAM
 */

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets-grid">
                    <div class="footer-widget footer-widget-1">
                        <div class="footer-logo">
                            <?php if (has_custom_logo()) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <h2 class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </h2>
                            <?php endif; ?>
                        </div>
                        <div class="footer-description">
                            <?php echo wp_kses_post(get_theme_mod('nmdiam_footer_description', __('Exquisite jewelry pieces crafted with precision and passion. NMDIAM is committed to creating timeless designs that celebrate life\'s special moments.', 'nmdiam'))); ?>
                        </div>
                        <div class="footer-social">
                            <?php if (get_theme_mod('nmdiam_facebook_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('nmdiam_facebook_url')); ?>" class="social-link" target="_blank" rel="noopener">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('nmdiam_instagram_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('nmdiam_instagram_url')); ?>" class="social-link" target="_blank" rel="noopener">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('nmdiam_twitter_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('nmdiam_twitter_url')); ?>" class="social-link" target="_blank" rel="noopener">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('nmdiam_pinterest_url')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('nmdiam_pinterest_url')); ?>" class="social-link" target="_blank" rel="noopener">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="footer-widget footer-widget-2">
                        <h3 class="footer-widget-title"><?php echo esc_html__('Quick Links', 'nmdiam'); ?></h3>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer-1',
                                'menu_id'        => 'footer-menu-1',
                                'container'      => false,
                                'menu_class'     => 'footer-menu',
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            )
                        );
                        ?>
                    </div>
                    
                    <div class="footer-widget footer-widget-3">
                        <h3 class="footer-widget-title"><?php echo esc_html__('Categories', 'nmdiam'); ?></h3>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer-2',
                                'menu_id'        => 'footer-menu-2',
                                'container'      => false,
                                'menu_class'     => 'footer-menu',
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            )
                        );
                        ?>
                    </div>
                    
                    <div class="footer-widget footer-widget-4">
                        <h3 class="footer-widget-title"><?php echo esc_html__('Contact Us', 'nmdiam'); ?></h3>
                        <div class="footer-contact-info">
                            <?php if (get_theme_mod('nmdiam_address')) : ?>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo wp_kses_post(get_theme_mod('nmdiam_address')); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('nmdiam_phone_number')) : ?>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:<?php echo esc_attr(get_theme_mod('nmdiam_phone_number')); ?>">
                                        <?php echo esc_html(get_theme_mod('nmdiam_phone_number')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('nmdiam_email_address')) : ?>
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:<?php echo esc_attr(get_theme_mod('nmdiam_email_address')); ?>">
                                        <?php echo esc_html(get_theme_mod('nmdiam_email_address')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('nmdiam_business_hours')) : ?>
                                <div class="contact-item">
                                    <i class="fas fa-clock"></i>
                                    <span><?php echo wp_kses_post(get_theme_mod('nmdiam_business_hours')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <div class="footer-copyright">
                        <?php echo wp_kses_post(get_theme_mod('nmdiam_footer_text', sprintf('© %d %s. All rights reserved.', date('Y'), get_bloginfo('name')))); ?>
                    </div>
                    
                    <?php if (function_exists('is_woocommerce')) : ?>
                        <div class="footer-payment-methods">
                            <?php
                            $payment_methods = get_theme_mod('nmdiam_payment_methods', array('visa', 'mastercard', 'amex', 'paypal'));
                            if (!empty($payment_methods)) : ?>
                                <div class="payment-methods">
                                    <?php foreach ($payment_methods as $method) : ?>
                                        <div class="payment-method">
                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/payment/' . $method . '.svg'); ?>" alt="<?php echo esc_attr($method); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php if (function_exists('is_woocommerce')) : ?>
<!-- Quick View Modal -->
<div id="quick-view-modal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        <button class="modal-close"><i class="fas fa-times"></i></button>
        <div class="modal-content"></div>
    </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>