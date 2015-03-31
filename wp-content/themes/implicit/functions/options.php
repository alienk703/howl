<?php # this is a utility file that allows you to display option values
# it is only used when initially creating the encoded strings that are embedded
# in the functions/admin/core.php file. if you need to re-create any of the strings, use this file

#get code for theme options
#die(it_encode(get_option(IT_SETTINGS), $serialize = true));

#get code for sidebar_widgets array
#die(it_encode(get_option(IT_WIDGETS), $serialize = true));

#get code for individual widget array
/*
global $wpdb;
$option_names = $wpdb->get_results("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'widget_%';");
$widget_options = array();
foreach ($option_names as $option_name) {
	$widget_options["$option_name->option_name"] = get_option($option_name->option_name);
}
die(it_encode($widget_options, $serialize = true));
*/

#get code for theme_mods
#die(it_encode(get_option(IT_MODS), $serialize = true));

########################################################

#get array of all options in the wp_options table
#this is for informational/troubleshooting purposes only and is not used by admin/core.php
/*
$all_options = wp_load_alloptions();
$options = array();
foreach( $all_options as $name => $value ) {
	$options[$name] = $value . "<br /><br />";
}
die(var_export($options));
*/

#get legacy oswc_ prefixed options
/*
global $wpdb;
$option_names = $wpdb->get_results("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '%oswc%';");
$options = array();
foreach ($option_names as $option_name) {
	echo $option_name->option_name . ' = ';
	echo var_export(get_option($option_name->option_name));
	echo '<br /><br />';	
}
die();
*/

?>