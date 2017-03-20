<?php
/**
 * Avani functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Avani
 */

if ( ! function_exists( 'avani_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function avani_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Avani, use a find and replace
		 * to change 'avani' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'avani' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 720, 9999 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary', 'avani' ),
			'social'  => __( 'Social', 'avani' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'avani_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', apply_filters( 'avani_custom_logo_args', array(
			'flex-width'  => true,
			'flex-height' => true,
			'width'       => 100,
			'height'      => 100,
		) ) );

		add_editor_style( array( 'assets/css/editor-style.css', avani_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'avani_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function avani_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'avani_content_width', 720 );
}
add_action( 'after_setup_theme', 'avani_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function avani_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'avani' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here.', 'avani' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'footer-widget-1', 'avani' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add footer widgets here.', 'avani' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'footer-widget-2', 'avani' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add footer widgets here.', 'avani' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'footer-widget-3', 'avani' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add footer widgets here.', 'avani' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
}
add_action( 'widgets_init', 'avani_widgets_init' );

if ( ! function_exists( 'avani_fonts_url' ) ) :
	/**
	 * Get Google fonts url to register and enqueue.
	 *
	 * This function incorporates code from Twenty Fifteen WordPress Theme,
	 * Copyright 2014-2016 WordPress.org & Automattic.com Twenty Fifteen is
	 * distributed under the terms of the GNU GPL.
	 *
	 * @since 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function avani_fonts_url() {

		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Roboto, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'avani' ) ) {
			$fonts[] = 'Roboto:400italic,700italic,400,700';
		}

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Oswald, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Oswald font: on or off', 'avani' ) ) {
			$fonts[] = 'Oswald:400italic,700italic,400,700';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		/**
		 * Filter google font url.
		 *
		 * @since 1.0.0
		 */
		return apply_filters( 'avani_font_url', $fonts_url );
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * This function incorporates code from Twenty Seventeen WordPress Theme,
 * Copyright 2016-2017 WordPress.org. Twenty Seventeen is distributed
 * under the terms of the GNU GPL.
 *
 * @since 1.0.0
 */
function avani_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'avani_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function avani_scripts() {
	wp_enqueue_style( 'avani-fonts', avani_fonts_url(), array(), null );

	wp_enqueue_style( 'avani-style', get_stylesheet_uri() );

	wp_enqueue_script( 'avani-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0.0', true );

	wp_enqueue_script( 'avani-sidebar-toggle', get_template_directory_uri() . '/assets/js/sidebar-toggle.js', array( 'jquery' ), '1.0.0', true );

	if ( has_nav_menu( 'primary' ) ) {
		$avani_l10n = array(
			'expand'   => __( 'Expand child menu', 'avani' ),
			'collapse' => __( 'Collapse child menu', 'avani' ),
			'icon'     => avani_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
		);
		wp_enqueue_script( 'avani-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'avani-navigation', 'avaniScreenReaderText', $avani_l10n );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'avani_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load font icons functions file.
 */
require get_template_directory() . '/inc/icons.php';
