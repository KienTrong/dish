<?php
/**
 * Dish functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dish
 */

if ( ! function_exists( 'dish_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dish_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Dish, use a find and replace
	 * to change 'dish' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dish', get_template_directory() . '/languages' );

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
	 * Editor styles
	 */
	add_editor_style( array( get_template_directory_uri() . '/assets/css/editor-style.css', dish_fonts_url() ) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'dish' ),
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dish_custom_background_args', array(
		'default-color' => 'ebebeb',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'dish_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dish_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dish_content_width', 760 );
}
add_action( 'after_setup_theme', 'dish_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dish_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dish' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dish_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dish_scripts() {
	wp_enqueue_style( 'dish-style', get_stylesheet_uri() );
	wp_enqueue_style( 'dish-fonts', dish_fonts_url(), array(), null );

	wp_enqueue_script( 'dish-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'dish-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( wp_style_is( 'genericons', 'registered' ) ) {
		wp_enqueue_style( 'genericons' );
	} else {
		wp_enqueue_style( 'genericons', get_template_directory_uri() . '/assets/genericons/genericons.css', array(), null );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dish_scripts' );

/**
 * Enqueuing Google Fonts
 */
function dish_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Playfair Display, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$playfair_display = esc_html_x( 'on', 'Playfair Display font: on or off', 'dish' );

	/* Translators: If there are characters in your language that are not
	* supported by Open Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$opensans = esc_html_x( 'on', 'Open Sans font: on or off', 'dish' );

	if ( 'off' !== $playfair_display || 'off' !== $opensans ) {
		$font_families = array();

		if ( 'off' !== $playfair_display ) {
			$font_families[] = 'Playfair+Display:400,400italic,700,700italic';
		}

		if ( 'off' !== $opensans ) {
			$font_families[] = 'Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

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
