<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Legacy
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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ifs-legacy' ); ?></a>

	<?php ifs_legacy_theme_before_header(); ?>

	<header id="header-container" class="outerheader">
		<?php ifs_legacy_theme_header(); ?>

		<?php ifs_legacy_header_title(); ?>
	</header>

	<?php ifs_legacy_theme_after_header(); ?>

	<div class="outercontainer">
		<div id="content-container" class="container <?php ifs_legacy_content_container_class(); ?>">
			<div class="row">

				<div id="content" class="site-content <?php ifs_legacy_content_class(); ?>">
