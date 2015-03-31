<?php
#default settings (use "Standard Pages" theme options for defaults)
$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
$layout = 'classic';
$thumbnail = it_get_setting('page_featured_image_size');
$post_article_title_disable = it_get_setting('post_article_title_disable');
$editor_rating_disable = it_get_setting('review_editor_rating_disable');
$user_rating_disable = it_get_setting('review_user_rating_disable');
$clickable = !it_get_setting('clickable_image_disable');
$disable_sidebar = it_component_disabled('sidebar', $post->ID);
$disable_view_count = it_component_disabled('views', $post->ID);
$disable_like_count = it_component_disabled('likes', $post->ID);
$disable_comment_count = it_component_disabled('comment_count', $post->ID);
$disable_awards = it_component_disabled('awards', $post->ID);
$disable_authorship = it_component_disabled('authorship', $post->ID);
$disable_comments = it_component_disabled('comments', $post->ID);
$disable_postnav = it_component_disabled('postnav', $post->ID);
$disable_sharing = it_component_disabled('sharing', $post->ID);
$disable_controlbar = it_component_disabled('controlbar', $post->ID, $forcepage = true);
$disable_video = it_component_disabled('video', $post->ID);
$caption = it_get_setting('featured_image_caption');
$disable_authorship_avatar = it_get_setting('post_authorship_avatar_disable');
$template = it_get_template_file();
$details_position = 'none';
$ratings_position = 'none';
$reactions_position = 'none';
$biglike_position = 'none';
$affiliate_position = 'none';
$contents_menu = 'none';
$disable_authorinfo = true;
$disable_postinfo = true;
$image_can_float = false;
$disabled_menu_items = array();
$article_title = '';
$disable_main_header = false;
$disable_recommended = false;
$disable_title = false;
$isreview = false;
$pagecss = '';
$item_type = 'http://schema.org/Article';
$item_prop = '';
$has_details = it_has_details($post->ID);

#get just the primary category id
$categoryargs = array('postid' => $post->ID, 'label' => false, 'icon' => false, 'white' => true, 'single' => true, 'wrapper' => false, 'id' => true);	
$category_id = it_get_primary_categories($categoryargs);
$categorycss = ' category-' . $category_id;
#reset args for category display
$categoryargs = array('postid' => $post->ID, 'label' => true, 'icon' => true, 'white' => false, 'single' => true, 'wrapper' => false, 'id' => false);
$category = it_get_primary_categories($categoryargs);

