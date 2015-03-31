<?php
#default settings
$count = 0;
$loops = array();
$args = array();
$args_common = array();
$loop = 'main';
if(empty($title)) $title = __('Latest',IT_TEXTDOMAIN);
$size = '';
$csswhite = '';
$csscol = 'col-md-4';
$cols = 3;

#directory layout options
$categories = get_post_meta($post->ID, "_directory_categories", $single = true);
$type = get_post_meta($post->ID, "_directory_type", $single = true);	
$layout = get_post_meta($post->ID, "_directory_layout", $single = true);
if(empty($layout)) $layout = 'widget_a';
$rating = get_post_meta($post->ID, "_directory_ratings_disable", $single = true);
$disabled_filters = get_post_meta($post->ID, "_directory_filters_disable", $single = true);
$sort = get_post_meta($post->ID, "_directory_sort", $single = true);
$reviews = get_post_meta($post->ID, "_directory_reviews", $single = true);
$postsperpage = get_post_meta($post->ID, "_directory_number", $single = true);
	
#page layout options
$title_meta = get_post_meta($post->ID, "_subtitle", $single = true);
if(!empty($title_meta) && $title_meta!='') $title = $title_meta;
$disable_title = get_post_meta($post->ID, IT_META_DISABLE_TITLE, $single = true);

#limit to reviews only
if($reviews) $args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ));

#override postsperpage
if(!empty($postsperpage)) $args['posts_per_page'] = $postsperpage;

#determine layout/css classes
$location = $layout;
switch($location) {
	case 'widget_a':
		$location = 'grid';
	break;
	case 'widget_d':
		$location = 'overlay';
		$size = 'grid';
	break;
}
$csscompact = $location=='grid' ? '' : ' compact';
$cssclass = $location=='grid' ? ' post-grid' : ' scroller';
if($type=='merged') {
	$csscol = 'col-md-12';
	$cols = 1;
	if($layout=='widget_a') {
		$csscol .= ' no-padding';
		$layout = 'directory-loop';
	}
	if($layout=='widget_d') $cssclass .= ' third';		
}
		
		
#turn options into arrays
$categories = unserialize($categories) ? unserialize($categories) : array();
$disabled_filters = unserialize($disabled_filters) ? unserialize($disabled_filters) : array();
$disabled_count = !empty($disabled_filters) ? count($disabled_filters) : 0;
$disable_filters = $disabled_count > 6 ? true : false;

#setup loop format
$format = array('loop' => $loop, 'location' => $location, 'layout' => $layout, 'sort' => $sort, 'rating' => !$rating, 'thumbnail' => true, 'meta' => true, 'award' => true, 'icon' => true, 'badge' => true, 'excerpt' => true, 'authorship' => true, 'nonajax' => true, 'numarticles' => $postsperpage, 'disable_ads' => true, 'size' => $size);

#setup sortbar
$sortbarargs = array('loop' => $loop, 'location' => $location, 'layout' => $layout, 'title' => $title, 'theme_icon' => '', 'disabled_filters' => $disabled_filters, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => false, 'thumbnail' => true, 'rating' => !$rating, 'meta' => true, 'award' => true, 'badge' => true, 'excerpt' => true, 'authorship' => true, 'icon' => true, 'default' => $sort);

#don't want any specific sorting added to common args
$args_common = $args;

