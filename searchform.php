<?php
/**
 * The template for displaying search form
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package Legacy
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="search-wrapper">
		<label>
			<span class="screen-reader-text"><?php _e( 'Search for:', 'ifs-legacy' ) ?></span>
			<input type="search" class="search-field"
				placeholder="<?php esc_attr_e( 'Search …', 'ifs-legacy' ) ?>"
				value="<?php echo get_search_query() ?>" name="s"
				title="<?php esc_attr_e( 'Search for:', 'ifs-legacy' ) ?>" />
		</label>
		<input type="submit" class="search-submit"
			value="<?php esc_attr_e( 'Search', 'ifs-legacy' ) ?>" />
	</div>
</form>