<?php

require get_template_directory() . '/inc/metabox-generator/metaboxes.php';

function ifs_legacy_set_metaboxes(){

	/* Option */
	$ifs_optonoff = array(
		'true' => esc_html__('On', "ifs-legacy"),
		'false' => esc_html__('Off', "ifs-legacy")
	);

	$ifs_optyesno = array(
		'true' => esc_html__('Yes', "ifs-legacy"),
		'false' => esc_html__('No', "ifs-legacy")
	);

    $ifs_optdefyesno = array(
		'' => esc_html__('Default', "ifs-legacy"),
        'true' => esc_html__('Yes', "ifs-legacy"),
		'false' => esc_html__('No', "ifs-legacy")
	);

    $ifs_arrweblayout   = array(
        'default'   => esc_html__('Default Theme Layout', "ifs-legacy")
    );

	$headers = ifs_legacy_get_theme_headers();
    $header_layout_opt = array(
		'default'	=> esc_html__('Default', "ifs-legacy")
	);
    foreach( $headers as $header_idx => $header_val ){
        $header_layout_opt[$header_idx] = $header_idx;
    }

    $ifs_optWebLayout	= apply_filters('ifs_legacy_output_optweblayout', $ifs_arrweblayout);

    $ifs_optMetaWebLayout   = array_merge($ifs_arrweblayout, $ifs_optWebLayout);

	$ifs_optlayout = array(
		'' => esc_html__('Default', "ifs-legacy"),
		'left' => esc_html__('Left', "ifs-legacy"),
		'right' => esc_html__('Right', "ifs-legacy")
	);

	$ifs_optccontainer = array(
		'default' => 'Default',
		'ifsfullwidthcontent' => esc_html__('100% Full-Width', "ifs-legacy")
	);

	$ifs_optarrange = array(
		'ASC' => esc_html__('Ascending', "ifs-legacy"),
		'DESC' => esc_html__('Descending', "ifs-legacy")
	);

	$ifs_optbgrepeat = array(
		'' => 'Default',
		'repeat' => 'repeat',
		'no-repeat' => 'no-repeat',
		'repeat-x' => 'repeat-x',
		'repeat-y' => 'repeat-y'
	);

	$ifs_optbgattch = array(
		'' => 'Default',
		'scroll' => 'scroll',
		'fixed' => 'fixed'
	);

	$ifs_imagepath =  get_template_directory_uri() . '/images/backendimage/';
	$ifs_optlayoutimg = array(
		'default' => $ifs_imagepath.'mb-default.png',
		'one-col' => $ifs_imagepath.'mb-1c.png',
		'two-col-left' => $ifs_imagepath.'mb-2cl.png',
		'two-col-right' => $ifs_imagepath.'mb-2cr.png'
	);
	$ifs_optlayout = array(
		'default' => esc_html__('Default',"ifs-legacy")
	);
	$ifs_optlayout = array_merge( $ifs_optlayout, ifs_legacy_content_layout_choices() );

	$footers = ifs_legacy_get_theme_footers();
    $footer_layout_opt = array(
		'default'	=> esc_html__('Default', "ifs-legacy")
	);
    foreach( $footers as $footer_idx => $footer_val ){
        $footer_layout_opt[$footer_idx] = $footer_idx;
    }

	// Create meta box slider
	$ifs_legacy_meta_boxes = array();

	$ifs_legacy_meta_boxes[] = array(
		'id' => 'post-option-meta-box',
		'title' => esc_html__('Post Options',"ifs-legacy"),
		'page' => 'post',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Content Layout',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default site layout.',"ifs-legacy").'</em>',
				'options' => $ifs_optlayout,
				'id' => 'ifs_content_layout',
				'type' => 'select',
				'std' => 'default'
			),
			array(
				'name' => esc_html__('External URL',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input your external link in here. if you use "Link" format.',"ifs-legacy").'</em>',
				'id' => 'ifs_external_url',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Audio File URL',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input your audio file URL in here. ',"ifs-legacy").'</em>',
				'id' => 'ifs_audio_url',
				'type' => 'textarea',
				'std' => ''
			),
			array(
				'name' => esc_html__('Video File URL / Video Link',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input your video file URL or video link like youtube or vimeo in here. ',"ifs-legacy").'</em>',
				'id' => 'ifs_video_url',
				'type' => 'textarea',
				'std' => ''
			)
		)
	);


	$ifs_legacy_meta_boxes[] = array(
		'id' => 'page-option-meta-box',
		'title' => esc_html__('Page Options',"ifs-legacy"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Content Layout',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default content layout.',"ifs-legacy").'</em>',
				'options' => $ifs_optlayout,
				'id' => 'ifs_content_layout',
				'type' => 'select',
				'std' => 'default'
			),
            array(
				'name' => esc_html__('Header Type',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Select the header layout that you want on this specific post/page. Overrides default header layout.',"ifs-legacy").'</em>',
				'id' => 'ifs_header_type',
				'type' => 'select',
				'options' => $header_layout_opt,
				'std' => 'default'
			),
			array(
				'name' => esc_html__('Enable Breadcrumb',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Choose \'Yes\' if you want to show breadcrumb.',"ifs-legacy").'</em>',
				'id' => 'ifs_show_breadcrumb',
				'type' => 'select',
				'options' => $ifs_optyesno,
				'std' => 'true'
			),
			array(
				'name' => esc_html__('Show Page Title',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Choose \'No\' if you want to remove the page title.',"ifs-legacy").'</em>',
				'id' => 'ifs_show_title',
				'type' => 'select',
				'options' => $ifs_optdefyesno,
				'std' => ''
			),
			array(
				'name' => esc_html__('Main Content Padding Top',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input the padding top value in pixel. example : 12px',"ifs-legacy").'</em>',
				'id' => 'ifs_main_paddingtop',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Main Content Padding Bottom',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input the padding bottom value in pixel. example : 12px',"ifs-legacy").'</em>',
				'id' => 'ifs_main_paddingbottom',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Background Header',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input the image URL in this textbox if you want to change the background image on the header.',"ifs-legacy").'</em>',
				'id' => 'ifs_bg_header',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Background Color Maincontent',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input the hexcolor in this textbox if you want to change the background color of your content.',"ifs-legacy").'</em>',
				'id' => 'ifs_bg_color_maincontent',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Page Description',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Input your own page description here.',"ifs-legacy").'</em>',
				'id' => 'ifs_pagedesc',
				'type' => 'text',
				'std' => ''
			),
            array(
				'name' => esc_html__('Footer Sidebar Type',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Select the footer layout that you want on this specific post/page. Overrides default footer layout.',"ifs-legacy").'</em>',
				'id' => 'ifs_footer_sidebar_type',
				'type' => 'select',
				'options' => $footer_layout_opt,
				'std' => ''
			),
            array(
				'name' => esc_html__('Show Footer Bar',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Choose \'No\' if you want to remove the footer bar.',"ifs-legacy").'</em>',
				'id' => 'ifs_show_footer_bar',
				'type' => 'select',
				'options' => $ifs_optdefyesno,
				'std' => ''
			)
		)
	);

	$ifs_legacy_meta_boxes[] = array(
		'id' => 'page-blog-option-meta-box',
		'title' => esc_html__('Page Blog Options',"ifs-legacy"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Blog Categories',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('You need to tick the blog categories to make the template blog works.',"ifs-legacy").'</em>',
				'id' => 'ifs_blog_category',
				'type' => 'checkbox-blog-categories',
				'std' => ''
			)
		)
	);

	$ifs_legacy_meta_boxes[] = array(
		'id' => 'product-option-meta-box',
		'title' => esc_html__('Product Options',"ifs-legacy"),
		'page' => 'product',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default site layout.',"ifs-legacy").'</em>',
				'options' => $ifs_optlayoutimg,
				'id' => 'ifs_content_layout',
				'type' => 'selectimage',
				'std' => ''
			),
			array(
				'name' => esc_html__('Disable Page Title',"ifs-legacy"),
				'desc' => '<em>'.esc_html__('Choose \'Yes\' if you want to remove the page title.',"ifs-legacy").'</em>',
				'id' => 'ifs_disable_title',
				'type' => 'select',
				'options' => $ifs_optyesno,
				'std' => 'false'
			)
		)
	);

    return $ifs_legacy_meta_boxes;

}
