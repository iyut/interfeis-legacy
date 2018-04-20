<?php
/**
 * Legacy theme initiation files
 *
 * @package Legacy
 */

 if ( ! function_exists( 'ifs_legacy_setup' ) ) :
 	/**
 	 * Sets up theme defaults and registers support for various WordPress features.
 	 *
 	 * Note that this function is hooked into the after_setup_theme hook, which
 	 * runs before the init hook. The init hook is too late for some features, such
 	 * as indicating support for post thumbnails.
 	 */
 	function ifs_legacy_setup() {
 		/*
 		 * Make theme available for translation.
 		 * Translations can be filed in the /languages/ directory.
 		 * If you're building a theme based on Legacy, use a find and replace
 		 * to change 'ifs-legacy' to the name of your theme in all the template files.
 		 */
 		load_theme_textdomain( 'ifs-legacy', get_template_directory() . '/languages' );

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

        add_theme_support( 'post-formats', array( 'image','aside','gallery','link','video','quote','status','audio','chat' ) );

 		// This theme uses wp_nav_menu() in one location.
 		register_nav_menus( apply_filters('ifs_legacy_register_nav_menus', array(
 			'menu-1'        => esc_html__( 'Primary', 'ifs-legacy' ),
            'menu-2'        => esc_html__( 'Secondary', 'ifs-legacy'),
            'top-menu'      => esc_html__( 'Top Menu', 'ifs-legacy'),
            'footer-menu'   => esc_html__( 'Footer Menu', 'ifs-legacy')
 		)) );

 		/*
 		 * Switch default core markup for search form, comment form, and comments
 		 * to output valid HTML5.
 		 */
 		add_theme_support( 'html5', apply_filters('ifs_legacy_html5_support', array(
 			'search-form',
 			'comment-form',
 			'comment-list',
 			'gallery',
 			'caption',
 		)) );

 		// Set up the WordPress core custom background feature.
 		add_theme_support( 'custom-background', apply_filters( 'ifs_legacy_custom_background_args', array(
 			'default-color' => 'ffffff',
 			'default-image' => '',
 		) ) );

 		// Add theme support for selective refresh for widgets.
 		add_theme_support( 'customize-selective-refresh-widgets' );

 		/**
 		 * Add support for core custom logo.
 		 *
 		 * @link https://codex.wordpress.org/Theme_Logo
 		 */
 		add_theme_support( 'custom-logo', apply_filters( 'ifs_legacy_custom_logo_args', array(
 			'height'      => 250,
 			'width'       => 250,
 			'flex-width'  => true,
 			'flex-height' => true,
 		)) );

        /**
         * Set up the WordPress core custom header feature.
         *
         */
    	add_theme_support( 'custom-header', apply_filters( 'ifs_legacy_custom_header_args', array(
    		'default-image'          => '',
    		'default-text-color'     => '000000',
    		'width'                  => 2100,
    		'height'                 => 500,
    		'flex-height'            => true
    	) ) );
 	}

	add_action( 'after_setup_theme', 'ifs_legacy_setup' );

 endif;

if( !function_exists('ifs_legacy_add_image_sizes') ){
/**
* Registered image size
*/
	function ifs_legacy_add_image_sizes(){
		add_image_size('ifs_legacy_blog_list_img'	, 360, 240, false);
		add_image_size('ifs_legacy_related_img'		, 360, 240, false);
	}

	add_action( 'after_setup_theme', 'ifs_legacy_add_image_sizes' );
}
 /**
 * Registers an editor stylesheet for the theme.
 */
function ifs_legacy_add_editor_styles() {
    add_editor_style( 'assets/css/custom-editor-style.css' );
}
add_action( 'admin_init', 'ifs_legacy_add_editor_styles' );

 /**
  * Set the custom body class
  *
  */
function ifs_legacy_body_class( $classes ){
    $classes[]  = 'ifs';

    return $classes;
}
add_filter('body_class', 'ifs_legacy_body_class');

/**
 * Set the custom query vars
 *
 */
if(!function_exists('ifs_legacy_adding_query_vars')){
    add_filter('query_vars', 'ifs_legacy_adding_query_vars' );
    function ifs_legacy_adding_query_vars( $qvars ){
        //Add query variable to $qvars array
        $qvars[] = 'ifs_successregtext';
        return $qvars;
    }
}

 /**
  * Set the content width in pixels, based on the theme's design and stylesheet.
  *
  * Priority 0 to make it available to lower priority callbacks.
  *
  * @global int $content_width
  */
 function ifs_legacy_content_width() {
 	$GLOBALS['content_width'] = apply_filters( 'ifs_legacy_content_width', 640 );
 }
 add_action( 'after_setup_theme', 'ifs_legacy_content_width', 0 );
