<?php
/**
 * Refugee Scotland Festival Theme Theme Customizer
 *
 * @package Refugee_Scotland_Festival_Theme
 */

/**
 * Various additions to the Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function src_project_customize_register( $wp_customize ) {
	/* Amend Customizer screen to add 2nd logo and current year's Festival customization */
	$wp_customize->add_setting( 'second_logo', array(
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'second_logo', array(
	'label'      => esc_html__('Second Logo', 'src-project'),
	'section'    => 'title_tagline',
	'settings'   => 'second_logo',
	'mime_type'	 => 'image',
	'priority'	 => 9
	) ) );

	//Current Festival section
	$wp_customize->add_section( 'current_festival' , array(
		'title'      => esc_html__('Current Festival', 'src-project'),
		'priority'   => 30,
	) );

	//Festival dates, displayed in homepage
	$wp_customize->add_setting( 'current_festival_dates', array(
		'default' => esc_html__('enter this year\'s festival dates here...', 'src-project'),
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	) );
	$wp_customize->add_control( 'current_festival_dates', array(
	'label'      => esc_html__('Festival Dates', 'src-project'),
	'section'    => 'current_festival',
	'settings'   => 'current_festival_dates',
	'type'			 => 'text'
  ) );

	$wp_customize->add_setting( 'current_festival_hero_image', array(
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'current_festival_hero_image', array(
	'label'      => esc_html__('Homepage Hero Image', 'src-project'),
	'section'    => 'current_festival',
	'settings'   => 'current_festival_hero_image',
	'mime_type'	 => 'image'
	) ) );

	$wp_customize->add_setting( 'current_festival_text_color', array(
		'default' => '#2f39ed',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'current_festival_text_color', array(
	'label'      => esc_html__('Text Color', 'src-project'),
	'section'    => 'current_festival',
	'settings'   => 'current_festival_text_color',
	) ) );

  //Use twentyseventeen/inc/customizer.php setting 'colourscheme' as a possible model.
	//It calls (in functions.php) function twentyseventeen_colors_css_wrap() and echoes twentyseventeen_custom_colors_css() (which is in inc/color-patterns.php)
	//for both the frontend and customizer
	$wp_customize->add_setting( 'current_festival_menu_color', array(
		'default' => '#a66bed',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'current_festival_menu_color', array(
	'label'      => esc_html__('Menu Colour', 'src-project'),
	'section'    => 'current_festival',
	'settings'   => 'current_festival_menu_color',
	) ) );

	$wp_customize->add_setting( 'current_festival_accent_color', array(
		'default' => '#0ea2c7',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'current_festival_accent_color', array(
	'label'      => esc_html__('Accent Colour', 'src-project'),
	'section'    => 'current_festival',
	'settings'   => 'current_festival_accent_color',
	) ) );

	/* Remove sections that are not needed or that may confuse */
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );

	/* Move the tagline section from Site Identity to Current Festival
	 * See https://poststatus.com/customize-wordpress-theme-customizer/ */
	$wp_customize->get_control( 'blogdescription' )->section = 'current_festival';

	/* Change other default Customiser settings */
	//DEFAULT DOES NOT EXIST FOR CUSTOM LOGO $wp_customize->get_control( 'custom_logo' )->default = get_template_directory() . '/images/rfs-logo.png';
	$wp_customize->get_control( 'custom_logo' )->label = esc_html__('Festival Logo', 'src-project');
	$wp_customize->remove_control( 'display_header_text' ); //remove the option to not show the tagline

	/* Add postMessage support for site title and description for the Theme Customizer. */
  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'second_logo' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'current_festival_dates' )->transport 			 = 'postMessage';
	$wp_customize->get_setting( 'current_festival_hero_image' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'current_festival_text_color' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'current_festival_menu_color' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'current_festival_accent_color' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'src_project_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'src_project_customize_partial_blogdescription',
		) );
/*		$wp_customize->selective_refresh->add_partial( 'current_festival_dates', array(
			'selector'        => '.festival-dates',
			'render_callback' => 'src_project_customize_partial_festival_dates',
		) ); */
	}

}
add_action( 'customize_register', 'src_project_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function src_project_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function src_project_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/*function src_project_customize_partial_festival_dates(){
	get_theme_mod( 'current_festival_dates' );
}*/

/*
* Sanitize image files for the second logo
* @params {file} and {costumizer setting}
* @return {file}
*/
function src_project_sanitize_image_file($file, $setting){
	//allowed file types
  $mimes = array(
      'jpg|jpeg' => 'image/jpeg',
      'gif'          => 'image/gif',
      'png'          => 'image/png'
  );

  //check file type from file name
  $file_ext = wp_check_filetype( $file, $mimes );

  //if file has a valid mime type return it, otherwise return default
  return ( $file_ext['ext'] ? $file : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function src_project_customize_preview_js() {
	wp_enqueue_script( 'src-project-customizer-controls', get_template_directory_uri() . '/js/customizer.js', array( 'jquery','customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'src_project_customize_preview_js' );
