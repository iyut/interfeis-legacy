<?php
/**
 * The header corporate no. 1 for our theme
 *
 * This is the header corporate template number 1 that displays logo and main navigation inside <header id="masthead">
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
            
            <button id="site-menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="menu-bar"></span>
                <span class="menu-bar-open"><?php esc_html_e('Menu', 'ifs-legacy'); ?></span>
                <span class="menu-bar-close"><?php esc_html_e('Close', 'ifs-legacy'); ?></span>
            </button>
            
            <nav id="site-navigation" class="main-navigation">
                <div class="primary-menu-container">
                    
                    <?php
                        wp_nav_menu( array(
                            'container'         => 'div',
                            'container_id'      => 'menu-1-container',
                            'theme_location'    => 'menu-1',
                            'menu_id'           => 'primary-menu',
                        ) );
                    ?>
                </div>
            </nav><!-- #site-navigation -->
            <div class="balancer">
                &nbsp;
            </div>
        </div>

    </div>
</div><!-- #masthead -->
