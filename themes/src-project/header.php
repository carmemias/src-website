<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Refugee_Scotland_Festival_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'src-project' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo(); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>

				<?php esc_html_e( '', 'src-project' ); ?>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->

		<div class="site-branding">
		  <!-- See https://developer.wordpress.org/reference/functions/the_custom_logo/ -->
			<?php $second_logo_id = get_theme_mod( 'second_logo' );
			if($second_logo_id) {
				$second_logo = wp_get_attachment_image_src( $second_logo_id , 'full' );
				$alt_attrib = get_post_meta( $second_logo_id, '_wp_attachment_image_alt', true);
			} else {
				$second_logo = esc_url('https://www.refugeefestivalscotland.co.uk/wp-content/themes/src-project/images/src-logo.png');
				$alt_attrib = esc_html('Scottish Refugee Council logo');
			}
			?>
			<a href="https://www.scottishrefugeecouncil.org.uk/"><img src="<?php echo esc_url($second_logo[0]); ?>" class="second-logo" alt="<?php echo $alt_attrib; ?>" itemprop="logo" width="<?php echo absint($second_logo[1]);?>" height="<?php echo absint($second_logo[2]);?>"/></a>

		</div>

		<?php if ( is_active_sidebar( 'header' ) ) { ?>

				<?php dynamic_sidebar( 'header' ); ?><!-- thsi sidebar is used for the Search widget -->
				<!-- #secondary -->

		<?php } ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
