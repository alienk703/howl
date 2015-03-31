<?php get_header(); # show header ?>

<?php 
#get theme option
$builders = it_get_setting('single_builder');

#loop through builder panels
if(!empty($builders) && count($builders) > 2) {
	foreach($builders as $builder) {
		it_shortcode($builder);			
	}
} else {
	it_get_template_part('page-content');
} 
?>

<?php get_footer(); # show footer ?>