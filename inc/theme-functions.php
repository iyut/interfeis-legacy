<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Legacy
 */

 /**
  * create a custom sanitizer
  *
  * @return string
  * @uses wp_kses
  * @uses wp_kses_allowed_html
  */
 function ifs_legacy_custom_wp_kses( $value ){
 	$allowed_tags 	= wp_kses_allowed_html( 'post' );
 	return wp_kses( $value, $allowed_tags );
 }

 /**
  * check if the page is of any post type ( including post or page )
  *
  * @param void
  * @return bool
  */
 if( !function_exists('ifs_legacy_check_pagepost')){
 	function ifs_legacy_check_pagepost(){
 		global $post;

 		if( is_404() || is_archive() || is_attachment() || is_search() ){
 			$ifs_custom = false;
 		}else{
 			$ifs_custom = true;
 		}

 		return apply_filters('ifs_legacy_check_pagepost', $ifs_custom);
 	}
 }

 /**
  * get postid on any page
  *
  * @param void
  * @return int
  */
 if( !function_exists('ifs_legacy_get_postid')){
 	function ifs_legacy_get_postid(){
 		global $post;

 		if( is_home() ){
 			$ifs_pid = get_option('page_for_posts');
 		}elseif( function_exists( 'is_woocommerce' ) && is_shop() ){
 			$ifs_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
 		}elseif( function_exists( 'is_woocommerce' ) && is_product_category() ){
 			$ifs_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
 		}elseif( function_exists( 'is_woocommerce' ) && is_product_tag() ){
 			$ifs_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
 		}elseif(!ifs_legacy_check_pagepost()){
 			$ifs_pid = 0;
 		}else{
 			$ifs_pid = get_the_ID();
 		}

 		return apply_filters('ifs_legacy_get_postid', $ifs_pid);
 	}
 }

 /**
  * get metabox value from any post or page
  *
  * @param int Post or Page id
  * @return array
  */
 if( !function_exists('ifs_legacy_get_customdata')){
 	function ifs_legacy_get_customdata($ifs_pid=""){
 		global $post;

 		if($ifs_pid!=""){
 			$ifs_custom = get_post_custom($ifs_pid);
 			return $ifs_custom;
 		}

 		if($ifs_pid==""){
 			$ifs_pid = ifs_legacy_get_postid();
 		}

 		if( ifs_legacy_check_pagepost() ){
 			$ifs_custom = get_post_custom($ifs_pid);
 		}else{
 			$ifs_custom = array();
 		}

 		return apply_filters('ifs_legacy_get_customdata', $ifs_custom);
 	}
 }

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ifs_legacy_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return apply_filters('ifs_legacy_body_classes_val', $classes);
}
add_filter( 'body_class', 'ifs_legacy_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ifs_legacy_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ifs_legacy_pingback_header' );

/**
 * check if the page is a shop page or not
 *
 * @uses ifs_legacy_is_shop()
 */
if(!function_exists("ifs_legacy_is_shop")){
	function ifs_legacy_is_shop(){

        $return = false;

		if(function_exists("is_woocommerce")){
			if(is_shop() || is_product_taxonomy()){
				$return = true;
			}
		}
		return apply_filters('ifs_legacy_is_shop', $return);
	}
}

/**
 * check if the page is a product page or not
 *
 * @uses ifs_legacy_is_shop()
 */
if(!function_exists("ifs_legacy_is_product")){
	function ifs_legacy_is_product(){

        $return = false;

		if(function_exists("is_woocommerce")){
			if(is_singular('product')){
				$return = true;
			}
		}
		return apply_filters('ifs_legacy_is_product', $return);
	}
}

