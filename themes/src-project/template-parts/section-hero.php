<?php
/**
 * Template part for displaying the hero section in the static home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Refugee_Scotland_Festival_Theme
 */

?>

<section id="hero">
  <?php	if ( is_front_page() && !is_home() ) :
      ?>
      <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
  <?php endif;

  $src_project_description = get_bloginfo( 'description', 'display' );
  if ( $src_project_description || is_customize_preview() ) : ?>
      <p class="site-description"><?php echo $src_project_description; /* WPCS: xss ok. */ ?></p>
  <?php endif;

  //See https://codex.wordpress.org/Function_Reference/get_theme_mod
  $src_project_current_festival_dates = get_theme_mod( 'current_festival_dates', 'this mod does not exist');

?>
  <p class="festival-dates"><?php echo $src_project_current_festival_dates;?></p>
</section>
