<?php
/*
* Sets up the theme by loading the IndustrialThemes class & initializing the framework
* which activates all classes and functions needed for theme's operation.
*/

# load the IndustrialThemes class
if ( file_exists( get_stylesheet_directory() . '/framework.php' ) )
	require_once( get_stylesheet_directory() . '/framework.php' );
else if ( file_exists( get_template_directory() . '/framework.php' ) )
	require_once( get_template_directory() . '/framework.php' );

# get theme data
$theme_data = wp_get_theme();
# initialize the IndustrialThemes framework
IndustrialThemes::init(array(
	'theme_name' => $theme_data->name,
	'theme_version' => $theme_data->version
));

if ( ! isset( $content_width ) ) $content_width = 1200;
?>