if(!function_exists("ifs_legacy_searchform")){
	function ifs_legacy_searchform($id="", $class=""){

		if(function_exists('is_woocommerce') ){
			$outputposttype = '<input type="hidden" name="post_type" value="product" />';
			$searchtext = esc_html__('Search', "ifs-legacy" );
		}else{
			$outputposttype = '';
			$searchtext = esc_html__('Search', "ifs-legacy" );
		}
		if($id==''){
			$id = 'topsearchform';
		}

		do_action('ifs_legacy_searchform_before_wrapper');
?>
		<div class="<?php echo esc_attr( $class ); ?>">

			<?php do_action('ifs_legacy_searchform_before_form'); ?>

			<form method="get" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" class="btntoppanel" action="<?php echo esc_url( home_url( '/' ) ); ?>">

				<?php do_action('ifs_legacy_searchform_before_searcharea'); ?>

				<div class="searcharea">

					<?php do_action('ifs_legacy_searchform_before_submit_button'); ?>

					<input type="submit" class="submit" name="submit" value="" />
					<button type="submit" class="submittext" name="submit">
						<i class="fa fa-search"></i>
						<span><?php esc_html_e('Search', 'ifs-legacy'); ?></span>
					</button>

					<?php do_action('ifs_legacy_searchform_before_text_container'); ?>

					<div class="text_container">
						<input type="text" name="s" autocomplete="off" class="txtsearch" placeholder="<?php echo esc_attr( $searchtext ); ?>" value="" />
					</div>

					<?php do_action('ifs_legacy_searchform_before_select_container'); ?>

					<?php if( taxonomy_exists('product_cat') ){ ?>
					<div class="select_container">
					<?php

						wp_dropdown_categories(array(
			                'show_option_all'   => esc_html__('All Categories','ifs-legacy'),
			                'show_option_none'  => esc_html__('No Category', 'ifs-legacy'),
			                'taxonomy'          => 'product_cat',
			                'echo'              => 1,
			                'class'             => 'ifs_selector',
			                'value_field'       => 'slug',
			                'hierarchical'      => true,
			                'name'              => 'product_cat'

			            ));

					?>
					</div>
					<?php } // if( taxonomy_exists('product_cat') ) ?>

					<?php do_action('ifs_legacy_searchform_after_select_container'); ?>

					<?php if(function_exists('is_woocommerce') ){ ?>

						<input type="hidden" name="post_type" value="product" />

					<?php } // if(function_exists('is_woocommerce') ) ?>

					<?php do_action('ifs_legacy_searchform_before_close_button'); ?>

					<a href="#" class="searchclose"></a>

					<?php do_action('ifs_legacy_searchform_after_close_button'); ?>

				</div>

				<?php do_action('ifs_legacy_searchform_after_inputs'); ?>
			</form>

			<?php do_action('ifs_legacy_searchform_after_form'); ?>

		</div>
<?php
		do_action('ifs_legacy_searchform_after_wrapper');
	}
}

/**
 * return minicart form
 *
 * @uses the_widget()
 */
if(!function_exists("ifs_legacy_minicart")){
	function ifs_legacy_minicart($id="",$class=""){

		do_action('ifs_legacy_minicart_before_wrapper');
?>
		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">

			<?php do_action('ifs_legacy_minicart_before_header'); ?>

			<div class="cartheader_wrapper">
				<h5 class="cartheader"><?php echo esc_html( apply_filters('ifs_legacy_minicart_header_text', esc_html__('Shopping Cart', 'ifs-legacy')) ); ?></h5>
				<a class="cartclose" href="#"></a>
			</div>

			<?php do_action('ifs_legacy_minicart_before_cart'); ?>

			<div class="cartlistwrapper">
				<?php
				the_widget('WC_Widget_Cart', '', array('widget_id'=>'cart-dropdown',
					'before_widget' => '',
					'after_widget' => '',
					'before_title' => '<span class="hidden">',
					'after_title' => '</span>'
				));
				?>
			</div>

			<?php do_action('ifs_legacy_minicart_after_cart'); ?>

		</div>
<?php
		do_action('ifs_legacy_minicart_after_wrapper');
	}
}

/**
 * return minicart form
 *
 * @uses wc->cart->get_cart_subtotal()
 * @uses wc_get_cart_url()
 * @uses wc->cart->get_cart_item_quantities()
 */
if(!function_exists("ifs_legacy_minicart_value")){
	function ifs_legacy_minicart_value(){

		if( !function_exists('is_woocommerce') ){
			return false;
		}
		global $woocommerce;
		$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
		$link = ( function_exists('wc_get_cart_url'))? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
		$cart_items = $woocommerce->cart->get_cart_item_quantities();

		$totalqty = 0;
		if(is_array($cart_items)){
			foreach($cart_items as $cart_item){
				$totalqty += (is_numeric($cart_item))? $cart_item : 0;
			}
		}

		$output = array(
			'qty'	=> $totalqty,
			'link'	=> $link,
			'subttl'=> $cart_subtotal
		);

		return apply_filters('ifs_legacy_minicart_value', $output );
	}
}

