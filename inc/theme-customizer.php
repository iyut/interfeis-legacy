<?php
/**
 * Legacy Theme Customizer
 *
 * @package Legacy
 */


 /**
  * Include Custom Controls
  *
  * Includes all our custom control classes.
  *
  * @param WP_Customize_Manager $wp_customize
  *
  * @access public
  * @since  1.1
  * @return void
  */
 function ifs_legacy_include_controls( $wp_customize ) {

 	require_once get_template_directory() . '/inc/customizer/controls/class-ifs-image-select-control.php';

 	$wp_customize->register_control_type( 'IFS_Image_Select_Control' );

 }
 add_action( 'customize_register', 'ifs_legacy_include_controls' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ifs_legacy_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'ifs_legacy_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'ifs_legacy_customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_panel( 'ifs_legacy_panel_header_setting', array(
		    'priority' => 10,
		    'capability' => 'edit_theme_options',
		    'theme_supports' => '',
		    'title' => esc_html__( 'Header Settings', 'ifs-legacy' ),
		    'description' => esc_html__( 'Description of what this panel does.', 'ifs-legacy' ),
		)
	);

	$wp_customize->add_section( 'header_image', array(
	        'title' => esc_html__( 'Header Background Image', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the header background image.', 'ifs-legacy' ),
	        'priority' => 10,
	        'panel' => 'ifs_legacy_panel_header_setting',
	    )
	);

	$wp_customize->add_section('ifs_legacy_section_header_options', array(
		'title'		=> esc_html__('Header Options','ifs-legacy'),
		'priority'	=> 30,
		'panel' => 'ifs_legacy_panel_header_setting'
	));

	$wp_customize->add_setting( 'background_color', array(
		'default' 	=> '#ffffff',
		'transport'	=> 'refresh'
	));

	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'background_color', array(
		'label'		=> esc_html__('Background Color', 'ifs-legacy'),
		'section'	=> 'ifs_legacy_section_header_options',
		'setting'	=> 'background_color'
	)));


	$wp_customize->add_setting( 'ifs_legacy_header_layout_style', array(
		'default'           => 'default',
		'sanitize_callback' => 'sanitize_key'
	) );



    $headers = ifs_legacy_get_theme_headers();
    $header_layout_opt = array();
    foreach( $headers as $header_idx => $header_val ){
        $header_layout_opt[$header_idx] = array(
            'label' => $header_idx,
            'url'   => $header_val['png']
        );
    }

	$wp_customize->add_control( new IFS_Image_Select_Control( 'ifs_legacy_header_layout_style', array(
		'label'       => esc_html__( 'Layout', 'ifs-legacy' ),
		'description' => __( 'Choose a layout for the blog posts.', 'ifs-legacy' ),
		'section'     => 'blog_layout',
		'settings'    => 'layout_style',
		'choices'     => $header_layout_opt,
		'priority'    => 10
	) ) );

}
add_action( 'customize_register', 'ifs_legacy_customize_register' );


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ifs_legacy_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ifs_legacy_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ifs_legacy_customize_preview_js() {
	wp_enqueue_script( 'ifs-legacy-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ifs_legacy_customize_preview_js' );
