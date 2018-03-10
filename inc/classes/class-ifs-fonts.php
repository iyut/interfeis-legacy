<?php
class IFS_Fonts{

	/**
	 * Get Default Websafe Fonts
	 *
	 * Defines a list of default websafe fonts and generates
	 * an array with all of the necessary properties. Returns
	 * all of the fonts as an array to the user.
	 *
	 * Custom Filters:
	 *     - 'ifs_font_default_fonts_array'
	 *     - 'ifs_font_get_default_fonts'
	 *
	 * Transients:
	 *     - 'ifs_font_default_fonts'
	 *
	 * @return array $fonts - All websafe fonts with their properties
	 *
	 * @since 1.2
	 * @version 1.4.3
	 *
	 */
	public static function get_default_fonts() {
		if ( false === get_transient( 'ifs_font_default_fonts' ) ) {

			// Declare default font list
			$font_list = array(
					'Arial'               => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Century Gothic'      => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Courier New'         => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Georgia'             => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Helvetica'           => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Impact'              => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Lucida Console'      => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Lucida Sans Unicode' => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Palatino Linotype'   => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'sans-serif'          => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'serif'               => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Tahoma'              => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Trebuchet MS'        => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
					'Verdana'             => array( 'weights' => array( '400', '400italic', '700', '700italic' ) ),
			);

			// Build font list to return
			$fonts = array();
			foreach ( $font_list as $font => $attributes ) {

				$urls = array();

				// Get font properties from json array.
				foreach ( $attributes['weights'] as $variant ) {
					$urls[ $variant ] = "";
				}

				// Create a font array containing it's properties and add it to the $fonts array
				$atts = array(
						'name'         => $font,
						'font_type'    => 'default',
						'font_weights' => $attributes['weights'],
						'subsets'      => array(),
						'files'        => array(),
						'urls'         => $urls,
						'url'		   => ''
				);

				// Add this font to all of the fonts
				$id           = strtolower( str_replace( ' ', '_', $font ) );
				$fonts[ $id ] = $atts;
			}

			// Filter to allow us to modify the fonts array before saving the transient
			$fonts = apply_filters( 'ifs_font_default_fonts_array', $fonts );

			// Set transient for google fonts (for 2 weeks)
			set_transient( 'ifs_font_default_fonts', $fonts, 1 * DAY_IN_SECONDS );

		} else {
			$fonts = get_transient( 'ifs_font_default_fonts' );
		}

		// Return the font list
		return apply_filters( 'ifs_font_get_default_fonts', $fonts );
	}

	/**
	 * Get Default Google Fonts
	 *
	 * Fetches all of the current fonts as a JSON object using
	 * the google font API and outputs it as a PHP Array. This
	 * is an internal function designed to flag outdated and
	 * new fonts so that we can update the fonts array list
	 * accordingly. Falls back to retrieving a manual list if
	 * the json request was unsuccessful.
	 *
	 *
	 * Custom Filters:
	 *     - 'ifs_font_google_fonts_array'
	 *     - 'ifs_font_get_google_fonts'
	 *
	 * Transients:
	 *     - 'ifs_font_google_fonts'
	 *
	 * @return array $fonts - All websafe fonts with their properties
	 *
	 * @since 1.0
	 * @version 1.0
	 *
	 */
	public static function get_google_fonts() {
		/**
		 * Google Fonts API Key
		 *
		 * Please enter the developer API Key for unlimited requests
		 * to google to retrieve all fonts. If you do not enter an API
		 * key google will
		 *
		 * {@link https://developers.google.com/fonts/docs/developer_api}
		 */

		// Variable to hold fonts;
		$fonts = array();
		$json  = array();

		// Check if transient is set
		if ( false === get_transient( 'ifs_font_google_fonts_list' )) {


			$json  = wp_remote_fopen( get_template_directory_uri() . '/inc/customizer/js/webfont.json' );

			$font_output = json_decode( $json, true );

			foreach ( $font_output['items'] as $item ) {

				$urls = array();

				$name = str_replace( ' ', '+', $item['family'] );
				$imp_variant = implode(',',$item['variants']);
				$url = 'https://fonts.googleapis.com/css?family='.$name.':'.$imp_variant;
				// Get font properties from json array.
				foreach ( $item['variants'] as $variant ) {

					$urls[ $variant ] = 'https://fonts.googleapis.com/css?family='.$name.':'.$variant;

				}

				$atts = array(
					'name'         => $item['family'],
					'category'     => $item['category'],
					'font_type'    => 'google',
					'font_weights' => $item['variants'],
					'subsets'      => $item['subsets'],
					'files'        => $item['files'],
					'urls'         => $urls,
					'url'		   => $url
				);

				// Add this font to the fonts array
				$id           = strtolower( str_replace( ' ', '_', $item['family'] ) );
				$fonts[ $id ] = $atts;

			}

			// Filter to allow us to modify the fonts array before saving the transient
			$fonts = apply_filters( 'ifs_font_google_fonts_array', $fonts );

			// Set transient for google fonts
			set_transient( 'ifs_font_google_fonts_list', $fonts, 1 * DAY_IN_SECONDS );

		} else {
			$fonts = get_transient( 'ifs_font_google_fonts_list' );
		}

		return apply_filters( 'ifs_font_get_google_fonts', $fonts );
	}

    /**
	 * Get all fonts
	 *
	 * Merge the default font and google font into one array.
	 *
	 *
	 * Custom Filters:
	 *     - 'ifs_google_font_get_all_fonts'
	 *
	 * @return array $fonts - All websafe fonts with their properties
	 *
	 * @since 1.0
	 * @version 1.0
	 *
	 */
    public static function get_all_fonts(){
        $default_fonts	= self::get_default_fonts();
		$google_fonts	= self::get_google_fonts();
		$all_fonts		= array_merge($default_fonts, $google_fonts);

        return apply_filters('ifs_google_font_get_all_fonts', $all_fonts);
    }

    /**
	 * Get the font
	 *
	 * processing the selected font
	 *
	 *
	 * Custom Filters:
	 *     - 'ifs_google_font_get_all_fonts'
	 *
	 * @return array $font
	 *
	 * @since 1.0
	 * @version 1.0
	 *
	 */
    public static function get_the_font( $id ){

        if($id==''){
            return false;
        }
		$all_fonts		= self::get_all_fonts();

		if(array_key_exists($id, $all_fonts)){
			$the_font = $all_fonts[$id];
		}

        return apply_filters('ifs_google_font_get_the_font', $the_font);
    }

}