/**
 * display register form string
 *
 * @uses ifs_legacy_register_form()
 */
if(!function_exists('ifs_legacy_register_form')){
	function ifs_legacy_register_form() {
        $nonce = wp_create_nonce("ifs_legacy_register_nonce");
		$redirectregister = '';
        if( function_exists( 'is_woocommerce' ) ){
			$pid = (function_exists('wc_get_page_id'))? wc_get_page_id('myaccount') : wc_get_page_id( 'myaccount' );
            $redirectregister = get_permalink($pid);
		}

        $successtext = esc_html__('Congratulations, the registration is successful. Please kindly check your email.', 'ifs-legacy');

        $redirectregister = add_query_arg("ifs_successregtext", $successtext, $redirectregister);

		do_action('ifs_legacy_register_form_before_container');
?>
            <div class="login_form">
            <form id="registerform" name="registerform" action="<?php echo esc_url( wp_registration_url() ); ?>" method="post">
				<div class="loginalert" id="register_message_area" ></div>

				<p>
					<label for="user_login_register"><?php esc_html_e('Username', "ifs-legacy" ); ?></label>
					<input type="text" name="user_login" id="user_login_register" class="textbox" value="" size="20" />
				</p>
				<p>
					<label for="user_email_register"><?php esc_html_e('Email', "ifs-legacy" ); ?></label>
					<input type="text" name="user_email" id="user_email_register" class="textbox" value="" size="20" />
				</p>
				<p id="reg_passmail">
					<?php esc_html_e('A password will be e-mailed to you', "ifs-legacy" ); ?>
				</p>

				<?php do_action('register_form'); ?>

				<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirectregister ); ?>" />
				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button" value="<?php esc_attr_e('Register', "ifs-legacy" ); ?>" />
				</p>
            </form>
			</div>
<?php

		do_action('ifs_legacy_register_form_after_container');
	}
}

/**
 * display login form string
 *
 * @uses wp_login_form()
 */
if(!function_exists('ifs_legacy_login_form')){
	function ifs_legacy_login_form() {
		 // get user dashboard link
		$login_args = array(
			'echo' => true,
		);

		do_action('ifs_legacy_login_form_before_container');
?>
		<div class="login_form" id="ifs-login-div">
			<?php wp_login_form( $login_args ); ?>
		  	<div class="login-links">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" id="forgot_pass">
					<?php esc_html_e('forgot password?', "ifs-legacy" ); ?>
				</a>
			</div>
		</div>
<?php
		do_action('ifs_legacy_login_form_after_container');
	}
}

/**
 * display comment list
 *
 */
if( !function_exists( 'ifs_legacy_list_comment' ) ){

	function ifs_legacy_list_comment($comment, $args, $depth) {
	    
	    if ( 'div' === $args['style'] ) {
	        $tag       = 'div';
	        $add_below = 'comment';
	    } else {
	        $tag       = 'li';
	        $add_below = 'div-comment';
	    }?>

	    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">

		<?php if ( 'div' != $args['style'] ) { ?>

	        	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		
		<?php } ?>

	        <div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 ) { ?>

				<span class="comment-avatar">
	                	<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
	            </span> 

			<?php }

			printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); 

			?>
	        </div>

	        <?php if ( $comment->comment_approved == '0' ) { ?>
	            
	            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/>
		
		<?php } ?>

	        <div class="comment-meta commentmetadata">
	            
	            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
	                /* translators: 1: date, 2: time */
	                printf( 
	                    __('%1$s at %2$s'), 
	                    get_comment_date(),  
	                    get_comment_time() 
	                ); ?>
	            </a>
	            <?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
	        
	        </div>

	        <?php comment_text(); ?>

	        <div class="reply"><?php 
	                comment_reply_link( 
	                    array_merge( 
	                        $args, 
	                        array( 
	                            'add_below' => $add_below, 
	                            'depth'     => $depth, 
	                            'max_depth' => $args['max_depth'] 
	                        ) 
	                    ) 
	                ); ?>
	        </div>

	        <?php if ( 'div' != $args['style'] ) : ?>
	        </div>
	        <?php endif;
	}
}


/**
 * display open container for related posts
 *
 */