#section-specific settings
if(is_404()) {
	wp_reset_postdata();
	#settings for 404 pages
	$main_title = __('404 Error - Page Not Found', IT_TEXTDOMAIN);
	$subtitle = __('We could not find the page you were looking for. Try searching for it:', IT_TEXTDOMAIN);		
	$disable_controlbar = true;	
	$disable_main_header = true;
	$disable_recommended = true;
	$disable_sharing = true;
	$disable_authorship = true;
	$layout = 'classic';
} elseif(is_page()) {
	#settings for all standard WordPress pages	
	$subtitle = get_post_meta($post->ID, "_subtitle", $single = true);	
	$page_comments = it_get_setting('page_comments');
	$thumbnail_specific = it_get_setting('page_featured_image_size');	
	$disable_recommended = true;
	$disable_authorship = true;
	$disabled_menu_items[] = 'rating';
	$disabled_menu_items[] = 'overview';
	$layout = 'classic';
	$disable_postnav = true;
	if(!$page_comments) {
		$disable_comments = true;
		$disable_comment_count = true;
		$disabled_menu_items[] = 'comments';
	}
} elseif(is_single()) {
	#settings for single posts
	$layout = it_get_setting('post_layout');
	$subtitle = get_post_meta($post->ID, "_subtitle", $single = true);	
	$thumbnail_specific = it_get_setting('post_featured_image_size');	
	$contents_menu = it_get_setting('contents_menu');	
	$article_title = it_get_setting('article_title');
	$disable_authorinfo = it_get_setting('post_author_disable');
	$disable_postinfo = false;
	$details_position = it_get_setting('review_details_position');
	$details_position = !empty($details_position) ? $details_position : 'top';
	$ratings_position = it_get_setting('review_ratings_position');
	$ratings_position = !empty($ratings_position) ? $ratings_position : 'top';	
	$reactions_position = it_get_setting('reactions_position');
	$reactions_position = !empty($reactions_position) ? $reactions_position : 'bottom';	
	$biglike_position = it_get_setting('biglike_position');
	$biglike_position = !empty($biglike_position) ? $biglike_position : 'after-content';	
	if(!comments_open()) $disabled_menu_items[] = 'comments';
	$affiliate_position = it_get_setting('affiliate_position');	
	$affiliate_position = !empty($affiliate_position) ? $affiliate_position : 'after-content';	
}
#settings for buddypress pages
if(it_buddypress_page()) {	
	$disable_postnav = true;
	$disable_controlbar = true;
	$disable_recommended = true;
	$disable_authorinfo = true;
	$disable_postinfo = true;
	$disable_authorship = true;
	$disable_comments = true;
	$disable_sharing = true;
	$layout = 'classic';
	$pagecss = 'bp-page';
	$article_title = '';
	$contents_menu = 'none';
	$reactions_position = 'none';
	$disable_sidebar = it_get_setting('bp_sidebar_disable');
	if(it_get_setting('bp_sidebar_unique')) $sidebar = __('BuddyPress Sidebar',IT_TEXTDOMAIN);	
}
#settings for woocommerce pages
if(it_woocommerce_page()) {	
	$disable_postnav = true;
	$disable_controlbar = true;
	$disable_recommended = true;
	$disable_authorinfo = true;
	$disable_postinfo = true;
	$disable_authorship = true;
	$disable_comments = true;
	$disable_sharing = true;
	$layout = 'classic';
	$pagecss = 'woo-page';
	$article_title = '';
	$contents_menu = 'none';
	$reactions_position = 'none';
	$disable_sidebar = it_get_setting('woo_sidebar_disable');
	if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);	
}
#specific template files
switch($template) {
	case 'template-authors.php':
		$pagecss = 'template-authors';		
		$disable_controlbar = true;	
		$disable_main_header = true;
		$disable_recommended = true;	
		$layout = 'classic';	
	break;	
}

#don't use specific settings if they are not set
if(!empty($thumbnail_specific) && $thumbnail_specific!='') $thumbnail = $thumbnail_specific;

#page-specific settings
$sidebar_disable_meta = get_post_meta($post->ID, "_sidebar_disable", $single = true);
if(!empty($sidebar_disable_meta) && $sidebar_disable_meta!='') $disable_sidebar = $sidebar_disable_meta;
$sidebar_display_meta = get_post_meta($post->ID, "_sidebar_display", $single = true);
if(!empty($sidebar_display_meta) && $sidebar_display_meta!='') $disable_sidebar = false; #overrides site-wide setting
$layout_meta = get_post_meta($post->ID, "_post_layout", $single = true);
if(!empty($layout_meta) && $layout_meta!='' && !is_404()) $layout = $layout_meta;
$thumbnail_meta = get_post_meta($post->ID, "_featured_image_size", $single = true);
if(!empty($thumbnail_meta) && $thumbnail_meta!='') $thumbnail = $thumbnail_meta;
$sidebar_meta = get_post_meta($post->ID, "_custom_sidebar", $single = true);
if(!empty($sidebar_meta) && $sidebar_meta!='') $sidebar = $sidebar_meta;
$post_type = get_post_meta( $post->ID, IT_META_POST_TYPE, $single = true );
$disable_title_meta = get_post_meta($post->ID, IT_META_DISABLE_TITLE, $single = true);
if(!empty($disable_title_meta) && $disable_title_meta!='') $disable_title = $disable_title_meta;
$article_title_meta = get_post_meta($post->ID, "_article_title", $single = true);
if(!empty($article_title_meta) && $article_title_meta!='') $article_title = $article_title_meta;
$disable_review = get_post_meta($post->ID, IT_META_DISABLE_REVIEW, $single = true);
$video = get_post_meta($post->ID, "_featured_video", $single = true);
$sharing_disable_meta = get_post_meta($post->ID, "_sharing_disable", $single = true);
if(!empty($sharing_disable_meta) && $sharing_disable_meta!='') $disable_sharing = $sharing_disable_meta;
$view_count_disable_meta = get_post_meta($post->ID, "_view_count_disable", $single = true);
if(!empty($view_count_disable_meta) && $view_count_disable_meta!='') $disable_view_count = $view_count_disable_meta;
$like_count_disable_meta = get_post_meta($post->ID, "_like_count_disable", $single = true);
if(!empty($like_count_disable_meta) && $like_count_disable_meta!='') $disable_like_count = $like_count_disable_meta;

