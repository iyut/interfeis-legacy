<?php
add_action('after_setup_theme', 'ifs_legacy_add_meta_boxes',40);
function ifs_legacy_add_meta_boxes(){
	add_action('add_meta_boxes', 'ifs_legacy_add_metabox');
}

// Add meta box
function ifs_legacy_add_metabox() {

	$ifs_legacy_meta_boxes = array();

    if(function_exists("ifs_legacy_set_metaboxes")){
        $ifs_legacy_meta_boxes = ifs_legacy_set_metaboxes();
    }
	if(is_array($ifs_legacy_meta_boxes)){
		foreach($ifs_legacy_meta_boxes as $ifs_legacy_meta_box){
			$metaargs = array(
				'meta_array' => $ifs_legacy_meta_box
			);
			add_meta_box($ifs_legacy_meta_box['id'], $ifs_legacy_meta_box['title'], $ifs_legacy_meta_box['showbox'], $ifs_legacy_meta_box['page'], $ifs_legacy_meta_box['context'], $ifs_legacy_meta_box['priority'], $metaargs);
		}
	}
}

function meta_option_show_box($post, $metaargs) {
	$ifs_legacy_meta_boxes = array();

    if(function_exists("ifs_legacy_set_metaboxes")){
        $ifs_legacy_meta_boxes = ifs_legacy_set_metaboxes();
    }

	$meta_array = $metaargs['args']['meta_array'];
	// Use nonce for verification
	echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo ifs_legacy_create_metabox($meta_array);
}


// Create Metabox Form Table
function ifs_legacy_create_metabox($meta_box){

	global $post;

	$returnstring = "";
	$returnstring .= '<table class="form-table">';

	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);

		$row2c = '<tr>'.
				 '<th style="width:20%;border-bottom:1px solid #e4e4e4;padding:15px 0px"><label for="'. esc_attr( $field['id'] ). '">'.$field['name']. '</label></th>'.
				 '<td style="border-bottom:1px solid #e4e4e4;padding:15px 0px">';

		$row1c = '<tr>'.
				 '<td colspan="2" style="border-bottom:1px solid #e4e4e4;padding:15px 0px">';

		switch ($field['type']) {

//If Text
			case 'text':
				$textvalue = $meta ? $meta : $field['std'];
				$widthinput = "97%";
				$prefixinput = "";
				$postfixinput = "";
				if(isset($field['class'])){
					if($field['class']=="mini"){
						$widthinput = "20%";
					}
				}
				if(isset($field['prefix'])){
					$prefixinput = stripslashes(trim($field['prefix']));
				}
				if(isset($field['postfix'])){
					$postfixinput = stripslashes(trim($field['postfix']));
				}
				$returnstring .= $row2c;
				$returnstring .= $prefixinput.'<input type="text" name="'. esc_attr( $field['id'] ) . '" id="'. esc_attr( $field['id'] ) . '" value="'. esc_attr($textvalue) .'" size="30" style="width:'.$widthinput.'" /> '.$postfixinput.
					'<br />'.$field['desc'];
				break;


//If Text Area
			case 'textarea':
				$textvalue = $meta ? $meta : $field['std'];
				$returnstring .= $row2c;
				$returnstring .= '<textarea name="'. esc_attr( $field['id'] ) . '" id="'. esc_attr( $field['id'] ). '" cols="60" rows="4" style="width:97%">'. esc_textarea($textvalue) .'</textarea>'.
					'<br />'.$field['desc'];
				break;

			case 'imagegallery':
				$textvalue = $meta ? $meta : $field['std'];

				$returnstring .= $row1c;
				$returnstring .= '<div id="nvrpost_images_container">';
				$returnstring .= '<ul class="nvrpost_images">';
							$product_image_gallery = $textvalue;
							$attachments = array_filter( explode( ',', $product_image_gallery ) );
							$imagelists ='';
							if ( $attachments ) {
								foreach ( $attachments as $attachment_id ) {
									$imagelists .='<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
										' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
										<ul class="actions">
											<li><a href="#" class="delete tips" data-tip="' .esc_attr__( 'Delete image', "ifs-legacy" ) . '">' . esc_html__( 'Delete', "ifs-legacy" ) . '</a></li>
										</ul>
									</li>';
								}
							}
				$returnstring .= $imagelists;
				$returnstring .= '</ul>';

				$returnstring .= '<input type="hidden" id="'.esc_attr( $field['id'] ).'" name="'.esc_attr( $field['id'] ).'" value="'. esc_attr( $textvalue ) .'" />';

				$returnstring .= '</div>';
				$returnstring .= '<p class="add_nvrpost_images hide-if-no-js">';
				$returnstring .= '<a href="#" data-choose="'. esc_attr__( 'Add Images to Post Gallery', "ifs-legacy" ) .'" data-update="'. esc_attr__( 'Add to gallery', "ifs-legacy" ) .'" data-delete="'. esc_attr__( 'Delete image', "ifs-legacy" ) .'" data-text="'. esc_attr__( 'Delete', "ifs-legacy" ) .'">'. esc_html__( 'Add post gallery images', "ifs-legacy" ) .'</a>';
				$returnstring .= '</p>';
				break;

//If Select Combobox
			case 'select':
				$optvalue = $meta ? $meta : $field['std'];
				$returnstring .= $row2c;
				$returnstring .= '<select name="'. esc_attr( $field['id'] ) . '" id="'. esc_attr( $field['id'] ) . '">';
				foreach ($field['options'] as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.esc_attr( $option ).'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';
				$returnstring .= '<br />'.$field['desc'];
				break;

			case 'select-blog-category':
				$optvalue = $meta ? $meta : $field['std'];

				// Pull all the categories into an array
				$options_categories = array();
				$options_categories_obj = get_categories();
				$options_categories["allcategories"] =esc_html__('Select Post Category',"ifs-legacy");
				foreach ($options_categories_obj as $category) {
					$options_categories[$category->slug] = $category->cat_name;
				}

				$returnstring .= $row2c;
				$returnstring .= '<select name="'. esc_attr( $field['id'] ). '" id="'. esc_attr( $field['id'] ). '">';
				foreach ($options_categories as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.esc_attr( $option ).'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';

				$returnstring .= '<br />'.$field['desc'];
				break;

//If Checkbox for Blog Categories
			case 'checkbox-blog-categories':
				$chkvalue = $meta ? $meta : $field['std'];
				$chkvalue = explode(",",$chkvalue);
				$args = array(
					"type" 			=> "post",
					"taxonomy" 	=> "category"
				);
				$portcategories = get_categories($args);

				$returnstring .= $row2c;
				foreach($portcategories as $category){
					$checkedstr="";
					if(in_array($category->slug,$chkvalue)){
						$checkedstr = 'checked="checked"';
					}
					$returnstring .= '<div style="float:left;width:30%;">';
					$returnstring .= '<input type="checkbox" value="'. esc_attr( $category->slug ) .'" name="'. esc_attr( $field['id']. '[\''.$category->slug.'\']' ) . '" id="'. esc_attr( $field['id']."-". $category->name ) . '" '.$checkedstr.' />&nbsp;&nbsp;'. $category->name;
					$returnstring .= '</div>';
				}
				$returnstring .= '<div style="clear:both;"></div><br />'.$field['desc'];
				break;

//If Select Image
			case 'selectimage':
				$optvalue = $meta ? $meta : $field['std'];

				$returnstring .= $row2c;
				foreach ($field['options'] as $option => $val){
					$selectedstr = ($optvalue==$option)? 'optselected' : '';
					$checkedstr = ($optvalue==$option)? 'checked="checked"' : '';
					$returnstring .= '<img src="'.esc_url( $val ) .'" class="optionimg '.esc_attr( $selectedstr ) .'" onclick="'. esc_js( 'document.getElementById("'.$field['id'].$option.'").checked=true' ) .'" style="display:inline-block;" />';
					$returnstring .= '<input type="radio" name="'. esc_attr( $field['id'] ) .'" id="'. esc_attr( $field['id'].$option ) .'" value="'.esc_attr( $option ).'" '.$checkedstr.' style="display:none;"/>';
				}
				$returnstring .= '<br />'.$field['desc'];
				break;

//If Checkbox
			case 'checkbox':
				$chkvalue = $meta ? true : $field['std'];
				$checkedstr = ($chkvalue)? 'checked="checked"' : '';

				$returnstring .= $row2c;
				$returnstring .= '<input type="checkbox" name="'. esc_attr( $field['id'] ) . '" id="'. esc_attr( $field['id'] ) . '" '.$checkedstr.' />';
				$returnstring .= '<br />'.$field['desc'];
				break;

//If Button
			case 'button':
				$buttonvalue = $meta ? $meta : $field['std'] ;

				$returnstring .= $row2c;
				$returnstring .= '<input type="button" name="'. esc_attr( $field['id'] ) . '" id="'. esc_attr( $field['id'] ) . '"value="'. esc_attr( $buttonvalue ) . '" />';
				$returnstring .= '<br />'.$field['desc'];
				break;



		}
		$returnstring .= 	'</td>'.
						'</tr>';
	}

	$returnstring .= '</table>';

	return $returnstring;

}//END : nvr_create_metabox


