<?php
/**
 * Refugee Scotland Festival Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Refugee_Scotland_Festival_Theme
 */

if ( ! function_exists( 'src_project_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function src_project_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Refugee Scotland Festival Theme, use a find and replace
		 * to change 'src-project' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'src-project', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'src-project' ),
			'social' => esc_html__( 'Social', 'src-project')
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
		add_theme_support( 'custom-background', apply_filters( 'src_project_custom_background_args', array(
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
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'width'       => 80,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'src_project_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function src_project_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'src_project_content_width', 640 );
}
add_action( 'after_setup_theme', 'src_project_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function src_project_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'src-project' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'src-project' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'src-project' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'src-project' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Header', 'src-project' ),
		'id'            => 'header',
		'description'   => esc_html__( 'Add widgets here.', 'src-project' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'    => '<span class="screen-reader-text">',
		'after_title'     => '</span> <button id="searchIcon">'. src_project_get_svg( array( 'icon' => 'chain' ) ) . '</button>',
	) );
}
add_action( 'widgets_init', 'src_project_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function src_project_scripts() {
	wp_enqueue_style( 'src-project-style', get_stylesheet_uri() );
	wp_enqueue_style( 'ttcommons-style', get_template_directory_uri(). '/fonts/TTCOMMONS/Info/MyFontsWebfontsKit.css', array(), '1.0.0' );

	wp_enqueue_script( 'src-project-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'src-project-search', get_template_directory_uri() . '/js/searchBttn.js', array('jquery'), '1.0.0', true );

	wp_enqueue_script( 'src-project-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'src_project_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/*
* Apply Custom Customizer settings to the live website
* See inc/customizer.php for further info on what those customized settings are.
*/
add_action( 'wp_head', 'src_project_customizer_css');
function src_project_customizer_css(){
	//See https://developer.wordpress.org/reference/functions/the_custom_logo/#user-contributed-notes
	$homepage_hero_background_image_id = get_theme_mod('current_festival_hero_image');
	$homepage_hero_background_image = wp_get_attachment_image_src( $homepage_hero_background_image_id , 'full' );
	$menu_links_color = get_theme_mod('current_festival_menu_color');
	$text_color = get_theme_mod('current_festival_text_color');
  $accent_color = get_theme_mod('current_festival_accent_color');
    ?>
         <style type="text/css">
				 		 /* homepage hero image */
             .home #hero { background-image: url('<?php echo esc_url($homepage_hero_background_image[0]); ?>');
							 			background-color: transparent;
						 				background-position: center;
										background-size: cover; }

							/* menu and links text color */
							.main-navigation a, #hero .site-title, .site-footer .es_caption, .single-event_cpt .entry-content {
										color: <?php echo sanitize_hex_color($menu_links_color); ?>;
							}
							.site-header svg.icon {
										fill:<?php echo sanitize_hex_color($menu_links_color); ?>;
							}
							button, .site-footer #es_txt_button, input[type="submit"] {
								border: <?php echo sanitize_hex_color($menu_links_color); ?>;
								background-color: <?php echo sanitize_hex_color($menu_links_color); ?>;
							}
							#programme .links a, .single-event_cpt .links a {
								background-color: <?php echo sanitize_hex_color($menu_links_color); ?>;
							}

							/* main text color */
							body, input, select, optgroup, a,
							.site-footer, .site-footer a, .site-footer label, .site-footer .widget-title {
								color: <?php echo sanitize_hex_color($text_color); ?>;
							}
							.site-footer #es_txt_button { color: #FFF; }

							/* accent color */
							#hero .site-description, #hero .festival-dates, .single-event_cpt article .right-column .subcolumn-B  {
								color: <?php echo sanitize_hex_color($accent_color); ?>;
							}
							.social-navigation a {
								background-color: <?php echo sanitize_hex_color($accent_color); ?>;
							}
							input[type="text"], input[type="email"], input[type="url"], input[type="password"],
							input[type="search"], input[type="number"], input[type="tel"], input[type="range"],
							input[type="date"], input[type="month"], input[type="week"], input[type="time"],
							input[type="datetime"], input[type="datetime-local"], input[type="color"],
							textarea, select {
								background-color: <?php echo sanitize_hex_color($accent_color); ?>;
							}
							.main-navigation .current_page_item > a, body[class*="page-programme-"] .event-header, .single-event_cpt .entry-header, body:not(.home) .site-main #programme {
								border-color:<?php echo sanitize_hex_color($accent_color); ?>;
							}
         </style>
    <?php
}
