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
	echo '<input type="hidden" name="mytheme_meta_box_nonce" value="'. esc_attr( wp_create_nonce(basename(__FILE__)) ) .'" />';

	ifs_legacy_create_metabox($meta_array);
}


function ifs_legacy_row2c_metabox($id, $name){
?>
	<tr>
		<th style="width:20%;border-bottom:1px solid #e4e4e4;padding:15px 0px">
			<label for="<?php echo esc_attr( $id ); ?>">
				<?php echo esc_html($name); ?>
			</label>
		</th>
		<td style="border-bottom:1px solid #e4e4e4;padding:15px 0px">
<?php
}

function ifs_legacy_row1c_metabox(){
?>
	<tr>
		<td colspan="2" style="border-bottom:1px solid #e4e4e4;padding:15px 0px">
<?php
}
// Create Metabox Form Table
function ifs_legacy_create_metabox($meta_box){

	global $post;

	$returnstring = "";
	?>

	<table class="form-table">

	<?php
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);

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

				ifs_legacy_row2c_metabox($field['id'], $field['name']);
				?>

				<?php echo $prefixinput; ?>

				<input type="text" name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr($textvalue); ?>" size="30" style="width:<?php echo esc_attr($widthinput); ?>" />

				<?php echo $postfixinput; ?>
					<br /> <?php echo ifs_legacy_custom_wp_kses($field['desc']); ?>
				<?php
				break;


//If Text Area
			case 'textarea':
				$textvalue = $meta ? $meta : $field['std'];

				ifs_legacy_row2c_metabox($field['id'], $field['name']);
				?>

				<textarea
					name="<?php echo esc_attr( $field['id'] ); ?>"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					cols="60"
					rows="4"
					style="width:97%"><?php echo esc_textarea($textvalue); ?></textarea>
					<br /> <?php echo ($field['desc']); ?>

				<?php
				break;

			case 'imagegallery':
				$textvalue = $meta ? $meta : $field['std'];

				ifs_legacy_row1c_metabox();
				?>
				<div id="nvrpost_images_container">
					<ul class="nvrpost_images">
					<?php
						$product_image_gallery = $textvalue;
						$attachments = array_filter( explode( ',', $product_image_gallery ) );

						if ( $attachments ) {
							foreach ( $attachments as $attachment_id ) {
							?>
								<li class="image" data-attachment_id="<?php echo esc_attr( $attachment_id ); ?>">
									<?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?>
									<ul class="actions">
										<li>
											<a href="#" class="delete tips" data-tip="<?php esc_attr_e( 'Delete image', "ifs-legacy" ); ?>">
												<?php esc_html_e( 'Delete', "ifs-legacy" ); ?>
											</a>
										</li>
									</ul>
								</li>
							<?php
							}
						}
					?>
					</ul>

					<input
						type="hidden"
						id="<?php echo esc_attr( $field['id'] ); ?>"
						name="<?php echo esc_attr( $field['id'] ); ?>"
						value="<?php echo esc_attr( $textvalue ); ?>" />

				</div>

				<p class="add_nvrpost_images hide-if-no-js">
					<a href="#"
						data-choose="<?php esc_attr_e( 'Add Images to Post Gallery', "ifs-legacy" ); ?>"
						data-update="<?php esc_attr_e( 'Add to gallery', "ifs-legacy" ); ?>"
						data-delete="<?php esc_attr_e( 'Delete image', "ifs-legacy" ); ?>"
						data-text="<?php esc_attr_e( 'Delete', "ifs-legacy" ); ?>">
						<?php esc_html_e( 'Add post gallery images', "ifs-legacy" ); ?>
					</a>
				</p>
				<?php
				break;

