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

    $wp_customize->add_panel( 'ifs_legacy_panel_general_setting', array(
		    'priority' => 5,
		    'capability' => 'edit_theme_options',
		    'theme_supports' => '',
		    'title' => esc_html__( 'General Settings', 'ifs-legacy' ),
		    'description' => esc_html__( 'General settings.', 'ifs-legacy' ),
		)
	);

    $wp_customize->add_section( 'ifs_legacy_section_body_options', array(
	        'title' => esc_html__( 'Body Background Color', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the body options.', 'ifs-legacy' ),
	        'priority' => 5,
            'panel' => 'ifs_legacy_panel_general_setting'
	    )
	);

	    $wp_customize->add_setting( 'background_color', array(
	        'default' 	=> '#ffffff',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'background_color', array(
	        'label'		=> esc_html__('Body Background Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_body_options',
	        'setting'	=> 'background_color'
	    )));

    $wp_customize->add_section( 'background_image', array(
	        'title' => esc_html__( 'Body Background Image', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the body background image.', 'ifs-legacy' ),
	        'priority' => 10,
	        'panel' => 'ifs_legacy_panel_general_setting',
	    )
	);

    $wp_customize->add_section( 'ifs_legacy_section_layout_options', array(
	        'title' => esc_html__( 'Layout Options', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the content option.', 'ifs-legacy' ),
	        'priority' => 15,
	        'panel' => 'ifs_legacy_panel_general_setting',
	    )
	);

	    $wp_customize->add_setting( 'ifs_legacy_layout_width', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_layout_width', array(
	        'label'		=> esc_html__('Layout Width', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_layout_width',
	        'description'	=> __( 'Input the default width of your layout. Default value : 1140', 'ifs-legacy' ),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 1024, 'max' => 1400)
	    ));

		$wp_customize->add_setting( 'ifs_legacy_container_layout', array(
	        'default' 	=> ifs_legacy_container_layout_default(),
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_container_layout', array(
	        'label'		=> esc_html__('Base Container Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_container_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_container_layout_choices()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_content_layout', array(
	        'default' 	=> ifs_legacy_content_layout_default(),
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_content_layout', array(
	        'label'		=> esc_html__('Base Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_archive_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_archive_content_layout', array(
	        'label'		=> esc_html__('Post Archive Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_archive_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_single_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_single_content_layout', array(
	        'label'		=> esc_html__('Post Single Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_single_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_404_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_404_content_layout', array(
	        'label'		=> esc_html__('404 Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_404_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_attachment_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_attachment_content_layout', array(
	        'label'		=> esc_html__('Attachment Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_attachment_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_search_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_search_content_layout', array(
	        'label'		=> esc_html__('Search Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_search_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_shop_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_shop_content_layout', array(
	        'label'		=> esc_html__('Shop Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_shop_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

		$wp_customize->add_setting( 'ifs_legacy_product_content_layout', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_product_content_layout', array(
	        'label'		=> esc_html__('Single Product Content Layout', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_layout_options',
	        'setting'	=> 'ifs_legacy_product_content_layout',
	        'type'      => 'select',
	        'choices'   => ifs_legacy_content_layout_choices_with_default()
	    ));

	$wp_customize->add_section( 'ifs_legacy_section_font_options', array(
	        'title' => esc_html__( 'Fonts', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the font options.', 'ifs-legacy' ),
	        'priority' => 20,
            'panel' => 'ifs_legacy_panel_general_setting'
	    )
	);

	    $wp_customize->add_setting( 'ifs_legacy_custom_font_1', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_custom_font_1', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Primary Chosen Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the custom font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_custom_font_1',
			'choices'		=> ifs_legacy_custom_font_values('primary'),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_custom_font_2', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_custom_font_2', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Secondary Chosen Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the secondary custom font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_custom_font_2',
			'choices'		=> ifs_legacy_custom_font_values('secondary'),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_custom_font_3', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_custom_font_3', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Tertiary Chosen Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the tertiary custom font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_custom_font_3',
			'choices'		=> ifs_legacy_custom_font_values('tertiary'),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_base_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_base_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Base Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for base font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_base_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_base_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_base_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Base Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your base font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_base_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_base_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_base_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Base Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for base font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_base_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );


		$wp_customize->add_setting( 'ifs_legacy_h1_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h1_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 1 Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for heading 1 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h1_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h1_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h1_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Heading 1 Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your heading 1 font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h1_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h1_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h1_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 1 Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for heading 1 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h1_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h2_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h2_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 2 Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for heading 2 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h2_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h2_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h2_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Heading 2 Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your heading 2 font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h2_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h2_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h2_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 2 Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for heading 2 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h2_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h3_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h3_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 3 Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for heading 3 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h3_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h3_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h3_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Heading 3 Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your heading 3 font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h3_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h3_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h3_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 3 Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for heading 3 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h3_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h4_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h4_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 4 Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for heading 4 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h4_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h4_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h4_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Heading 4 Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your heading 4 font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h4_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h4_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h4_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 4 Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for heading 4 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h4_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h5_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h5_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 5 Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for heading 5 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h5_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h5_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h5_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Heading 5 Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your heading 5 font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h5_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h5_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h5_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 5 Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for heading 5 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h5_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h6_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h6_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 6 Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for heading 6 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h6_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h6_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h6_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Heading 6 Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your heading 6 font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h6_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_h6_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_h6_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Heading 6 Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for heading 6 font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_font_options',
			'setting'		=> 'ifs_legacy_h6_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );


    $wp_customize->add_section( 'ifs_legacy_section_text_color_options', array(
	        'title' => esc_html__( 'Colors', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the text color options.', 'ifs-legacy' ),
	        'priority' => 20,
            'panel' => 'ifs_legacy_panel_general_setting'
	    )
	);

        $wp_customize->add_setting( 'ifs_legacy_general_text_color', array(
            'default' 	=> '',
            'transport'	=> 'refresh',
            'sanitize_callback'	=> 'esc_attr'
        ));

        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_general_text_color', array(
	        'label'		=> esc_html__('General Text Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_text_color_options',
	        'setting'	=> 'ifs_legacy_general_text_color'
	    )));

        $wp_customize->add_setting( 'ifs_legacy_general_link_color', array(
            'default' 	=> '',
            'transport'	=> 'refresh',
            'sanitize_callback'	=> 'esc_attr'
        ));

        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_general_link_color', array(
	        'label'		=> esc_html__('General Link Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_text_color_options',
	        'setting'	=> 'ifs_legacy_general_link_color'
	    )));


	$wp_customize->add_panel( 'ifs_legacy_panel_header_setting', array(
		    'priority' => 10,
		    'capability' => 'edit_theme_options',
		    'theme_supports' => '',
		    'title' => esc_html__( 'Header Settings', 'ifs-legacy' ),
		    'description' => esc_html__( 'Header settings.', 'ifs-legacy' ),
		)
	);

	$wp_customize->add_section( 'header_image', array(
	        'title' => esc_html__( 'Header Background Image', 'ifs-legacy' ),
	        'description' => esc_html__( 'This is a section for the header background image.', 'ifs-legacy' ),
	        'priority' => 10,
	        'panel' => 'ifs_legacy_panel_header_setting',
	    )
	);

	    $wp_customize->add_section('ifs_legacy_section_top_bar_options', array(
			'title'		=> esc_html__('Top Bar Options','ifs-legacy'),
			'priority'	=> 30,
			'panel' => 'ifs_legacy_panel_header_setting'
		));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_1_content', array(
			'default'		=> 'text',
			'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_html'
		));

	    $wp_customize->add_control( 'ifs_legacy_top_bar_1_content', array(
			'settings'		=> 'ifs_legacy_top_bar_1_content',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar 1 Content', 'ifs-legacy' ),
			'description'	=> __( 'Select the type of the content.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => ifs_legacy_top_bar_choices()
		));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_1_text', array(
			'default'		=> '',
			'transport'	=> 'postMessage',
	        'sanitize_callback'	=> 'ifs_legacy_custom_wp_kses'
		));

	    $wp_customize->add_control( 'ifs_legacy_top_bar_1_text', array(
			'settings'		=> 'ifs_legacy_top_bar_1_text',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar 1 Text', 'ifs-legacy' ),
			'description'	=> __( 'Input the content if you select "Text" as the content.', 'ifs-legacy' ),
	        'type'          => 'textarea'
		));

        $wp_customize->add_setting( 'ifs_legacy_top_bar_1_position', array(
			'default'		=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

	    $wp_customize->add_control( 'ifs_legacy_top_bar_1_position', array(
			'settings'		=> 'ifs_legacy_top_bar_1_position',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar 1 Position', 'ifs-legacy' ),
			'description'	=> __( 'Select the position of the top bar 1.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => array(
	            ''              => __( 'Default', 'ifs-legacy' ),
	            'left'          => __( 'Left', 'ifs-legacy' ),
				'center'        => __( 'Center', 'ifs-legacy' ),
	            'right'         => __( 'Right', 'ifs-legacy' )
	        )
		));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_2_content', array(
			'default'		=> '',
			'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

	    $wp_customize->add_control( 'ifs_legacy_top_bar_2_content', array(
			'settings'		=> 'ifs_legacy_top_bar_2_content',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar 2 Content', 'ifs-legacy' ),
			'description'	=> __( 'Select the type of the content.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => ifs_legacy_top_bar_choices()
		));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_2_text', array(
			'default'		=> '',
			'transport'	=> 'postMessage',
	        'sanitize_callback'	=> 'ifs_legacy_custom_wp_kses'
		));

	    $wp_customize->add_control( 'ifs_legacy_top_bar_2_text', array(
			'settings'		=> 'ifs_legacy_top_bar_2_text',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar 2 Text', 'ifs-legacy' ),
			'description'	=> __( 'Input the content if you select "Text" as the content.', 'ifs-legacy' ),
	        'type'          => 'textarea'
		));

        $wp_customize->add_setting( 'ifs_legacy_top_bar_2_position', array(
			'default'		=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

	    $wp_customize->add_control( 'ifs_legacy_top_bar_2_position', array(
			'settings'		=> 'ifs_legacy_top_bar_2_position',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar 2 Position', 'ifs-legacy' ),
			'description'	=> __( 'Select the position of the top bar 1.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => array(
	            ''              => __( 'Default', 'ifs-legacy' ),
	            'left'          => __( 'Left', 'ifs-legacy' ),
				'center'        => __( 'Center', 'ifs-legacy' ),
	            'right'         => __( 'Right', 'ifs-legacy' )
	        )
		));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_text_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_top_bar_text_color', array(
	        'label'		=> esc_html__('Top Bar Text Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_top_bar_options',
	        'setting'	=> 'ifs_legacy_top_bar_text_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_link_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_top_bar_link_color', array(
	        'label'		=> esc_html__('Top Bar Link Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_top_bar_options',
	        'setting'	=> 'ifs_legacy_top_bar_link_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_background_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_top_bar_background_color', array(
	        'label'		=> esc_html__('Top Bar Background Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_top_bar_options',
	        'setting'	=> 'ifs_legacy_top_bar_background_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_top_bar_background_image', array(
			'default'		=> '',
			'sanitize_callback'	=> 'esc_url_raw',
	        'transport'	=> 'refresh'
		));

	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ifs_legacy_top_bar_background_image', array(
			'settings'		=> 'ifs_legacy_top_bar_background_image',
			'section'		=> 'ifs_legacy_section_top_bar_options',
			'label'			=> __( 'Top Bar Background Image', 'ifs-legacy' ),
			'description'	=> __( 'Select the image to be used for Top Background. The background will cover the whole section.', 'ifs-legacy' )
		)));

		$wp_customize->add_section('ifs_legacy_section_header_options', array(
			'title'		=> esc_html__('Header Options','ifs-legacy'),
			'priority'	=> 30,
			'panel' => 'ifs_legacy_panel_header_setting'
		));


		$wp_customize->add_setting( 'ifs_legacy_header_layout_style', array(
			'default'           => ifs_legacy_get_theme_header_default(),
			'sanitize_callback' => 'sanitize_key',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( new IFS_Image_Select_Control($wp_customize, 'ifs_legacy_header_layout_style', array(
			'label'       => esc_html__( 'Header Layout', 'ifs-legacy' ),
			'description' => __( 'Choose a layout for the header.', 'ifs-legacy' ),
			'section'     => 'ifs_legacy_section_header_options',
			'setting'    => 'ifs_legacy_header_layout_style',
			'choices'     => ifs_legacy_theme_header_layout_options(),
			'priority'    => 10
		) ) );

	    $wp_customize->add_setting( 'ifs_legacy_header_background_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_header_background_color', array(
	        'label'		=> esc_html__('Header Background Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_header_options',
	        'setting'	=> 'ifs_legacy_header_background_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_header_border_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_header_border_color', array(
	        'label'		=> esc_html__('Header Border Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_header_options',
	        'setting'	=> 'ifs_legacy_header_border_color'
	    )));

	    $wp_customize->add_setting( 'header_textcolor', array(
			'default' 	=> '',
			'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'header_textcolor', array(
			'label'		=> esc_html__('Header Text Color', 'ifs-legacy'),
			'section'	=> 'ifs_legacy_section_header_options',
			'setting'	=> 'header_textcolor'
		)));

		$wp_customize->add_setting( 'ifs_legacy_header_menu_color', array(
			'default' 	=> '',
			'transport'	=> 'refresh',
			'sanitize_callback'	=> 'esc_attr'
		));

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_header_menu_color', array(
			'label'		=> esc_html__('Header Menu Color', 'ifs-legacy'),
			'section'	=> 'ifs_legacy_section_header_options',
			'setting'	=> 'ifs_legacy_header_menu_color'
		)));

		$wp_customize->add_setting( 'ifs_legacy_header_menuactive_color', array(
			'default' 	=> '',
			'transport'	=> 'refresh',
			'sanitize_callback'	=> 'esc_attr'
		));

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_header_menuactive_color', array(
			'label'		=> esc_html__('Header Menu Active Color', 'ifs-legacy'),
			'section'	=> 'ifs_legacy_section_header_options',
			'setting'	=> 'ifs_legacy_header_menuactive_color'
		)));

		$wp_customize->add_setting( 'ifs_legacy_header_submenu_color', array(
			'default' 	=> '',
			'transport'	=> 'refresh',
			'sanitize_callback'	=> 'esc_attr'
		));

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_header_submenu_color', array(
			'label'		=> esc_html__('Header Sub-menu Color', 'ifs-legacy'),
			'section'	=> 'ifs_legacy_section_header_options',
			'setting'	=> 'ifs_legacy_header_submenu_color'
		)));

		$wp_customize->add_setting( 'ifs_legacy_header_submenuactive_color', array(
			'default' 	=> '',
			'transport'	=> 'refresh',
			'sanitize_callback'	=> 'esc_attr'
		));

		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_header_submenuactive_color', array(
			'label'		=> esc_html__('Header Sub-menu Active Color', 'ifs-legacy'),
			'section'	=> 'ifs_legacy_section_header_options',
			'setting'	=> 'ifs_legacy_header_submenuactive_color'
		)));

	    $wp_customize->add_section('ifs_legacy_section_page_title_options', array(
			'title'		=> esc_html__('Page Title Options','ifs-legacy'),
			'priority'	=> 30,
			'panel' => 'ifs_legacy_panel_header_setting'
		));

	    $wp_customize->add_setting( 'ifs_legacy_show_page_title', array(
	        'default' 	=> 'true',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( 'ifs_legacy_show_page_title', array(
	        'label'		=> esc_html__('Show Page Title', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_page_title_options',
	        'setting'	=> 'ifs_legacy_show_page_title',
	        'type'      => 'select',
	        'choices'   => array(
	            'true'      => esc_html__('Yes', 'ifs-legacy'),
	            'false'     => esc_html__('No', 'ifs-legacy')
	        )
	    ));

	    $wp_customize->add_setting( 'ifs_legacy_page_title_background_image', array(
			'default'		=> '',
			'sanitize_callback'	=> 'esc_url_raw',
	        'transport'	=> 'refresh'
		));

	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ifs_legacy_page_title_background_image', array(
			'settings'		=> 'ifs_legacy_page_title_background_image',
			'section'		=> 'ifs_legacy_section_page_title_options',
			'label'			=> __( 'Page Title Background Image', 'ifs-legacy' ),
			'description'	=> __( 'Select the image to be used for Page Title Background. The background will cover the whole page title section.', 'ifs-legacy' )
		)));

		$wp_customize->add_setting( 'ifs_legacy_page_title_background_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_page_title_background_color', array(
	        'label'		=> esc_html__('Title Section Background Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_page_title_options',
	        'setting'	=> 'ifs_legacy_page_title_background_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_page_title_position', array(
			'default'		=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

	    $wp_customize->add_control( 'ifs_legacy_page_title_position', array(
			'settings'		=> 'ifs_legacy_page_title_position',
			'section'		=> 'ifs_legacy_section_page_title_options',
			'label'			=> __( 'Position', 'ifs-legacy' ),
			'description'	=> __( 'Select the position of the title.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => array(
	            ''              => __( 'Default', 'ifs-legacy' ),
	            'left'          => __( 'Left', 'ifs-legacy' ),
				'center'        => __( 'Center', 'ifs-legacy' ),
	            'right'         => __( 'Right', 'ifs-legacy' )
	        )
		));


	    $wp_customize->add_section('ifs_legacy_section_header_font_options', array(
			'title'		=> esc_html__('Header Font Options','ifs-legacy'),
			'priority'	=> 30,
			'panel' => 'ifs_legacy_panel_header_setting'
		));

	    $wp_customize->add_setting( 'ifs_legacy_sitetitle_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_sitetitle_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Site Title Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for site title font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_sitetitle_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_sitetitle_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_sitetitle_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Site Title Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your site title font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_sitetitle_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_sitetitle_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_sitetitle_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Site Title Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for site title.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_sitetitle_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_sitedesc_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_sitedesc_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Site Description Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for site description font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_sitedesc_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_sitedesc_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_sitedesc_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Site Description Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your site description font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_sitedesc_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_sitedesc_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_sitedesc_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Site Description Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for site description.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_sitedesc_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_menu_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_menu_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Menu Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for menu font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_menu_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_menu_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_menu_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Menu Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your menu font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_menu_font_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_menu_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_menu_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Menu Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for menu.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_menu_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

    		$wp_customize->add_setting( 'ifs_legacy_submenu_font', array(
			'default'           => ifs_legacy_theme_font_default(),
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_submenu_font', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Sub Menu Font', 'ifs-legacy' ),
			'description'	=> __( 'Choose the primary or secondary chosen font for sub menu font.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_submenu_font',
			'choices'		=> ifs_legacy_theme_font_options(),
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_submenu_font_size', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_submenu_font_size', array(
			'type'			=> 'number',
			'label'			=> esc_html__( 'Sub Menu Font Size', 'ifs-legacy' ),
			'description'	=> __( 'Input the font size for your sub menu font. In pixel (px).', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_menu_subfont_size',
			'priority'		=> 10
		) );

		$wp_customize->add_setting( 'ifs_legacy_submenu_font_weight', array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( 'ifs_legacy_submenu_font_weight', array(
			'type'			=> 'select',
			'label'			=> esc_html__( 'Sub Menu Font Weight', 'ifs-legacy' ),
			'description'	=> __( 'Choose the font weight for sub menu.', 'ifs-legacy' ),
			'section'		=> 'ifs_legacy_section_header_font_options',
			'setting'		=> 'ifs_legacy_submenu_font_weight',
			'choices'		=> ifs_legacy_theme_font_weight_options(),
			'priority'		=> 10
		) );

    $wp_customize->add_panel( 'ifs_legacy_panel_footer_setting', array(
		    'priority' => 10,
		    'capability' => 'edit_theme_options',
		    'theme_supports' => '',
		    'title' => esc_html__( 'Footer Settings', 'ifs-legacy' ),
		    'description' => esc_html__( 'Description of what this panel does.', 'ifs-legacy' ),
		)
	);

    $wp_customize->add_section('ifs_legacy_section_footer_options', array(
		'title'		=> esc_html__('Footer Widgets Options','ifs-legacy'),
		'priority'	=> 30,
		'panel' => 'ifs_legacy_panel_footer_setting'
	));

	    $wp_customize->add_setting( 'ifs_legacy_footer_layout_style', array(
			'default'           => 'footer-1',
			'sanitize_callback' => 'sanitize_key',
	        'transport'         => 'refresh'
		) );

		$wp_customize->add_control( new IFS_Image_Select_Control($wp_customize, 'ifs_legacy_footer_layout_style', array(
			'label'       => esc_html__( 'Footer Layout', 'ifs-legacy' ),
			'description' => __( 'Choose a layout for the footer.', 'ifs-legacy' ),
			'section'     => 'ifs_legacy_section_footer_options',
			'setting'    => 'ifs_legacy_footer_layout_style',
			'choices'     => ifs_legacy_theme_footer_layout_options(),
			'priority'    => 10
		) ) );

	    $wp_customize->add_setting( 'ifs_legacy_footer_text_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_footer_text_color', array(
	        'label'		=> esc_html__('Footer Text Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_footer_options',
	        'setting'	=> 'ifs_legacy_footer_text_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_footer_link_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_footer_link_color', array(
	        'label'		=> esc_html__('Footer Link Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_footer_options',
	        'setting'	=> 'ifs_legacy_footer_link_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_footer_background_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_footer_background_color', array(
	        'label'		=> esc_html__('Footer Background Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_footer_options',
	        'setting'	=> 'ifs_legacy_footer_background_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_footer_background_image', array(
			'default'		=> '',
			'sanitize_callback'	=> 'esc_url_raw',
	        'transport'	=> 'refresh'
		));

	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ifs_legacy_footer_background_image', array(
			'settings'		=> 'ifs_legacy_footer_background_image',
			'section'		=> 'ifs_legacy_section_footer_options',
			'label'			=> __( 'Footer Background Image', 'ifs-legacy' ),
			'description'	=> __( 'Select the image to be used for Footer Background. The background will cover the whole section.', 'ifs-legacy' )
		)));

    $wp_customize->add_section('ifs_legacy_section_footer_bar_options', array(
		'title'		=> esc_html__('Footer Bar Options','ifs-legacy'),
		'priority'	=> 30,
		'panel' => 'ifs_legacy_panel_footer_setting'
	));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_1_content', array(
			'default'		=> 'text',
			'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

	    $wp_customize->add_control( 'ifs_legacy_footer_bar_1_content', array(
			'settings'		=> 'ifs_legacy_footer_bar_1_content',
			'section'		=> 'ifs_legacy_section_footer_bar_options',
			'label'			=> __( 'Footer Bar 1 Content', 'ifs-legacy' ),
			'description'	=> __( 'Select the type of the content.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => ifs_legacy_footer_bar_choices()
		));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_1_text', array(
			'default'		=> '',
			'transport'	=> 'refresh',
	    'sanitize_callback'	=> 'ifs_legacy_custom_wp_kses'
		));

	    $wp_customize->add_control( 'ifs_legacy_footer_bar_1_text', array(
			'settings'		=> 'ifs_legacy_footer_bar_1_text',
			'section'		=> 'ifs_legacy_section_footer_bar_options',
			'label'			=> __( 'Footer Bar 1 Text', 'ifs-legacy' ),
			'description'	=> __( 'Input the content if you select "Text" as the content.', 'ifs-legacy' ),
	        'type'          => 'textarea'
		));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_2_content', array(
			'default'		=> '',
			'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
		));

	    $wp_customize->add_control( 'ifs_legacy_footer_bar_2_content', array(
			'settings'		=> 'ifs_legacy_footer_bar_2_content',
			'section'		=> 'ifs_legacy_section_footer_bar_options',
			'label'			=> __( 'Footer Bar 2 Content', 'ifs-legacy' ),
			'description'	=> __( 'Select the type of the content.', 'ifs-legacy' ),
	        'type'          => 'select',
	        'choices'       => ifs_legacy_footer_bar_choices()
		));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_2_text', array(
			'default'		=> '',
			'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'ifs_legacy_custom_wp_kses'
		));

	    $wp_customize->add_control( 'ifs_legacy_footer_bar_2_text', array(
			'settings'		=> 'ifs_legacy_footer_bar_2_text',
			'section'		=> 'ifs_legacy_section_footer_bar_options',
			'label'			=> __( 'Footer Bar 2 Text', 'ifs-legacy' ),
			'description'	=> __( 'Input the content if you select "Text" as the content.', 'ifs-legacy' ),
	        'type'          => 'textarea'
		));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_text_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_footer_bar_text_color', array(
	        'label'		=> esc_html__('Footer Bar Text Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_footer_bar_options',
	        'setting'	=> 'ifs_legacy_footer_bar_text_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_link_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_footer_bar_link_color', array(
	        'label'		=> esc_html__('Footer Bar Link Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_footer_bar_options',
	        'setting'	=> 'ifs_legacy_footer_bar_link_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_background_color', array(
	        'default' 	=> '',
	        'transport'	=> 'refresh',
	        'sanitize_callback'	=> 'esc_attr'
	    ));

	    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ifs_legacy_footer_bar_background_color', array(
	        'label'		=> esc_html__('Footer Bar Background Color', 'ifs-legacy'),
	        'section'	=> 'ifs_legacy_section_footer_bar_options',
	        'setting'	=> 'ifs_legacy_footer_bar_background_color'
	    )));

	    $wp_customize->add_setting( 'ifs_legacy_footer_bar_background_image', array(
			'default'		=> '',
			'sanitize_callback'	=> 'esc_url_raw',
	        'transport'	=> 'refresh'
		));

	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ifs_legacy_footer_bar_background_image', array(
			'settings'		=> 'ifs_legacy_footer_bar_background_image',
			'section'		=> 'ifs_legacy_section_footer_bar_options',
			'label'			=> __( 'Footer Bar Background Image', 'ifs-legacy' ),
			'description'	=> __( 'Select the image to be used for Footer Background. The background will cover the whole section.', 'ifs-legacy' )
		)));

}
add_action( 'customize_register', 'ifs_legacy_customize_register' );

/**
 * get the custom font options data
 *
 * @return array
 */
function ifs_legacy_custom_font_values( $custom_filters = '') {
	$all_fonts	= IFS_Fonts::get_all_fonts();
	$font_choices = array('' => esc_html__('Default', 'ifs-legacy'));
	foreach($all_fonts as $id => $font){
		$font_choices[$id] = $font['name'];
	}

	$filter = '';
	if($custom_filters!=''){
		$filter = '-'.$custom_filters;
	}
	return apply_filters( 'ifs_legacy_custom_font_1_values'.sanitize_key($filter), $font_choices);
}

/**
 * get available header layout
 *
 * @return array
 */
function ifs_legacy_theme_header_layout_options() {
	$headers = ifs_legacy_get_theme_headers();
	$header_layout_opt = array();
	foreach( $headers as $header_idx => $header_val ){
		$header_layout_opt[$header_idx] = array(
			'label' => $header_idx,
			'url'   => $header_val['png']
		);
	}

	return apply_filters('ifs_legacy_theme_header_layout_options', $header_layout_opt);
}

/**
 * get available footer layout
 *
 * @return array
 */
function ifs_legacy_theme_footer_layout_options() {
	$footers = ifs_legacy_get_theme_footers();
	$footer_layout_opt = array();
	foreach( $footers as $footer_idx => $footer_val ){
		$footer_layout_opt[$footer_idx] = array(
			'label' => $footer_idx,
			'url'   => $footer_val['png']
		);
	}
	return apply_filters('ifs_legacy_theme_footer_layout_options', $footer_layout_opt);
}

/**
 * get default theme font
 *
 * @return string
 */
function ifs_legacy_theme_font_default(){
	return apply_filters( 'ifs_legacy_theme_font_default', 'ifs_legacy_chosen_custom_font_1');
}

/**
 * get available theme font options
 *
 * @return array
 */
function ifs_legacy_theme_font_options(){
	return apply_filters( 'ifs_legacy_theme_font_options', array(
		'ifs_legacy_chosen_custom_font_1' => esc_html__('Primary Chosen Font', 'ifs-legacy'),
		'ifs_legacy_chosen_custom_font_2' => esc_html__('Secondary Chosen Font', 'ifs-legacy'),
		'ifs_legacy_chosen_custom_font_3' => esc_html__('Tertiary Chosen Font', 'ifs-legacy')
	));
}

/**
 * get available theme font weight options
 *
 * @return array
 */
function ifs_legacy_theme_font_weight_options(){
	return apply_filters( 'ifs_legacy_theme_font_weight_options', array(
		''		=> esc_html__('Default', 'ifs-legacy'),
		'100'	=> esc_html__('100', 'ifs-legacy'),
		'200'	=> esc_html__('200', 'ifs-legacy'),
		'300'	=> esc_html__('300', 'ifs-legacy'),
		'400'	=> esc_html__('400 (Normal)', 'ifs-legacy'),
		'500'	=> esc_html__('500', 'ifs-legacy'),
		'600'	=> esc_html__('600', 'ifs-legacy'),
		'700'	=> esc_html__('700 (Bold)', 'ifs-legacy'),
		'800'	=> esc_html__('800', 'ifs-legacy'),
		'900'	=> esc_html__('900', 'ifs-legacy')
	));
}

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
