<?php
#Template Name: Author Listing
?>
<?php get_header(); # show header ?>

<?php 
#loop through content panels
$builders = it_get_setting('author_builder');
if(!empty($builders) && count($builders) > 2) {
	foreach($builders as $builder) {
		it_shortcode($builder);			
	}
} else {
	it_get_template_part('page-content');
} 
?>

<?php get_footer(); # show footer ?>