if(!function_exists('ifs_legacy_open_related_container')){
	function ifs_legacy_open_related_container(){
		echo '<div class="related-posts-container">';
	}
	add_action('ifs_legacy_after_post_navigation', 'ifs_legacy_open_related_container', 10);
}

/**
 * display related posts container title
 *
 */
if(!function_exists('ifs_legacy_related_title')){
	function ifs_legacy_related_title(){
		echo '<h2 class="related-posts-title">'.esc_html__('You might also like', 'ifs-legacy').'</h2>';
	}
	add_action('ifs_legacy_after_post_navigation', 'ifs_legacy_related_title', 13);
}

/**
 * display related posts on single page
 *
 * @uses ifs_legacy_query_related_posts()
 * @uses get_template_part()
 */
if(!function_exists('ifs_legacy_related_posts')){
    function ifs_legacy_related_posts(){

		$results = ifs_legacy_query_related_posts();

		if( $results->have_posts() ){

			?>

			<div class="related-posts-row row">

				<?php
				while ( $results->have_posts() ) : $results->the_post();
					get_template_part( 'template-parts/content', 'related' );
				endwhile; // End the loop. Whew.
				?>

			</div>

			<?php
		}
		wp_reset_postdata();
    }
	add_action('ifs_legacy_after_post_navigation', 'ifs_legacy_related_posts', 15);
}

/**
 * return the related posts on single page
 *
 * @uses ifs_legacy_get_postid()
 * @uses get_the_category()
 * @uses WP_Query()
 */
if( !function_exists('ifs_legacy_query_related_posts') ){
	function ifs_legacy_query_related_posts(){
		$post_id 	= ifs_legacy_get_postid();
		$post_cats	= get_the_category( $post_id );

		$catslugs	= array();
		if(count($post_cats)>0){
			foreach( $post_cats as $post_cat ){
				$catslugs[] = $post_cat->slug;
			}
		}
		$argquery = array(
			'post_type' 		=> 'post',
			'posts_per_page'	=> apply_filters('ifs_legacy_related_num_posts', 3),
			'orderby' 			=> 'date',
			'order' 			=> 'DESC'
		);

		if(count($catslugs)>0){
			$argquery['category_name'] = implode(',', $catslugs);
		}

		$results = new WP_Query( apply_filters('ifs_legacy_related_posts_query', $argquery) );

		return apply_filters('ifs_legacy_query_related_posts', $results);
	}
}

/**
 * display closer container for related posts
 *
 */
if(!function_exists('ifs_legacy_close_related_container')){
	function ifs_legacy_close_related_container(){
		echo '</div>';
	}
	add_action('ifs_legacy_after_post_navigation', 'ifs_legacy_close_related_container', 20);
}

/**
 * generate css for the base font
 *
 * @uses ifs_legacy_print_base_font_css()
 */
if(!function_exists("ifs_legacy_print_base_font_css")){
	function ifs_legacy_print_base_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_base_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_base_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_base_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'body{'.$return.'}';

		return apply_filters('ifs_legacy_print_base_font_css', esc_attr($return));
	}
}

/**
 * generate css for the menu font
 *
 * @uses ifs_legacy_print_sitetitledesc_font_css()
 */
