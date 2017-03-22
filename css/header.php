<?php
/**
 * The header template.
 *
 * Displays all of the <head> section and everything up till <div id="page-content">
 *
 * @package Maav
 * @since   Maav 1.0
 */
global $maav_post_meta;
$maav_post_meta   = unserialize( get_post_meta( get_the_ID(), '_maav_page_options', true ) );
$maav_header_type = Maav_Helper::get_post_meta( 'header_type', '' );
if ( $maav_header_type == '' ) {
    $maav_header_type = Kirki::get_option( 'maav', 'header_type' );
}
?>
<?php tha_html_before(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php tha_head_top(); ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo Kirki::get_option( 'maav', 'site_favicon' ); ?>">
        <link rel="apple-touch-icon"
              href="<?php echo Kirki::get_option( 'maav', 'site_favicon_apple_touch_icon' ); ?>"/>
    <?php } ?>
    <?php tha_head_bottom(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="preloader">
		<div class="clock"></div>
</div>
<?php tha_body_top(); ?>
<div id="page" class="hfeed site page-wrapper">
    <?php maav_top_slider(); ?>
    <?php require_once( get_template_directory() . '/template-parts/' . $maav_header_type . '.php' ); ?>
    <?php tha_content_before(); ?>
    <div id="page-content" class="page-content">
        <?php tha_content_top(); ?>
