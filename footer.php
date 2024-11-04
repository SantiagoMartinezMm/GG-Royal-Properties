<?php
/**
 * The template for displaying the footer.
 */
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-widgets">
            <?php if ( is_active_sidebar( 'footer-widget-1' ) ) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar( 'footer-widget-1' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-widget-2' ) ) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar( 'footer-widget-2' ); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="footer-credits">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.</p>
            <nav class="footer-menu">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer_menu',
                    'menu_id'        => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'menu-list',
                ) );
                ?>
            </nav>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