if(!function_exists("ifs_legacy_print_sitetitledesc_font_css")){
	function ifs_legacy_print_sitetitledesc_font_css(){

    $the_font_mod 		= get_theme_mod( 'ifs_legacy_sitetitle_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_sitetitle_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_sitetitle_font_weight' );

    $sub_font_mod 		= get_theme_mod( 'ifs_legacy_sitedesc_font', ifs_legacy_theme_font_default() );
		$sub_font_size 		= get_theme_mod( 'ifs_legacy_sitedesc_font_size' );
		$sub_font_weight	= get_theme_mod( 'ifs_legacy_sitedesc_font_weight' );

		$return = '';
    $subreturn = '';

		$the_font = call_user_func($the_font_mod);

    $sub_font = call_user_func($sub_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

    if($sub_font!=false){
			$subreturn .= 'font-family:'.$sub_font['name'].','.$sub_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';

        if($sub_font_size!='')
            $subreturn .= 'font-size:'.$sub_font_size.'px;';

        if($sub_font_weight!='')
          $subreturn .= 'font-weight:'.$sub_font_weight.';';


        $return = 'body.ifs .site-header .site-title{'. esc_attr($return).'}';
        $subreturn = 'body.ifs .site-header .site-description{'. esc_attr($subreturn).'}';

        $return .= $subreturn;

		return apply_filters('ifs_legacy_print_sitetitledesc_font_css', $return);
	}
}

/**
 * generate css for the menu font
 *
 * @uses ifs_legacy_print_menu_font_css()
 */
if(!function_exists("ifs_legacy_print_menu_font_css")){
	function ifs_legacy_print_menu_font_css(){

    $the_font_mod 		= get_theme_mod( 'ifs_legacy_menu_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_menu_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_menu_font_weight' );

    $sub_font_mod 		= get_theme_mod( 'ifs_legacy_submenu_font', ifs_legacy_theme_font_default() );
		$sub_font_size 		= get_theme_mod( 'ifs_legacy_submenu_font_size' );
		$sub_font_weight	= get_theme_mod( 'ifs_legacy_submenu_font_weight' );

		$return = '';
    $subreturn = '';

		$the_font = call_user_func($the_font_mod);

    $sub_font = call_user_func($sub_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

    if($sub_font!=false){
			$subreturn .= 'font-family:'.$sub_font['name'].','.$sub_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';

        if($sub_font_size!='')
            $subreturn .= 'font-size:'.$sub_font_size.'px;';

        if($sub_font_weight!='')
          $subreturn .= 'font-weight:'.$sub_font_weight.';';


        $return = 'body.ifs .site-header .main-navigation ul.nav-menu > li > a{'. esc_attr($return).'}';
        $subreturn = 'body.ifs .site-header .main-navigation ul.nav-menu ul li a{'. esc_attr($subreturn).'}';

        $return .= $subreturn;

		return apply_filters('ifs_legacy_print_menu_font_css', $return);
	}
}

/**
 * generate css for the footer widget font
 *
 * @uses ifs_legacy_print_footerwidget_font_css()
 */
if(!function_exists("ifs_legacy_print_footerwidget_font_css")){
	function ifs_legacy_print_footerwidget_font_css(){

    $the_font_mod 		= get_theme_mod( 'ifs_legacy_footer_widget_title_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_footer_widget_title_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_footer_widget_title_font_weight' );

    $sub_font_mod 		= get_theme_mod( 'ifs_legacy_footer_widget_font', ifs_legacy_theme_font_default() );
		$sub_font_size 		= get_theme_mod( 'ifs_legacy_footer_widget_font_size' );
		$sub_font_weight	= get_theme_mod( 'ifs_legacy_footer_widget_font_weight' );

		$return = '';
    $subreturn = '';

		$the_font = call_user_func($the_font_mod);

    $sub_font = call_user_func($sub_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

    if($sub_font!=false){
			$subreturn .= 'font-family:'.$sub_font['name'].','.$sub_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';

        if($sub_font_size!='')
            $subreturn .= 'font-size:'.$sub_font_size.'px;';

        if($sub_font_weight!='')
          $subreturn .= 'font-weight:'.$sub_font_weight.';';


        $return = 'body.ifs .footer-widgets-container .widget-title{'. esc_attr($return).'}';
        $subreturn = 'body.ifs .footer-widgets-container{'. esc_attr($subreturn).'}';

        $return .= $subreturn;

		return apply_filters('ifs_legacy_print_footerwidget_font_css', $return);
	}
}

/**
 * generate css for the footer bar font
 *
 * @uses ifs_legacy_print_footerbar_font_css()
 */
if(!function_exists("ifs_legacy_print_footerbar_font_css")){
	function ifs_legacy_print_footerbar_font_css(){

    $the_font_mod 		= get_theme_mod( 'ifs_legacy_footer_bar_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_footer_bar_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_footer_bar_font_weight' );


		$return = '';

		$the_font = call_user_func($the_font_mod);


		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';

        $return = 'body.ifs .site-footer .foot_col{'. esc_attr($return).'}';

		return apply_filters('ifs_legacy_print_footerbar_font_css', $return);
	}
}

/**
 * generate css for the heading 1 font
 *
 * @uses ifs_legacy_print_h1_font_css()
 */
if(!function_exists("ifs_legacy_print_h1_font_css")){
	function ifs_legacy_print_h1_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h1_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h1_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h1_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'h1{'.$return.'}';

		return apply_filters('ifs_legacy_print_h1_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 2 font
 *
 * @uses ifs_legacy_print_h2_font_css()
 */
if(!function_exists("ifs_legacy_print_h2_font_css")){
	function ifs_legacy_print_h2_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h2_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h2_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h2_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'h2{'.$return.'}';

		return apply_filters('ifs_legacy_print_h2_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 3 font
 *
 * @uses ifs_legacy_print_h3_font_css()
 */
if(!function_exists("ifs_legacy_print_h3_font_css")){
	function ifs_legacy_print_h3_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h3_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h3_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h3_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'h3{'.$return.'}';

		return apply_filters('ifs_legacy_print_h3_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 4 font
 *
 * @uses ifs_legacy_print_h4_font_css()
 */
if(!function_exists("ifs_legacy_print_h4_font_css")){
	function ifs_legacy_print_h4_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h4_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h4_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h4_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'h4{'.$return.'}';

		return apply_filters('ifs_legacy_print_h4_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 5 font
 *
 * @uses ifs_legacy_print_h5_font_css()
 */
if(!function_exists("ifs_legacy_print_h5_font_css")){
	function ifs_legacy_print_h5_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h5_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h5_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h5_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'h5{'.$return.'}';

		return apply_filters('ifs_legacy_print_h5_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 6 font
 *
 * @uses ifs_legacy_print_h6_font_css()
 */
if(!function_exists("ifs_legacy_print_h6_font_css")){
	function ifs_legacy_print_h6_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h6_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h6_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h6_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
		}

        if($the_font_size!='')
            $return .= 'font-size:'.$the_font_size.'px;';

        if($the_font_weight!='')
            $return .= 'font-weight:'.$the_font_weight.';';


        $return = 'h6{'.$return.'}';

		return apply_filters('ifs_legacy_print_h6_font_css', esc_attr($return));
	}
}

/**
 * generate css for all font
 *
 * @uses ifs_legacy_print_all_font_css()
 */
if(!function_exists("ifs_legacy_print_all_font_css")){
	function ifs_legacy_print_all_font_css(){

		$output_css = '';

		$output_css .= ifs_legacy_print_base_font_css();

		$output_css .= ifs_legacy_print_sitetitledesc_font_css();

		$output_css .= ifs_legacy_print_menu_font_css();

		$output_css .= ifs_legacy_print_footerwidget_font_css();

		$output_css .= ifs_legacy_print_footerbar_font_css();

		$output_css .= ifs_legacy_print_h1_font_css();

		$output_css .= ifs_legacy_print_h2_font_css();

		$output_css .= ifs_legacy_print_h3_font_css();

		$output_css .= ifs_legacy_print_h4_font_css();

		$output_css .= ifs_legacy_print_h5_font_css();

		$output_css .= ifs_legacy_print_h6_font_css();

		return apply_filters('ifs_legacy_print_all_font_css', $output_css);
	}
}

/**
 * generate css for the general text color
 *
 * @uses ifs_legacy_print_text_color_css()
 */
if(!function_exists("ifs_legacy_print_text_color_css")){
	function ifs_legacy_print_text_color_css(){

        $the_text_color 	= get_theme_mod( 'ifs_legacy_general_text_color' );

		$return = '';

        if($the_text_color!='')
            $return .= 'color:'.$the_text_color.';';


        $return = 'body.ifs{'.$return.'}';

		return apply_filters('ifs_legacy_print_text_color_css', esc_attr($return));
	}
}

/**
 * generate css for the general link color
 *
 * @uses ifs_legacy_print_link_color_css()
 */
if(!function_exists("ifs_legacy_print_link_color_css")){
	function ifs_legacy_print_link_color_css(){

        $the_text_color 	= get_theme_mod( 'ifs_legacy_general_link_color' );

		$return = '';

        if($the_text_color!='')
            $return .= 'color:'.$the_text_color.';';


        $return = 'body.ifs a{'.$return.'}';

		return apply_filters('ifs_legacy_print_link_color_css', esc_attr($return));
	}
}

/**
 * generate css for all color
 *
 * @uses ifs_legacy_print_general_color_css()
 */
if(!function_exists("ifs_legacy_print_general_color_css")){
	function ifs_legacy_print_general_color_css(){

		$output_css = '';

		$output_css .= ifs_legacy_print_text_color_css();

        $output_css .= ifs_legacy_print_link_color_css();

		return apply_filters('ifs_legacy_print_general_color_css', esc_attr($output_css));
	}
}