#contents menu
$contents_menu_display = false;
$contents_menu_meta = get_post_meta($post->ID, "_contents_menu", $single = true);
if($contents_menu=='optin' && $contents_menu_meta) $contents_menu_display = true;
if(($contents_menu=='both' || ($contents_menu=='reviews' && $disable_review!='true')) && !$contents_menu_meta) $contents_menu_display = true;
if($details_position=='none') $disabled_menu_items[] = 'overview';
$menucss = $contents_menu_display ? '' : ' hidden-contents-menu';

#this post is a review
if(it_has_rating($post->ID)) {
	#rich snippets
	$item_type = 'http://schema.org/Review';
	$item_prop = ' itemprop="itemReviewed"';
	$isreview = true;
} elseif($user_rating_disable) {
	$disabled_menu_items[] = 'rating';
	$ratings_position = 'none';
}
if(($post_type=='article' || $disable_review=='true') && $post_article_title_disable) $article_title = '';

#determine layouts and css classes
switch($layout) {
	case 'classic':
		$layoutcss = ' classic-post';
	break;	
	case 'billboard':
		$layoutcss = ' billboard-post';
	break;
	case 'longform':
		$layoutcss = ' longform-post';
		$disable_sidebar = true;
		$details_position = 'bottom';
		$ratings_position = 'bottom';
		$reactions_position = 'bottom';
		$thumbnail = '1200';
		$article_title = '';
	break;
}
if($disable_sidebar) {
	$csscol1 = 'col-sm-12';
	$csscol2 = '';
	$sidebarcss = ' full-width';
} else {
	$csscol1 = 'col-sm-8';
	$csscol2 = 'col-sm-4';
	$sidebarcss = '';
}

#special class for full-width featured images
if($thumbnail == '1200') $imagecss = ' full-image';

$disable_subtitle = empty($subtitle) ? true : false;
$cssadminbar = is_admin_bar_showing() ? ' admin-bar' : '';

#determine featured image floating
if((!$has_details || $details_position!='top') && ($post_type=='article' || $disable_review=='true' || $ratings_position!='top') && $reactions_position!='top' && $thumbnail_meta!='none' && $thumbnail!='1200') $image_can_float = true;
$imagecss = $image_can_float ? ' floated-image' : '';

#get largest size featured images for overlay backgrounds
$overlay_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
$bg_image = get_post_meta($post->ID, "_bg_image", $single = true);
$billboard_overlay = !empty($bg_image) ? $bg_image : $overlay_image[0];

