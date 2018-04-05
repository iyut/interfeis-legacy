<?php

class IFS_Google_Font_Select_Control extends WP_Customize_Control{

	/**
	 * The type of customize control being rendered.
	 *
	 * @access public
	 * @since  1.1
	 * @var    string
	 */
	public $type = 'select-google-font';

	/**
	 * Add custom JSON parameters to use in the JS template.
	 *
	 * @access public
	 * @since  1.1
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Create the image URL. Replaces the %s placeholder with the URL to the customizer /images/ directory.

		$default_fonts	= IFS_Fonts::get_default_fonts();
		$google_fonts	= IFS_Fonts::get_google_fonts();
		$all_fonts		= array_merge($default_fonts, $google_fonts);

		$choices 		= array();
		foreach ( $default_fonts as $id => $val ) {
			$choices[$id] 	= $val;
			$variants 		= implode(',', $val['font_weights']);

			$choices[$id]['variant'] = esc_attr($variants);
		}

		$google_choices = array();
		foreach ( $google_fonts as $id => $val ) {
			$google_choices[$id] 	= $val;
			$variants 		= implode(',', $val['font_weights']);

			$google_choices[$id]['variant'] = esc_attr($variants);
		}

		$this->json['choices'] = $choices;
		$this->json['google_choices'] = $google_choices;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = $this->value();
		$this->json['id']      = $this->id;
	}

	/**
	 * An Underscore (JS) template for this control's content.
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see    WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since  1.1
	 * @return void
	 */
	protected function content_template() {
		?>
		<# if ( ! data.choices ) {
			return;
		} #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<select id="{{ data.id }}" class="ifs-select ifs-select-font" name="_customize-{{data.type}}-{{data.id}}">
			<optgroup label="Default Fonts">
			<# for ( key in data.choices ) { #>
				<option value="{{ key }}">{{ data.choices[key]['name'] }}</option>
			<# } #>
			</optgroup>

			<optgroup label="Google Fonts">
			<# for ( key in data.google_choices ) { #>
				<option value="{{ key }}">{{ data.google_choices[key]['name'] }}</option>
			<# } #>
			</optgroup>
		</select>


		<?php
	}

}
