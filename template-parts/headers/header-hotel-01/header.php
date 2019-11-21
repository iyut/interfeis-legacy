<?php
/**
 * The header for hotel theme no. 1
 *
 * This is the header for hotel template  number 1 that displays logo and main navigation inside <header id="masthead">
 *
 * @package Legacy
 */

?>

<div id="masthead" class="site-header clear">
    <div class="container">
        <div class="row">
            <div class="site-branding">
                <?php
                if( has_custom_logo() ){
                    the_custom_logo();
                }else{
                    if ( is_front_page() && is_home() ) : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                        <p class="site-title noh1"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                    endif;
                }

                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) :
                ?>
                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                <?php
                endif;
                ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
				<?php
					wp_nav_menu( array(
						'container'         => 'div',
						'container_id'      => 'menu-2-container',
						'theme_location'    => 'menu-2',
						'menu_id'           => 'secondary-menu',
						'depth' 			=> 2,
						'fallback_cb' 		=> 'ifs_legacy_blankmenu'
					) );
				?>
                <button id="site-menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="menu-bar"></span>
				</button>
                <div class="primary-menu-container">
                    <?php
                        wp_nav_menu( array(
                            'container'         => 'div',
                            'container_id'      => 'menu-1-container',
                            'theme_location'    => 'menu-1',
							'menu_id'           => 'primary-menu',
							'depth' 			=> 2
                        ) );
                    ?>
                </div>
            </nav><!-- #site-navigation -->
        </div>

    </div>
</div><!-- #masthead -->
