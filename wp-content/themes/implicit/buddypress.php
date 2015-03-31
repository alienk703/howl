<?php
#Template Name: BuddyPress Page
?>
<?php get_header(); # show header ?>

<?php 
#loop through builder panels
$builders = it_get_setting('bp_builder');
if(!empty($builders) && count($builders) > 2) {
	foreach($builders as $builder) {
		it_shortcode($builder);			
	}
} else {
	it_get_template_part('page-content');
} 
?>

<?php get_footer(); # show footer ?>