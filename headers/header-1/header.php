<?php
/**
 * The header no 1 for our theme
 *
 * This is the header template  number 1 that displays logo and main navigation inside <header id="masthead">
 *
 * @package Legacy
 */

?>
<header id="masthead" class="site-header clear">
    <div class="container">
        <div class="site-branding">
            <?php
            if( has_custom_logo() ){
                the_custom_logo();
            }else{
                if ( is_front_page() && is_home() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
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
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ifs-legacy' ); ?></button>
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                ) );
            ?>
        </nav><!-- #site-navigation -->
    </div>
</header><!-- #masthead -->