#setup default sorting (same for all loops on the page)
switch($sort) {
	case 'recent':	
		break;
	case 'title':
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
		break;
	case 'liked':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_LIKES;
		break;
	case 'viewed':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_VIEWS;	
		break;
	case 'users':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_USER_SCORE_NORMALIZED;
		$meta_query = $args['meta_query'];
		$new_meta_query = array( array( 'key' => IT_META_TOTAL_USER_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN') );
		if(!empty($meta_query)) {
			$meta_query = array_merge($meta_query, $new_meta_query);
		} else {
			$meta_query = $new_meta_query;
		}
		$args['meta_query'] = $meta_query;	
		break;
	case 'reviewed':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_SCORE_NORMALIZED;
		break;
	case 'commented':
		$args['orderby'] = 'comment_count';	
		break;
	case 'awarded':
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		$meta_query = $args['meta_query'];
		$new_meta_query = array( array( 'key' => IT_META_AWARDS, 'value' => array(''), 'compare' => 'NOT IN') );
		if(!empty($meta_query)) {
			$meta_query = array_merge($meta_query, $new_meta_query);
		} else {
			$meta_query = $new_meta_query;
		}
		$args['meta_query'] = $meta_query;	
		break;
}
			
#setup loop(s)
if($type=='merged') {
	$catid = 0;	
	$args['category__in'] = $categories;
	$args_common['category__in'] = $categories;		
	$format['container'] = 'directory-' . $catid;
	$sortbarargs['container'] = 'directory-' . $catid;		
	$itposts = new WP_Query( $args );
	$numpages = $itposts->max_num_pages;
	$loops[0] = array('args' => $args, 'args_common' => $args_common, 'catid' => $catid, 'sortbarargs' => $sortbarargs, 'format' => $format, 'numpages' => $numpages);		
} else {
	foreach($categories as $catid) {
		$category_icon = it_get_category_icon($catid,$csswhite);
		$name = get_cat_name($catid);
		$args['cat'] = $catid;
		$args_common['cat'] = $catid;
		$format['container'] = 'directory-' . $catid;
		$sortbarargs['container'] = 'directory-' . $catid;	
		$sortbarargs['title'] = $name;
		$sortbarargs['category_icon'] = $category_icon;
		$sortbarargs['static_label'] = true;		
		$itposts = new WP_Query( $args );
		$numpages = $itposts->max_num_pages;		
		$loops[$catid] = array('args' => $args, 'args_common' => $args_common, 'catid' => $catid, 'sortbarargs' => $sortbarargs, 'format' => $format, 'numpages' => $numpages);
	}		
}

?>
    
<?php do_action('it_before_directory', it_get_setting('ad_directory_before'), 'before-directory'); ?>

<div id="page-content" class="articles directory <?php echo $layout . $csscompact . $cssclass; ?>">
	
    <?php if(!$disable_title) { ?><h1 class="main-title archive-title"><?php echo get_the_title(); ?></h1><?php } ?>
            
    <?php echo it_get_content(''); ?>
    
    <div class="row no-margin">

        <?php foreach($loops as $this_loop) { $count++; ?> 
        
        	<?php $cssright = $count % $cols == 0 ? ' right' : ''; ?>
        
            <?php $args_encoded = json_encode($this_loop['args_common']); ?>
        
            <div id="directory-<?php echo $this_loop['catid']; ?>" class="post-container <?php echo $csscol . $cssright; ?>" data-currentquery='<?php echo $args_encoded; ?>'>
        
                <?php echo it_get_sortbar($this_loop['sortbarargs']); ?> 
            
                <div class="content-inner clearfix">
                
                    <div class="loading load-sort"><span class="theme-icon-spin2"></span></div>
                    
                    <div class="loop">                            
                        
                        <?php $loop = it_loop($this_loop['args'], $this_loop['format']); echo $loop['content']; ?>
                        
                    </div>  
                                         
                </div>
                
                <div class="pagination-wrapper">
                    
                    <?php echo it_pagination($this_loop['numpages'], $this_loop['format'], it_get_setting('page_range')); ?>
                    
                </div> 
                
            </div>
            
            <?php if($count % $cols == 0) echo '</div><div class="row no-margin">'; // start a new row ?>
        
        <?php } ?>
        
    </div> 
	
</div>  

<?php do_action('it_after_directory', it_get_setting('ad_directory_after'), 'after-directory'); ?>

<?php wp_reset_query(); ?>