//If Select Combobox
			case 'select':
				$optvalue = $meta ? $meta : $field['std'];

				ifs_legacy_row2c_metabox($field['id'], $field['name']);
				?>

				<select
					name="<?php echo esc_attr( $field['id'] ); ?>"
					id="<?php echo esc_attr( $field['id'] ); ?>">

					<?php foreach ($field['options'] as $option => $val){ ?>
						<option
							value="<?php echo esc_attr( $option ); ?>"
							<?php echo ($optvalue==$option)? 'selected="selected"' : ''; ?> >
							<?php echo esc_html($val); ?>
						</option>
					<?php } ?>

				</select>
				<br /> <?php echo ifs_legacy_custom_wp_kses($field['desc']); ?>

				<?php
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

				ifs_legacy_row2c_metabox($field['id'], $field['name']);
				?>

				<select
					name="<?php echo esc_attr( $field['id'] ); ?>"
					id="<?php echo esc_attr( $field['id'] ); ?>">

					<?php foreach ($field['options'] as $option => $val){ ?>
						<option
							value="<?php echo esc_attr( $option ); ?>"
							<?php echo ($optvalue==$option)? 'selected="selected"' : ''; ?> >
							<?php echo esc_html($val); ?>
						</option>
					<?php } ?>

				</select>
				<br /> <?php echo ifs_legacy_custom_wp_kses($field['desc']); ?>

				<?php
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

				ifs_legacy_row2c_metabox($field['id'], $field['name']);
				?>

				<?php foreach($portcategories as $category){ ?>

					<div style="float:left;width:30%;">
						<input
							type="checkbox"
							value="<?php echo esc_attr( $category->slug ); ?>"
							name="<?php echo esc_attr( $field['id']. "['" .$category->slug. "']" ); ?>"
							id="<?php echo esc_attr( $field['id']."-". $category->name ); ?>"
							<?php echo in_array($category->slug,$chkvalue)? 'checked="checked"' : '' ?>
						/>

						&nbsp;&nbsp; <?php echo esc_html( $category->name ); ?>

					</div>
				<?php } ?>
				<div style="clear:both;"></div>
				<br /> <?php echo ifs_legacy_custom_wp_kses( $field['desc'] ); ?>

				<?php
				break;

//If Select Image
			case 'selectimage':
				$optvalue = $meta ? $meta : $field['std'];

				ifs_legacy_row2c_metabox($field['id'], $field['name']);

				foreach ($field['options'] as $option => $val){
					$selectedstr = ($optvalue==$option)? 'optselected' : '';
					$checkedstr = ($optvalue==$option)? 'checked="checked"' : '';
				?>
					<img
						src="<?php echo esc_url( $val ); ?>"
						class="optionimg <?php echo esc_attr( $selectedstr ); ?>"
						onclick="<?php echo esc_js( 'document.getElementById("'.$field['id'].$option.'").checked=true' ); ?>"
						style="display:inline-block;"
					/>
					<input
						type="radio"
						name="<?php echo esc_attr( $field['id'] ); ?>"
						id="<?php echo esc_attr( $field['id'].$option ); ?>"
						value="<?php echo esc_attr( $option ); ?>"
						<?php echo ($optvalue==$option)? 'checked="checked"' : ''; ?>
						style="display:none;"
					/>
				<?php
				}
				?>
				<br /> <?php echo ifs_legacy_custom_wp_kses( $field['desc'] ); ?>

				<?php
				break;

//If Checkbox
			case 'checkbox':
				$chkvalue = $meta ? true : $field['std'];
				$checkedstr = ($chkvalue)? 'checked="checked"' : '';

				ifs_legacy_row2c_metabox($field['id'], $field['name']);

				?>
				<input
					type="checkbox"
					name="<?php echo esc_attr( $field['id'] ); ?>"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					<?php echo ($chkvalue)? 'checked="checked"' : ''; ?>
					style="display:none;"
				/>
				<br /> <?php echo ifs_legacy_custom_wp_kses( $field['desc'] ); ?>

				<?php
				break;

//If Button
			case 'button':
				$buttonvalue = $meta ? $meta : $field['std'] ;

				ifs_legacy_row2c_metabox($field['id'], $field['name']);

				?>

				<input
					type="button"
					name="<?php echo esc_attr( $field['id'] ); ?>"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					value="<?php echo esc_attr( $buttonvalue ); ?>"
				/>
				<br /> <?php echo ifs_legacy_custom_wp_kses( $field['desc'] ); ?>

				<?php
				break;



		}
		?>
			</td>
		</tr>
	<?php
	} // END for each
	?>
	</table>

	<?php

}//END : ifs_legacy_create_metabox


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
					update_post_meta($post_id, $field['id'], sanitize_text_field($new));
				}
			}
		}
	}
}
