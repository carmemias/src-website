<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Refugee_Scotland_Festival_Theme
 */

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>

            <aside id="footer-secondary" class="widget-area">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </aside><!-- #secondary -->

        <?php } ?>

        <nav id="social-navigation" class="social-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'social',
                'menu_class'     => 'social-links-menu',
                'depth'          => 1,
                'link_before'    => '<span class="screen-reader-text">',
                'link_after'     => '</span>',
        ) );
            ?>
        </nav><!-- #site-navigation -->

        <div class="site-info">
                <?php
                /* translators: 1: Theme name, 2: Theme author. */
                printf( esc_html__( 'Design by %1$s. WordPress website by %2$s.', 'src-project' ), '<a href="https://www.risottostudio.com">RISOTTO Studio</a>', '<a href="https://codeyourfuture.io">Code Your Future</a> graduates' );
                ?>
        </div><!-- .site-info -->

    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
