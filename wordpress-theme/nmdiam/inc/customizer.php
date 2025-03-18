<?php
/**
 * NMDIAM Theme Customizer
 *
 * @package NMDIAM
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nmdiam_customize_register($wp_customize) {
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	// Header Options
	$wp_customize->add_section('nmdiam_header_options', array(
		'title'    => __('Header Options', 'nmdiam'),
		'priority' => 30,
	));

	$wp_customize->add_setting('nmdiam_sticky_header', array(
		'default'           => true,
		'sanitize_callback' => 'nmdiam_sanitize_checkbox',
	));

	$wp_customize->add_control('nmdiam_sticky_header', array(
		'type'     => 'checkbox',
		'label'    => __('Enable Sticky Header', 'nmdiam'),
		'section'  => 'nmdiam_header_options',
		'settings' => 'nmdiam_sticky_header',
	));

	// Footer Options
	$wp_customize->add_section('nmdiam_footer_options', array(
		'title'    => __('Footer Options', 'nmdiam'),
		'priority' => 90,
	));

	$wp_customize->add_setting('nmdiam_footer_text', array(
		'default'           => sprintf(__('&copy; %s %s. All Rights Reserved.', 'nmdiam'), date('Y'), get_bloginfo('name')),
		'sanitize_callback' => 'wp_kses_post',
	));

	$wp_customize->add_control('nmdiam_footer_text', array(
		'type'     => 'textarea',
		'label'    => __('Footer Text', 'nmdiam'),
		'section'  => 'nmdiam_footer_options',
		'settings' => 'nmdiam_footer_text',
	));

	// Social Media Links
	$wp_customize->add_section('nmdiam_social_options', array(
		'title'    => __('Social Media Links', 'nmdiam'),
		'priority' => 95,
	));

	$social_platforms = array(
		'facebook'  => __('Facebook URL', 'nmdiam'),
		'instagram' => __('Instagram URL', 'nmdiam'),
		'linkedin'  => __('LinkedIn URL', 'nmdiam'),
		'twitter'   => __('Twitter URL', 'nmdiam'),
		'pinterest' => __('Pinterest URL', 'nmdiam'),
	);

	foreach ($social_platforms as $platform => $label) {
		$wp_customize->add_setting('nmdiam_social_' . $platform, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		));

		$wp_customize->add_control('nmdiam_social_' . $platform, array(
			'type'     => 'url',
			'label'    => $label,
			'section'  => 'nmdiam_social_options',
			'settings' => 'nmdiam_social_' . $platform,
		));
	}

	// Home Page Options
	$wp_customize->add_panel('nmdiam_homepage_panel', array(
		'title'    => __('Homepage Options', 'nmdiam'),
		'priority' => 40,
	));

	// Hero Section
	$wp_customize->add_section('nmdiam_hero_section', array(
		'title'    => __('Hero Section', 'nmdiam'),
		'panel'    => 'nmdiam_homepage_panel',
		'priority' => 10,
	));

	$wp_customize->add_setting('nmdiam_hero_image', array(
		'default'           => get_template_directory_uri() . '/assets/img/hero-bg.jpg',
		'sanitize_callback' => 'esc_url_raw',
	));

	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'nmdiam_hero_image', array(
		'label'    => __('Hero Background Image', 'nmdiam'),
		'section'  => 'nmdiam_hero_section',
		'settings' => 'nmdiam_hero_image',
	)));

	$wp_customize->add_setting('nmdiam_hero_title', array(
		'default'           => __('Timeless Elegance Redefined', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_hero_title', array(
		'type'     => 'text',
		'label'    => __('Hero Title', 'nmdiam'),
		'section'  => 'nmdiam_hero_section',
		'settings' => 'nmdiam_hero_title',
	));

	$wp_customize->add_setting('nmdiam_hero_description', array(
		'default'           => __('Discover our exquisite collection of handcrafted jewelry pieces that celebrate your unique story.', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_hero_description', array(
		'type'     => 'textarea',
		'label'    => __('Hero Description', 'nmdiam'),
		'section'  => 'nmdiam_hero_section',
		'settings' => 'nmdiam_hero_description',
	));

	// Featured Products Section
	$wp_customize->add_section('nmdiam_featured_products_section', array(
		'title'    => __('Featured Products Section', 'nmdiam'),
		'panel'    => 'nmdiam_homepage_panel',
		'priority' => 20,
	));

	$wp_customize->add_setting('nmdiam_featured_products_title', array(
		'default'           => __('Featured Pieces', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_featured_products_title', array(
		'type'     => 'text',
		'label'    => __('Section Title', 'nmdiam'),
		'section'  => 'nmdiam_featured_products_section',
		'settings' => 'nmdiam_featured_products_title',
	));

	$wp_customize->add_setting('nmdiam_featured_products_description', array(
		'default'           => __('Our most exquisite and sought-after designs', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_featured_products_description', array(
		'type'     => 'textarea',
		'label'    => __('Section Description', 'nmdiam'),
		'section'  => 'nmdiam_featured_products_section',
		'settings' => 'nmdiam_featured_products_description',
	));

	$wp_customize->add_setting('nmdiam_featured_products_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control('nmdiam_featured_products_count', array(
		'type'     => 'number',
		'label'    => __('Number of Products to Display', 'nmdiam'),
		'section'  => 'nmdiam_featured_products_section',
		'settings' => 'nmdiam_featured_products_count',
		'input_attrs' => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
	));

	// Custom Order Section
	$wp_customize->add_section('nmdiam_custom_order_section', array(
		'title'    => __('Custom Order Section', 'nmdiam'),
		'panel'    => 'nmdiam_homepage_panel',
		'priority' => 30,
	));

	$wp_customize->add_setting('nmdiam_custom_order_title', array(
		'default'           => __('Custom Designed Jewelry', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_custom_order_title', array(
		'type'     => 'text',
		'label'    => __('Section Title', 'nmdiam'),
		'section'  => 'nmdiam_custom_order_section',
		'settings' => 'nmdiam_custom_order_title',
	));

	$wp_customize->add_setting('nmdiam_custom_order_description', array(
		'default'           => __('Create a piece as unique as your story. Our expert artisans will work with you to design and craft bespoke jewelry that captures your vision.', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_custom_order_description', array(
		'type'     => 'textarea',
		'label'    => __('Section Description', 'nmdiam'),
		'section'  => 'nmdiam_custom_order_section',
		'settings' => 'nmdiam_custom_order_description',
	));

	$wp_customize->add_setting('nmdiam_custom_order_image', array(
		'default'           => get_template_directory_uri() . '/assets/img/custom-jewelry.jpg',
		'sanitize_callback' => 'esc_url_raw',
	));

	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'nmdiam_custom_order_image', array(
		'label'    => __('Section Image', 'nmdiam'),
		'section'  => 'nmdiam_custom_order_section',
		'settings' => 'nmdiam_custom_order_image',
	)));

	// Features in the Custom Order Section
	for ($i = 1; $i <= 4; $i++) {
		$wp_customize->add_setting('nmdiam_custom_order_feature_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('nmdiam_custom_order_feature_' . $i, array(
			'type'     => 'text',
			'label'    => sprintf(__('Feature %d', 'nmdiam'), $i),
			'section'  => 'nmdiam_custom_order_section',
			'settings' => 'nmdiam_custom_order_feature_' . $i,
		));
	}

	// Newsletter Section
	$wp_customize->add_section('nmdiam_newsletter_section', array(
		'title'    => __('Newsletter Section', 'nmdiam'),
		'panel'    => 'nmdiam_homepage_panel',
		'priority' => 40,
	));

	$wp_customize->add_setting('nmdiam_newsletter_title', array(
		'default'           => __('Subscribe to Our Newsletter', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_newsletter_title', array(
		'type'     => 'text',
		'label'    => __('Section Title', 'nmdiam'),
		'section'  => 'nmdiam_newsletter_section',
		'settings' => 'nmdiam_newsletter_title',
	));

	$wp_customize->add_setting('nmdiam_newsletter_description', array(
		'default'           => __('Join our community to receive updates on new collections, exclusive offers, and jewelry care tips.', 'nmdiam'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('nmdiam_newsletter_description', array(
		'type'     => 'textarea',
		'label'    => __('Section Description', 'nmdiam'),
		'section'  => 'nmdiam_newsletter_section',
		'settings' => 'nmdiam_newsletter_description',
	));

	// Colors
	$wp_customize->add_setting('nmdiam_primary_color', array(
		'default'           => '#D4AF37',
		'sanitize_callback' => 'sanitize_hex_color',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nmdiam_primary_color', array(
		'label'    => __('Primary Color', 'nmdiam'),
		'section'  => 'colors',
		'settings' => 'nmdiam_primary_color',
	)));

	$wp_customize->add_setting('nmdiam_secondary_color', array(
		'default'           => '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nmdiam_secondary_color', array(
		'label'    => __('Secondary Color', 'nmdiam'),
		'section'  => 'colors',
		'settings' => 'nmdiam_secondary_color',
	)));
}
add_action('customize_register', 'nmdiam_customize_register');

/**
 * Sanitize checkbox values
 */
function nmdiam_sanitize_checkbox($checked) {
	return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nmdiam_customize_partial_blogname() {
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nmdiam_customize_partial_blogdescription() {
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nmdiam_customize_preview_js() {
	wp_enqueue_script('nmdiam-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), NMDIAM_VERSION, true);
}
add_action('customize_preview_init', 'nmdiam_customize_preview_js');

/**
 * Generate inline CSS for customizer options
 */
function nmdiam_customizer_css() {
	$primary_color = get_theme_mod('nmdiam_primary_color', '#D4AF37');
	$secondary_color = get_theme_mod('nmdiam_secondary_color', '#333333');
	
	$css = "
	:root {
		--color-primary: {$primary_color};
		--color-secondary: {$secondary_color};
	}";
	
	wp_add_inline_style('nmdiam-style', $css);
}
add_action('wp_enqueue_scripts', 'nmdiam_customizer_css', 20);