#setup args
$awardsargs = array('postid' => $post->ID, 'single' => true, 'badge' => false, 'white' => true, 'wrapper' => true);
$likesargs = array('postid' => $post->ID, 'label' => true, 'icon' => false, 'clickable' => true, 'tooltip_hide' => true, 'showifempty' => true);
$biglikeargs = array('postid' => $post->ID, 'label' => true, 'icon' => true, 'clickable' => true, 'tooltip_hide' => true, 'showifempty' => true, 'count' => false);
$viewsargs = array('postid' => $post->ID, 'label' => true, 'icon' => false, 'tooltip_hide' => true);
$commentsargs = array('postid' => $post->ID, 'label' => true, 'icon' => false, 'showifempty' => true, 'tooltip_hide' => true, 'anchor_link' => true);
$imageargs = array('postid' => $post->ID, 'size' => 'single-'.$thumbnail, 'width' => 1200, 'height' => 600, 'wrapper' => true, 'itemprop' => true, 'link' => $clickable, 'type' => 'normal', 'caption' => $caption);
$videoargs = array('url' => $video, 'video_controls' => 'true', 'parse' => true, 'frame' => true, 'autoplay' => 0, 'type' => 'embed', 'width' => 640, 'height' => 360);
$sharingargs = array('title' => get_the_title(), 'description' => it_excerpt(500, false), 'url' => get_permalink(), 'showmore' => true, 'style' => 'single');

?>

<?php do_action('it_before_content_page'); ?>

