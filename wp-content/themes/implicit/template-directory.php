<?php
#Template Name: Directory
?>
<?php get_header(); # show header ?>

<?php 
#get theme option
$builders = it_get_setting('page_builder');

#loop through builder panels
if(!empty($builders) && count($builders) > 2) {
	foreach($builders as $builder) {
		if($builder['id']=='page-content') $builder['id'] = 'directory';		
		it_shortcode($builder);			
	}
} else {
	it_get_template_part('directory');
} 
?>

<?php get_footer(); # show footer ?>