add_action('save_post', 'ifs_legacy_meta_save_data');


// Save data from meta box
function ifs_legacy_meta_save_data($post_id) {
	$ifs_legacy_meta_boxes = array();

    if(function_exists("ifs_legacy_set_metaboxes")){
        $ifs_legacy_meta_boxes = ifs_legacy_set_metaboxes();
    }

	// verify nonce
	if(isset($_POST['mytheme_meta_box_nonce'])){
		if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
			return $post_id;
		}
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == isset($_POST['post_type'])) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	$post_id = absint( $post_id );

	if(is_array($ifs_legacy_meta_boxes)){
		foreach($ifs_legacy_meta_boxes as $meta_box){
			foreach ($meta_box['fields'] as $field) {
				$old = get_post_meta($post_id, $field['id'], true);
				$new = (isset($_POST[$field['id']]))? $_POST[$field['id']] : "";

				if($field['type']=='checkbox-blog-categories'){
					if(isset($_POST[$field['id']]) && is_array($_POST[$field['id']]) && count($_POST[$field['id']])>0){
						$values = array_values($_POST[$field['id']]);
						$valuestring = implode(",",$values);
						$new = $valuestring;

					}else{
						$_POST[$field['id']] = $new = "";
					}
				}

				if($field['type']=='checkbox'){
					if(!isset($_POST[$field['id']])){
						$_POST[$field['id']] = $new = false;
					}
				}

				if (isset($_POST[$field['id']]) && $new != $old && (!isset($_POST['_inline_edit']) && !isset($_GET['bulk_edit']))) {
					update_post_meta($post_id, $field['id'], $new);
				}
			}
		}
	}
}