<div id="page-content" <?php post_class($pagecss . ' container-fluid single-page ' . $sidebarcss . $imagecss . $categorycss . $menucss . $layoutcss, $post->ID); ?> data-location="single-page" itemscope itemtype="<?php echo $item_type; ?>" data-postid="<?php echo $post->ID; ?>">

	<div class="row no-margin">
    
    	<?php if(!$disable_postnav) echo it_get_postnav(); ?>
        
		<?php if($layout=='billboard') { ?>
        
            <div class="billboard-wrapper col-sm-12 no-padding">

                <div class="billboard-image" style="background-image:url(<?php echo $billboard_overlay; ?>);"></div>
            
                <div class="billboard-overlay"></div>
                        
                <?php do_action('it_before_billboard_title', it_get_setting('ad_billboard_title_before'), 'before-billboard-title'); ?>
                
                <h1 class="main-title single-title entry-title"<?php echo $item_prop; ?>><?php echo get_the_title(); ?></h1>
                
                <?php if($contents_menu_display) echo it_get_contents_menu(get_the_ID(), $disabled_menu_items); ?>
                
                <?php if(!$disable_authorship_avatar) echo '<div class="billboard-avatar">' . it_get_author_avatar(40) . '</div>'; ?>
                
                <?php if(!$disable_subtitle) echo '<div class="billboard-subtitle">' . $subtitle . '</div>'; ?>           
                
                <?php if(!$disable_authorship) echo '<div class="billboard-authorship">' . it_get_authorship('both', true, true, '', $isreview) . '</div>'; ?>
                
                <?php do_action('it_after_billboard_title', it_get_setting('ad_billboard_title_after'), 'after-billboard-title'); ?>
                            
                <?php if(!$disable_sharing) echo it_get_sharing($sharingargs); ?>
                
            </div>
            
            <div class="after-billboard col-sm-12 no-padding">	
            
                <div class="row no-margin">
        
        <?php } ?>
    
        <div id="main-content" class="<?php echo $csscol1; ?>">
                          
            <?php if (is_404()) : ?>
            
            	<?php do_action('it_before_classic_title', it_get_setting('ad_classic_title_before'), 'before-classic-title'); ?>
            
                <h1 class="main-title"><?php echo $main_title; ?></h1>
    
                <p><?php echo $subtitle; ?></p>
                       
                <div class="row form-404">  
                    <div class="col-md-2"></div>   
                    <form method="get" class="form-search" action="<?php echo home_url(); ?>/"> 
                        <div class="col-md-8">
                            <div class="input-group">
                                <input class="search-query form-control" name="s" id="s" type="text" placeholder="<?php _e('keyword(s)',IT_TEXTDOMAIN); ?>">
                                <span class="input-group-btn"><button class="btn btn-default theme-icon-search" type="button"></button></span>
                            </div>  
                        </div>      
                    </form> 
                    <div class="col-md-2"></div> 
                </div>            
            
            <?php elseif($template=='template-authors.php') : ?>
            
            	<?php do_action('it_before_classic_title', it_get_setting('ad_classic_title_before'), 'before-classic-title'); ?>
            
                <h1 class="main-title"><?php echo get_the_title(); ?></h1>
                    
                <?php echo it_get_content($article_title); ?>
                
                <?php echo it_get_author_loop(); #get authors and display loop ?>                    
                
            <?php elseif (have_posts()) : ?>
        
                <?php while (have_posts()) : the_post(); ?>
                
                    <div id="post-<?php the_ID(); ?>">
                    
                    	<?php if($layout=='longform') { ?>
                        
                        	<?php #featured image
							if($thumbnail!='none' && has_post_thumbnail()) { 
								$imageargs['height'] = 1200;
								$imageargs['link'] = false;
								$imageargs['wrapper'] = false;
								$imageargs['caption'] = false;                                       
								echo '<div class="image-container"><div class="longform-overlay"></div>' . it_featured_image($imageargs) . '</div>';                                       
							} ?>
                            
                            <div class="longform-right">
                            
                            	<div class="clearfix">
                                
                                	<?php if($biglike_position=='meta-bar' || $biglike_position=='before-content' || $biglike_position=='after-content') echo '<div class="big-like clearfix">' . it_get_likes($biglikeargs) . '</div>' ?>
                            
									<?php if(!$disable_like_count) echo it_get_likes($likesargs); ?>
                                        
                                    <?php if(!$disable_view_count) echo it_get_views($viewsargs); ?>
                                    
                                    <?php if(!$disable_comment_count) echo it_get_comments($commentsargs); ?>
                                    
                                </div>
                                
                                <?php if(!$disable_postinfo) echo it_get_post_info(get_the_ID()); ?>
                                
                                <?php if($contents_menu_display) echo it_get_contents_menu(get_the_ID(), $disabled_menu_items, true); ?>
                            
                            </div>
                                            
                            <div class="longform-left">
                            
                            	<div class="control-bar">
                            
                            		<?php if(!empty($category)) echo '<div class="category-box">' . $category . '</div>'; ?>
                                    
                                    <?php if(!$disable_awards) echo it_get_awards($awardsargs); ?>
                                    
                                </div>
                                
                                <?php if(!$disable_sharing) echo it_get_sharing($sharingargs); ?>
                                
                                <?php do_action('it_before_longform_title', it_get_setting('ad_longform_title_before'), 'before-longform-title'); ?>
                            
                                <h1 class="main-title single-title entry-title"<?php echo $item_prop; ?>><?php echo get_the_title(); ?></h1>
                                
                                <?php if(!$disable_subtitle) echo '<div class="main-subtitle">' . $subtitle . '</div>'; ?>	
                                
                                <?php do_action('it_after_longform_title', it_get_setting('ad_longform_title_after'), 'after-longform-title'); ?>
                                
                                <?php if(!$disable_authorship) 
									echo '<div class="longform"><div class="flourish"></div>' . it_get_authorship('both', true, false, '', $isreview) . '</div>'; ?>
                                    
                                <?php if($affiliate_position=='before-content') echo it_get_affiliate_code(get_the_ID()); ?>
                                    
                                <?php #featured video
                                if(!$disable_video && !empty($video)) {                                    
                                    do_action('it_before_featured_video', it_get_setting('ad_video_before'), 'before-video');									
                                    echo it_video($videoargs); 									
                                    do_action('it_after_featured_video', it_get_setting('ad_video_after'), 'after-video');                                    
                                } ?>
                                
                            </div>
                        
                        <?php } else { ?>
                
							<?php if(!$disable_controlbar) { ?>
                    
                                <?php do_action('it_before_metabar', it_get_setting('ad_metabar_before'), 'before-metabar'); ?>
                            
                                <div class="control-bar clearfix">
                                
                                    <?php if(!empty($category)) echo '<div class="control-box">' . $category . '</div>'; ?>
                                    
                                    <?php if(!$disable_view_count) echo '<div class="control-box no-link">' . it_get_views($viewsargs) . '</div>'; ?>
                                    
                                    <?php if(!$disable_like_count) echo '<div class="control-box">' . it_get_likes($likesargs) . '</div>'; ?>
                                    
                                    <?php if(!$disable_comment_count) echo '<div class="control-box">' . it_get_comments($commentsargs) . '</div>'; ?>
                                    
                                    <?php if(!$disable_awards) echo '<div class="control-box control-award">' . it_get_awards($awardsargs) . '</div>'; ?>
                                    
                                    <?php if($biglike_position=='meta-bar') echo '<div class="big-like clearfix">' . it_get_likes($biglikeargs) . '</div>'; ?> 
                                    
                                </div>
                                
                                <?php do_action('it_after_metabar', it_get_setting('ad_metabar_after'), 'after-metabar'); ?> 
                                
                            <?php } ?>
                            
                            <?php if($layout!='billboard') { ?>	
                            
                            	<?php do_action('it_before_classic_title', it_get_setting('ad_classic_title_before'), 'before-classic-title'); ?>
                                            
                            	<?php if(!$disable_title) echo '<h1 class="main-title single-title entry-title"' . $item_prop . '>' . get_the_title() . '</h1>'; ?>	
                            
                            	<?php if(!$disable_subtitle) echo '<div class="main-subtitle">' . $subtitle . '</div>'; ?>
                                
                                <?php do_action('it_after_classic_title', it_get_setting('ad_classic_title_after'), 'after-classic-title'); ?>				
                            
                                <?php if(!$disable_authorship) echo '<div class="longform">' . it_get_authorship('both', true, false, '', $isreview) . '</div>'; ?>
                                
                                <?php if($contents_menu_display) echo it_get_contents_menu(get_the_ID(), $disabled_menu_items); ?>
                                
                                <?php if(!$disable_sharing) echo it_get_sharing($sharingargs); ?>
                                
                            <?php } ?>
                            
                        <?php } ?>
                        
                        <?php                       
						if($layout!='longform') { 
							#featured video
							if(!$disable_video && !empty($video)) {                                    
								do_action('it_before_featured_video', it_get_setting('ad_video_before'), 'before-video');									
								echo it_video($videoargs); 									
								do_action('it_after_featured_video', it_get_setting('ad_video_after'), 'after-video');                                    
							}						                                                          
							#featured image
							if($thumbnail!='none' && has_post_thumbnail()) {                                 
								do_action('it_before_featured_image', it_get_setting('ad_image_before'), 'before-image');                                        
								echo '<div class="image-container">' . it_featured_image($imageargs) . '</div>';                               
								do_action('it_after_featured_image', it_get_setting('ad_image_after'), 'after-image');                                    
							} 
						}
                        #details
                        if($details_position=='top') {                                
                            do_action('it_before_details', it_get_setting('ad_details_before'), 'before-details');								
                            echo it_get_details(get_the_ID(), $overlay_image[0], $isreview); 								
                            do_action('it_after_details', it_get_setting('ad_details_after'), 'after-details');                                
                        }
                        #rating criteria
                        if($ratings_position=='top') {                                
                            do_action('it_before_criteria', it_get_setting('ad_criteria_before'), 'before-criteria');								
                            echo it_get_criteria(get_the_ID(), $overlay_image[0]);								
                            do_action('it_after_criteria', it_get_setting('ad_criteria_after'), 'after-criteria');                                
                        }
                        #reactions
                        if($reactions_position=='top') {                                
                            do_action('it_before_reactions', it_get_setting('ad_reactions_before'), 'before-reactions');								
                            echo it_get_reactions(get_the_ID());								
                            do_action('it_after_reactions', it_get_setting('ad_reactions_after'), 'after-reactions');                                
                        }
						
						#big like button
                        if($biglike_position=='before-content' && $layout!='longform') echo '<div class="big-like clearfix">' . it_get_likes($biglikeargs) . '</div>'; 
						
						#affiliate code
                        if($affiliate_position=='before-content' && $layout!='longform') echo it_get_affiliate_code(get_the_ID()); 
                        
                        #content
                        do_action('it_before_content', it_get_setting('ad_content_before'), 'before-content');                                
                        echo it_get_content($article_title);							
                        do_action('it_after_content', it_get_setting('ad_content_after'), 'after-content');
						
						#affiliate code
                        if($affiliate_position=='after-content') echo it_get_affiliate_code(get_the_ID(), 'after-content'); 
						
						#big like button
                        if($biglike_position=='after-content' && $layout!='longform') echo '<div class="big-like clearfix">' . it_get_likes($biglikeargs) . '</div>'; 
                        
                        #tags and categories
                        if(!$disable_postinfo && $layout!='longform') echo it_get_post_info(get_the_ID());   
                        
                        #details
                        if($details_position=='bottom') {                                
                            do_action('it_before_details', it_get_setting('ad_details_before'), 'before-details');								
                            echo it_get_details(get_the_ID(), $overlay_image[0], $isreview); 								
                            do_action('it_after_details', it_get_setting('ad_details_after'), 'after-details');                                 
                        }
                        #rating criteria  
                        if($ratings_position=='bottom') {                                
                            do_action('it_before_criteria', it_get_setting('ad_criteria_before'), 'before-criteria');								
                            echo it_get_criteria(get_the_ID(), $overlay_image[0]);								
                            do_action('it_after_criteria', it_get_setting('ad_criteria_after'), 'after-criteria');                                
                        }
                        #reactions
                        if($reactions_position=='bottom') {                                
                            do_action('it_before_reactions', it_get_setting('ad_reactions_before'), 'before-reactions');								
                            echo it_get_reactions(get_the_ID());								
                            do_action('it_after_reactions', it_get_setting('ad_reactions_after'), 'after-reactions');                                 
                        } 
                        #author info
                        if(!$disable_authorinfo) {                                
                            do_action('it_before_authorinfo', it_get_setting('ad_authorinfo_before'), 'before-authorinfo');
                            echo it_get_author_info(get_the_ID());
                            do_action('it_after_authorinfo', it_get_setting('ad_authorinfo_after'), 'after-authorinfo');                                
                        }
                        #recommended
                        if(!$disable_recommended){                                
                            do_action('it_before_recommended', it_get_setting('ad_recommended_before'), 'before-recommended');
                            echo it_get_recommended(get_the_ID());
                            do_action('it_after_recommended', it_get_setting('ad_recommended_after'), 'after-recommended');                                
                        }
                        #comments
                        if(!$disable_comments && comments_open()) {                                
                            do_action('it_before_comments', it_get_setting('ad_comments_before'), 'before-comments');
                            comments_template();
                            do_action('it_after_comments', it_get_setting('ad_comments_after'), 'after-comments');                                
                        } ?>                             
                        
                    </div>
                
                <?php endwhile; ?> 
            
            <?php endif; ?> 
            
            <?php wp_reset_query(); ?>
                
        </div> 
        
        <?php if(!$disable_sidebar) { ?> 
        
            <div class="<?php echo $csscol2; ?> sidebar">
        
                <?php echo it_widget_panel($sidebar, ''); ?>
                
            </div>
            
        <?php } ?>
        
        <?php if($layout=='billboard') { ?>
        
                </div>
        
            </div>
            
        <?php } ?>
    
    </div>    
    
</div>

<?php do_action('it_after_content_page'); ?>

<?php wp_reset_query(); ?>