<?php
/**
 * The header no 1 for our theme
 *
 * This is the header template  number 1 that displays logo and main navigation inside <header id="masthead">
 *
 * @package Legacy
 */

?>

<div id="before-masthead" class="site-before-header clear">
    <?php ifs_legacy_hook_before_tophead(); ?>
    <div class="container">
        <div class="row">
            <?php ifs_legacy_hook_tophead(); ?>
        </div>
    </div>
    <?php ifs_legacy_hook_after_tophead(); ?>
</div>

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
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i></button>
                <div class="primary-menu-container">
                    <button id="primary-menu-close" class="menu-close-button"><i class="fa fa-close"></i></button>
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
        </div>

    </div>
</div><!-- #masthead -->
