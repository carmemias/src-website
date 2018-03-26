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
				'theme_location' => 'menu-2',
				'menu_class'     => 'social-links-menu',
				'depth'          => 1,
				'link_before'    => '<span class="screen-reader-text">',
				'link_after'     => '</span>' . src_project_get_svg( array( 'icon' => 'chain' ) ),
		) );
			?>
		</nav><!-- #site-navigation -->

		<div class="site-info">
			<!-- a href="<?php echo esc_url( __( 'https://wordpress.org/', 'src-project' ) ); ?>">
				< ?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'src-project' ), 'WordPress' );
				? >
			</a >
			<span class="sep"> | </span-->
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'src-project' ), 'Refugee Scotland Festival', '<a href="https://codeyourfuture.io">Code Your Future graduates</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
