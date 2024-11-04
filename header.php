<?php
/**
 * The header for our theme.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="site-header">
        <div class="container">
            <div class="branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                    </h1>
                    <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                <?php endif; ?>
            </div>

            <nav class="primary-menu">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary_menu',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'menu-list',
                ) );
                ?>
            </nav>
            
            <div class="header-widgets">
                <?php if ( is_active_sidebar( 'header-widget' ) ) : ?>
                    <?php dynamic_sidebar( 'header-widget' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </header>
