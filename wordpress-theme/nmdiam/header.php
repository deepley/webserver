<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package NMDIAM
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'nmdiam'); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-top">
            <div class="container">
                <div class="header-top-inner">
                    <div class="header-contact">
                        <?php if (get_theme_mod('nmdiam_phone_number')) : ?>
                            <a href="tel:<?php echo esc_attr(get_theme_mod('nmdiam_phone_number')); ?>" class="header-phone">
                                <i class="fas fa-phone"></i> <?php echo esc_html(get_theme_mod('nmdiam_phone_number')); ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('nmdiam_email_address')) : ?>
                            <a href="mailto:<?php echo esc_attr(get_theme_mod('nmdiam_email_address')); ?>" class="header-email">
                                <i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('nmdiam_email_address')); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="header-social">
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
            </div>
        </div>
        
        <div class="header-main">
            <div class="container">
                <div class="header-main-inner">
                    <div class="site-branding">
                        <?php if (has_custom_logo()) : ?>
                            <div class="site-logo"><?php the_custom_logo(); ?></div>
                        <?php else : ?>
                            <h1 class="site-logo">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            
                            <?php 
                            $nmdiam_description = get_bloginfo('description', 'display');
                            if ($nmdiam_description || is_customize_preview()) : 
                            ?>
                                <p class="site-description"><?php echo $nmdiam_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div><!-- .site-branding -->

                    <nav id="site-navigation" class="main-navigation">
                        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                            <span class="menu-toggle-inner">
                                <span class="menu-toggle-line"></span>
                                <span class="menu-toggle-line"></span>
                                <span class="menu-toggle-line"></span>
                            </span>
                            <span class="screen-reader-text"><?php esc_html_e('Menu', 'nmdiam'); ?></span>
                        </button>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'container_class' => 'primary-menu-container',
                                'menu_class'     => 'primary-menu',
                            )
                        );
                        ?>
                    </nav><!-- #site-navigation -->

                    <div class="header-actions">
                        <div class="search-toggle">
                            <button class="search-toggle-btn" aria-expanded="false">
                                <i class="fas fa-search"></i>
                                <span class="screen-reader-text"><?php esc_html_e('Search', 'nmdiam'); ?></span>
                            </button>
                            <div class="search-dropdown">
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                        
                        <?php if (function_exists('is_woocommerce')) : ?>
                            <div class="account-link">
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                                    <i class="fas fa-user"></i>
                                    <span class="screen-reader-text"><?php esc_html_e('My Account', 'nmdiam'); ?></span>
                                </a>
                            </div>
                            
                            <div class="cart-link">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-contents">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span class="cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
                                    <span class="screen-reader-text"><?php esc_html_e('View your shopping cart', 'nmdiam'); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div><!-- .header-actions -->
                </div>
            </div>
        </div>
        
        <div class="search-modal">
            <div class="search-modal-inner">
                <div class="container">
                    <button class="search-modal-close">
                        <i class="fas fa-times"></i>
                        <span class="screen-reader-text"><?php esc_html_e('Close search', 'nmdiam'); ?></span>
                    </button>
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <div id="content" class="site-content">