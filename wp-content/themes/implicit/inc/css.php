<?php global $post; ?>
<style type="text/css">
<?php 	 
#TEMPLATE COLORS - do these before accent colors so hovers apply correctly
$c = it_get_setting('color_sticky_bar_bg');
if(!empty($c)) echo '#sticky-bar,a.sticky-dropdown-button,#sticky-social-dropdown {background:'.$c.'}';	
$c = it_get_setting('color_sticky_bar_icons');
if(!empty($c)) echo '.social-badges a,#menu-search span.theme-icon-search,#nav-search span.theme-icon-search,.sticky-button,a.sticky-dropdown-button span,.sticky-button#back-to-top {color:'.$c.'}';
$c = it_get_setting('color_sticky_bar_text');
if(!empty($c)) echo '#sticky-bar .subtitle,#menu-search,a.sticky-dropdown-button,.sticky-dropdown-label,#menu-search input#s, #nav-search input#s {color:'.$c.'}';
$c = it_get_setting('color_sticky_bar_border');
if(!empty($c)) echo '.sticky-dropdown {border-color:'.$c.'} #sticky-bar {border-bottom-color:'.$c.'}';
$c = it_get_setting('color_sticky_nav_bg');
$c_rgb = is_array(hex2rgb($c)) ? implode(',', hex2rgb($c)) : '';
if(!empty($c)) echo '#sticky-nav,.new-articles.selector.active {background:'.$c.'} #section-menu .term-list {background:rgba('.$c_rgb.', 0.38)} #section-menu .placeholder,.new-articles.post-container {background:rgba('.$c_rgb.', 0.92)}';	
$c = it_get_setting('color_sticky_nav_icons');
if(!empty($c)) echo '.connect-email .theme-icon-email,.social-counts .social-panel span,#sticky-nav div.loading span {color:'.$c.'}';
$c = it_get_setting('color_sticky_nav_text');
if(!empty($c)) echo '.social-counts a,.nav-menu li > a,.new-articles.selector,.new-articles.selector.active .new-number,.new-articles.selector.active .new-label,.new-articles.selector.active .theme-icon-right-fat,.new-articles.selector.over .new-number,.new-articles.selector.over .new-label,.new-articles.selector.over .theme-icon-right-fat,#section-menu .mega-wrapper .term-list a {color:'.$c.'}';
$c = it_get_setting('color_sticky_nav_border');
if(!empty($c)) echo '#sticky-nav {border-right-color:'.$c.'} .new-articles.selector.active {border-color:'.$c.'}';
$c = get_background_color();
if(!empty($c)) {
	$c = '#' . $c;
	$c_rgb = implode(",", hex2rgb($c)); 
	?>
body.it-background,.ratings .rating-label,#rating-anchor .rating-value-wrapper,div.scrollingHotSpotLeft,div.scrollingHotSpotRight,.after-billboard,.longform-post .longform-left,.longform-post #main-content .the-content,.longform-post .longform .author,.connect,.utility-menu,.utility-menu ul li ul,.longform-post .longform-right,.longform-post .category-box,.longform-right .big-like,.overlay-info-wrapper,.share-button,.share-panel{background-color:<?php echo $c; ?> !important;}
#recommended .scroller-gradient{background: -moz-linear-gradient(left, rgba(<?php echo $c_rgb; ?>,0) 0%, rgba(<?php echo $c_rgb; ?>,1) 70%, rgba(<?php echo $c_rgb; ?>,1) 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(<?php echo $c_rgb; ?>,0)), color-stop(70%,rgba(<?php echo $c_rgb; ?>,1)>), color-stop(100%,rgba(<?php echo $c_rgb; ?>,1)));
background: -webkit-linear-gradient(left, rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,1) 70%,rgba(<?php echo $c_rgb; ?>,1) 100%);
background: -o-linear-gradient(left, rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,1) 70%,rgba(<?php echo $c_rgb; ?>,1) 100%);
background: -ms-linear-gradient(left, rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,1) 70%,rgba(<?php echo $c_rgb; ?>,1) 100%);
background: linear-gradient(to right, rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,1) 70%,rgba(<?php echo $c_rgb; ?>,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $c; ?>', endColorstr='<?php echo $c; ?>',GradientType=1 );}			
	<?php 
}
$c = it_get_setting('color_secondary_bg');
if(!empty($c)) {
	$c_rgb = implode(",", hex2rgb($c));
	?>
#postnav,.postinfo .post-tags a,.authorinfo,.comment-ratings-inner,#main-content .wp-caption,.contents-menu,.contents-menu .contents-menu-toggle {background:<?php echo $c; ?>}
#respond .ratings .rating-value-wrapper {background:<?php echo $c; ?>!important}
#postnav .previous-button a.nav-link{
background: -moz-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,0) 0%, rgba(<?php echo $c_rgb; ?>,0) 60%, rgba(<?php echo $c_rgb; ?>,1) 95%, rgba(<?php echo $c_rgb; ?>,1) 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(<?php echo $c_rgb; ?>,0)), color-stop(60%,rgba(<?php echo $c_rgb; ?>,0)), color-stop(95%,rgba(<?php echo $c_rgb; ?>,1)), color-stop(100%,rgba(<?php echo $c_rgb; ?>,1)));
background: -webkit-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,0) 60%,rgba(<?php echo $c_rgb; ?>,1) 95%,rgba(<?php echo $c_rgb; ?>,1) 100%);
background: -o-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,0) 60%,rgba(<?php echo $c_rgb; ?>,1) 95%,rgba(<?php echo $c_rgb; ?>,1) 100%);
background: -ms-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,0) 60%,rgba(<?php echo $c_rgb; ?>,1) 95%,rgba(<?php echo $c_rgb; ?>,1) 100%);
background: linear-gradient(to right,  rgba(<?php echo $c_rgb; ?>,0) 0%,rgba(<?php echo $c_rgb; ?>,0) 60%,rgba(<?php echo $c_rgb; ?>,1) 95%,rgba(<?php echo $c_rgb; ?>,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $c; ?>', endColorstr='<?php echo $c; ?>',GradientType=1 );
}
#postnav .next-button a.nav-link{
background: -moz-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,1) 0%, rgba(<?php echo $c_rgb; ?>,1) 5%, rgba(<?php echo $c_rgb; ?>,0) 40%, rgba(<?php echo $c_rgb; ?>,0) 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(<?php echo $c_rgb; ?>,1)), color-stop(5%,rgba(<?php echo $c_rgb; ?>,1)), color-stop(40%,rgba(<?php echo $c_rgb; ?>,0)), color-stop(100%,rgba(<?php echo $c_rgb; ?>,0)));
background: -webkit-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,1) 0%,rgba(<?php echo $c_rgb; ?>,1) 5%,rgba(<?php echo $c_rgb; ?>,0) 40%,rgba(<?php echo $c_rgb; ?>,0) 100%);
background: -o-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,1) 0%,rgba(<?php echo $c_rgb; ?>,1) 5%,rgba(<?php echo $c_rgb; ?>,0) 40%,rgba(<?php echo $c_rgb; ?>,0) 100%);
background: -ms-linear-gradient(left,  rgba(<?php echo $c_rgb; ?>,1) 0%,rgba(<?php echo $c_rgb; ?>,1) 5%,rgba(<?php echo $c_rgb; ?>,0) 40%,rgba(<?php echo $c_rgb; ?>,0) 100%);
background: linear-gradient(to right,  rgba(<?php echo $c_rgb; ?>,1) 0%,rgba(<?php echo $c_rgb; ?>,1) 5%,rgba(<?php echo $c_rgb; ?>,0) 40%,rgba(<?php echo $c_rgb; ?>,0) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $c; ?>', endColorstr='<?php echo $c; ?>',GradientType=1 );
}		
<?php }	
$c = it_get_setting('color_borders');
if(!empty($c)) echo '#postnav,#comments .bar-header,h3#reply-title,.connect,.utility-menu,#comments ul ul .comment,#wp-calendar thead th {border-bottom-color:'.$c.'} .postinfo,.connect,#footer,#subfooter,.utility-menu {border-top-color:'.$c.'} .comment-ratings-inner,#main-content .wp-caption,.ratings .rating-value-wrapper {border-color:'.$c.'} .ratings .rating-line,.longform-post .longform .flourish {background:'.$c.'}';
	
#TEXT COLORS
$c = it_get_setting('color_heading_text');
if(!empty($c)) echo '.bar-label,.widgets .textwidget h2,.widgets .textwidget h3,.widgets .textwidget h4,.widgets .header h3,#wp-calendar caption,.widgets .header a.rsswidget,.widgets ul li a.rsswidget,#main-content h1.single-title,.section-title,#main-content .meta-label, .section-subtitle,#main-content h1,#main-content h2,#main-content h3,#main-content h4,#main-content h5,#main-content h6,.postinfo .postinfo-label,.authorinfo a.author-name,#comments .comment-author,.longform-post #main-content h1.single-title,#comments .comment-header {color:'.$c.'}';	
$c = it_get_setting('color_content_light');
if(!empty($c)) echo '.longform-post #main-content .main-subtitle,.postinfo .category-list,.postinfo .category-list a,.longform .author a,.longform .author,.longform .date,.longform-post .longform-right .labeltext,.longform-post .longform-right .metric, .longform-post .longform-right .metric a,.postinfo .post-tags a,#main-content .wp-caption-text,.ratings .total-info .rating-number,.ratings .rated-legend,.connect-email input,#subfooter,a.longform-more,#wp-calendar tbody,.pagination a, .pagination>span.page-number, .pagination>span.page-numbers,.widgets cite, .widgets #recentcomments,.trending-bar .trending-meta .metric,.load-more,.control-bar .labeltext,.border-panel .authorship.type-author,#postnav>div,#postnav .random-button,#respond p.logged-in-as,.ratings .hovertorate .hover-text,.author-link {color:'.$c.'} #comments a.comment-meta{color:'.$c.'!important}';
$c = it_get_setting('color_content_dark');
if(!empty($c)) echo 'body,a,a:link,a:hover,a:visited,.widgets .social-counts .social-panel a,.widgets span.rss-date,.trending-bar .title,.after-nav .social-counts a,#menu-utility-menu a,.post-blog .longform-excerpt,.control-bar .category-name,#main-content,.contents-menu .sort-buttons a,.border-panel .authorship.type-date,.compact-panel .article-title,.details-box,.large-meter .meter-circle .editor_rating, .large-meter .meter-circle .user_rating,.ratings .rating-value-wrapper,.reaction.clickable,#recommended .sort-buttons a,.longform-post .addthis_32x32_style .addthis_counter.addthis_bubble_style a.addthis_button_expanded{color:'.$c.'}';
$c = it_get_setting('color_icons');
if(!empty($c)) echo '.bar-label .label-text span,.sort-buttons a, .sort-buttons span.page-numbers,.longform-more span,.pagination a.arrow,.load-more>span,.after-nav .social-counts .social-panel span,.widgets .it-widget-tabs .sort-buttons a,.trending-color,.connect-email .theme-icon-email,.procon .header span,.ratings .editor-header span, .ratings .user-header span,#postnav span,.contents-menu .theme-icon-bookmarks,#comments .theme-icon-commented:before,h3#reply-title span,.template-authors .author-profile-fields a{color:'.$c.'} .authorinfo .author-profile-fields a{color:'.$c.'!important}';
		
#MAIN ACCENT COLOR 
$accent = it_get_setting('color_accent');
if(empty($accent)) $accent = '#2A53C1';
$accent_rgb = implode(",", hex2rgb($accent));
$opacity = it_get_setting('hover_opacity');
$opacity = empty($opacity) ? '.80' : '.' . $opacity;
?>		
a:hover,#sticky-controls a:hover,#sticky-controls a.active,.nav-header,.nav-toggle.active span,.nav-toggle.open span,#nav-widgets .social-counts a:hover,#nav-widgets .social-counts a:hover span,.longform-wrapper.active .longform-more span,.sort-buttons a:hover,.sort-buttons a.active,.sort-buttons li.active a,.utility-menu a:hover,.utility-menu li.over>a,.utility-menu li.current-menu-item a,.utility-menu li.current-menu-parent>a,.utility-menu li.current-menu-ancestor>a,a.longform-more:hover,a.longform-more:hover span,.trending-bar.active .trending-meta .metric,.trending-bar.active .trending-title,.widgets #menu-utility-menu a:hover,.widgets .social-counts .social-panel a:hover,.widgets .social-counts .social-panel a:hover span,.contents-menu-toggle.active span,.the-content a:not(.styled),.compact-panel.active .article-title,.contents-menu .sort-buttons a:hover,#recommended .sort-buttons a:hover,#recommended .sort-buttons a.active,#comments a.reply-link,#comments span.current,#comments .pagination a:hover,.longform-post .longform-right a:hover,.trending-bar.active .title,.active .trending-meta,.widgets .it-widget-tabs .ui-tabs-active a,.widgets #wp-calendar a:hover,.reaction.clickable.active,.reaction.selected,.reaction.selected .theme-icon-check,h2.author-name a:hover,.template-authors .author-profile-fields a:hover,.pagination>span.page-number{color:<?php echo $accent; ?>;}
.pagination a:hover,.pagination .active,.pagination a:active,.pagination a.active:hover,/*begin bootstrap compat*/.pagination>.active>a,.pagination>.active>span,.pagination>.active>a:hover,.pagination>.active>span:hover,.pagination>.active>a:focus,.pagination>.active>span:focus,/*end bootstrap compat*/.hover-text.active,.hover-text.active a,.woocommerce .woocommerce-breadcrumb a:hover,.pagination a span.page-number:hover{color:<?php echo $accent; ?> !important;}
.the-content a:hover{color:#000;}
.border-panel {border-left-color:<?php echo $accent; ?>;}	
.overlay-panel.active .overlay-layer,.trending .overlay-panel.active .overlay-layer,.top-ten .overlay-panel.active .overlay-layer,.longform-wrapper.active .overlay-layer,.article-panel.active .article-layer,.load-more-wrapper.active .load-more,.load-more-wrapper.active .load-more > span,.border-panel.active,.trending-bar.active .trending-color {background:rgba(<?php echo $accent_rgb; ?>,<?php echo $opacity; ?>) !important;filter:none;}	
.headliner-layer{background:rgba(<?php echo $accent_rgb; ?>,.75);filter:none;}
.headliner.active .headliner-layer,.sticky-dropdown .sticky-submit{background:rgba(<?php echo $accent_rgb; ?>,1);filter:none;}
.meter-wrapper .meter,.large-meter .meter-wrapper .meter {border-color:<?php echo $accent; ?>;}	
	
<?php
#FONTS
$f = it_get_setting('font_labels_a');	    
if(!empty($f) && $f!='spacer') echo '.nav-header,.sticky-dropdown-label,a.sticky-dropdown-button,a.longform-more,.share-panel .share-label,#wp-calendar caption,#wp-calendar thead th,.longform-post .longform-right .labeltext,.postinfo .postinfo-label,#main-content .meta-label, .section-subtitle,.control-bar .labeltext,.overlay-hover .rating-label,.overlay-panel .category-name,.overlay-panel .review-label,.award-wrapper,.control-bar .category-name,.longform .date,.border-panel .authorship.type-date,.pagination a, .pagination>span.page-number, .pagination>span.page-numbers,.reaction-text,a.like-button, .metric {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_labels_b');	    
if(!empty($f) && $f!='spacer') echo '.longform .author,.load-more,.bar-label,.widgets .textwidget h2,.widgets .textwidget h3,.widgets .textwidget h4,.widgets .header h3,#wp-calendar caption,.widgets .header a.rsswidget,.widgets ul li a.rsswidget,.section-title,#main-content .meta-label, .section-subtitle,.postinfo .postinfo-label,.authorinfo a.author-name,#comments .comment-author,.longform-post #main-content h1.single-title,#comments .comment-header,#postnav .article-title,.border-panel .authorship.type-author,.longform .author a,.longform .author,.billboard-authorship .authorship, .billboard-authorship .authorship a,h1.main-title, h1.page-title {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_overlays_a');	    
if(!empty($f) && $f!='spacer') echo '.articles .wide .article-title,.topten-widget .textfill,.billboard-wrapper h1.main-title,.headliner-info .textfill {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_overlays_b');	    
if(!empty($f) && $f!='spacer') echo '.overlay-panel .article-title,.billboard-subtitle {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_menus');	    
if(!empty($f) && $f!='spacer') echo '.new-articles.selector .new-label,.nav-menu li > a,#section-menu .mega-wrapper .term-list a,#menu-utility-menu a,.contents-menu .sort-buttons a,#recommended .sort-buttons a,#comments a.reply-link {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_main_a');	    
if(!empty($f) && $f!='spacer') echo '#main-content,#main-content .main-subtitle {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_main_b');	    
if(!empty($f) && $f!='spacer') echo '.post-blog .longform-excerpt,.longform-post #main-content .the-content {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_widgets');	    
if(!empty($f) && $f!='spacer') echo '.widgets .widget,.social-counts a,.social-counts a:link,.social-counts a:visited,#subfooter,.border-panel .article-title {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_classic');	    
if(!empty($f) && $f!='spacer') echo '#main-content h1.single-title {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_longform');	    
if(!empty($f) && $f!='spacer') echo '.longform-post #main-content h1.single-title {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_headers_a');	    
if(!empty($f) && $f!='spacer') echo '#main-content .the-content h1,#main-content .the-content h2,#main-content .the-content h3 {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_headers_b');	    
if(!empty($f) && $f!='spacer') echo '#main-content .the-content h4,#main-content .the-content h5,#main-content .the-content h6 {font-family:'.$f.';font-weight:normal;font-style:normal}';
$f = it_get_setting('font_numbers');	    
if(!empty($f) && $f!='spacer') echo '.widgets .social-counts .social-panel a,.longform-post .longform-right .metric,.ratings .rating-value-wrapper,.rating .number, .rating .letter,.reaction-percentage,.overlay-number,.trending-number .metric {font-family:'.$f.';font-weight:normal;font-style:normal}';
#FONT SIZES
$f = it_get_setting('font_menus_size');	    
if(!empty($f)) echo '.new-articles.selector .new-label,.nav-menu li > a,#section-menu .mega-wrapper .term-list a,#menu-utility-menu a,.contents-menu .sort-buttons a,#recommended .sort-buttons a,#comments a.reply-link {font-size:'.$f.'px;}';
$f = it_get_setting('font_content_a_size');	    
if(!empty($f)) echo '#main-content .the-content {font-size:'.$f.'px;}';
$f = it_get_setting('font_content_b_size');	    
if(!empty($f)) echo '.post-blog .longform-excerpt, .longform-post #main-content .the-content {font-size:'.$f.'px;}';

/*
#GET PAGE SPECIFIC BACKGROUNDS
if(is_single() || is_page()) { 		
	$bg_color = get_post_meta($post->ID, "_bg_color", $single = true);
	if(!empty($bg_color) && $bg_color!='#') $bg_billboard = $bg_color;		
	$bg_color_override = get_post_meta($post->ID, "_bg_color_override", $single = true);
	$bg_image = get_post_meta($post->ID, "_bg_image", $single = true);
	$bg_position = get_post_meta($post->ID, "_bg_position", $single = true);
	$bg_repeat = get_post_meta($post->ID, "_bg_repeat", $single = true);
	$bg_attachment = get_post_meta($post->ID, "_bg_attachment", $single = true);		
	$layout = is_single() ? it_get_setting('post_layout') : 'classic';
	$layout_meta = get_post_meta($post->ID, "_post_layout", $single = true);
	if(!empty($layout_meta) && $layout_meta!='') $layout = $layout_meta;		
}
#GET CATEGORY SPECIFIC BACKGROUNDS - overwrites page-specific if any
$category_id = it_page_in_category($post->ID);
if($category_id) {
	$categories = it_get_setting('categories');	 
	foreach($categories as $category) {
		if(is_array($category)) {
			if(array_key_exists('id',$category)) {
				if($category['id'] == $category_id) {
					if(!empty($category['bg_color'])) {
						$bg_color=$category['bg_color'];
						$bg_color_override='';
					}
					if(!empty($category['bg_image'])) $bg_image=$category['bg_image'];
					if(!empty($category['bg_position'])) $bg_position=$category['bg_position'];
					if(!empty($category['bg_repeat'])) $bg_repeat=$category['bg_repeat'];
					if(!empty($category['bg_attachment'])) $bg_attachment=$category['bg_attachment'];
					break;
				}
			}
		}
	}		
}
#APPLY BACKGROUNDS
if(is_single() || is_page() || $category_id) {
	if($bg_color) { 
		$bg_color_rgb = implode(",", hex2rgb($bg_color)); ?>
		body.it-background,.ratings .rating-label,
		.ratings .rating-value-wrapper,
		div.scrollingHotSpotLeft,
		div.scrollingHotSpotRight,
		.after-billboard,
		.longform-post .longform-left,
		.longform-post #main-content .the-content,
		.longform-post .longform .author{background-color:<?php echo $bg_color; ?> !important;}
		#recommended .scroller-gradient{background: -moz-linear-gradient(left, rgba(<?php echo $bg_color_rgb; ?>,0) 0%, rgba(<?php echo $bg_color_rgb; ?>,1) 70%, rgba(<?php echo $bg_color_rgb; ?>,1) 100%);
		background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(<?php echo $bg_color_rgb; ?>,0)), color-stop(70%,rgba(<?php echo $bg_color_rgb; ?>,1)>), color-stop(100%,rgba(<?php echo $bg_color_rgb; ?>,1)));
		background: -webkit-linear-gradient(left, rgba(<?php echo $bg_color_rgb; ?>,0) 0%,rgba(<?php echo $bg_color_rgb; ?>,1) 70%,rgba(<?php echo $bg_color_rgb; ?>,1) 100%);
		background: -o-linear-gradient(left, rgba(<?php echo $bg_color_rgb; ?>,0) 0%,rgba(<?php echo $bg_color_rgb; ?>,1) 70%,rgba(<?php echo $bg_color_rgb; ?>,1) 100%);
		background: -ms-linear-gradient(left, rgba(<?php echo $bg_color_rgb; ?>,0) 0%,rgba(<?php echo $bg_color_rgb; ?>,1) 70%,rgba(<?php echo $bg_color_rgb; ?>,1) 100%);
		background: linear-gradient(to right, rgba(<?php echo $bg_color_rgb; ?>,0) 0%,rgba(<?php echo $bg_color_rgb; ?>,1) 70%,rgba(<?php echo $bg_color_rgb; ?>,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $bg_color; ?>', endColorstr='<?php echo $bg_color; ?>',GradientType=1 );
		}
	<?php } ?>
	<?php if($bg_color_override) { ?>
		body.it-background {background-image:none !important;}
	<?php } ?>
	<?php if($bg_image) { ?>
		body.it-background {background-image:url(<?php echo $bg_image; ?>) !important;}
	<?php } ?>
	<?php if($bg_position) { ?>
		body.it-background {background-position:top <?php echo $bg_position; ?> !important;}
	<?php } ?>
	<?php if($bg_repeat) { ?>
		body.it-background {background-repeat:<?php echo $bg_repeat; ?> !important;}
	<?php } ?>
	<?php if($bg_attachment) { ?>
		body.it-background {background-attachment:<?php echo $bg_attachment; ?> !important;}
	<?php } ?>	
	<?php if($layout=='billboard') { ?>
		body.it-background {background-image:none !important;}
	<?php } 		
} 
*/
#CATEGORIES
$categories = it_get_setting('categories');
foreach($categories as $category) {
	if(is_array($category)) {
		if(array_key_exists('id',$category)) {
			if(!empty($category['id'])) {
				$id = $category['id'];
				$icon = $category['icon'];
				$iconhd = $category['iconhd'];
				$iconwhite = $category['iconwhite'];
				$iconhdwhite = $category['iconhdwhite'];
				if(empty($iconwhite)) $iconwhite = $icon;
				if(empty($iconhdwhite)) $iconhdwhite = $iconhd;	
				$color = $category['color'];
				$color_rgb = empty($color) ? '' : implode(",", hex2rgb($color));
				?>
#section-menu ul li.menu-item-<?php echo $id; ?> > a{border-right:2px solid <?php echo $color; ?>}									
#section-menu ul li.menu-item-<?php echo $id; ?>.hover > a,
#section-menu ul li.menu-item-<?php echo $id; ?>.over > a,
#section-menu ul li.menu-item-<?php echo $id; ?>.current-menu-item > a {background:<?php echo $color; ?>;filter:none;}	
.article-panel.active.category-<?php echo $id; ?> .article-layer,
.overlay-panel.active.category-<?php echo $id; ?> .overlay-layer,
.trending .overlay-panel.active.category-<?php echo $id; ?> .overlay-layer,
.top-ten .overlay-panel.active.category-<?php echo $id; ?> .overlay-layer,
.longform-wrapper.active.category-<?php echo $id; ?> .overlay-layer {background:rgba(<?php echo $color_rgb; ?>,<?php echo $opacity; ?>)!important;filter:none;}
.border-panel.category-<?php echo $id; ?>.active,
.sort-buttons.sort-sections a.category-<?php echo $id; ?>.active,
.sort-buttons.sort-sections a.category-<?php echo $id; ?>:hover,
.load-more-wrapper.active .load-more,
.load-more-wrapper.active .load-more > span,
.category-<?php echo $id; ?> .headliner.active .headliner-layer {background:<?php echo $color; ?> !important;filter:none;}
#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .term-list a:hover, 
#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .term-list a.active,
.longform-wrapper.active.category-<?php echo $id; ?> .longform-more span,
.category-<?php echo $id; ?> .sort-buttons a.active,
.category-<?php echo $id; ?> .sort-buttons a:hover,
.category-<?php echo $id; ?> .sort-buttons li.active a,
.category-<?php echo $id; ?> .contents-menu-toggle.active span,
.category-<?php echo $id; ?> .reaction.clickable.active, 
.category-<?php echo $id; ?> .reaction.selected, 
.category-<?php echo $id; ?> .reaction.selected .theme-icon-check,
.category-<?php echo $id; ?> .postinfo .category-list a:hover,
.category-<?php echo $id; ?> #recommended .sort-buttons a:hover, 
.category-<?php echo $id; ?> #recommended .sort-buttons a.active,
.category-<?php echo $id; ?> #comments a.reply-link,
.category-<?php echo $id; ?> #comments span.current{color:<?php echo $color; ?>;}
.sort-buttons.sort-sections a.category-<?php echo $id; ?> {border-bottom-color:<?php echo $color; ?>}
.category-<?php echo $id; ?> .headliner-layer {background:rgba(<?php echo $color_rgb; ?>,.75)}
.category-<?php echo $id; ?> .large-meter .meter-wrapper .meter {border-color:<?php echo $color; ?>;}
.category-<?php echo $id; ?> .pagination a:hover,
.category-<?php echo $id; ?> .pagination .active,
.category-<?php echo $id; ?> .pagination a:active,
.category-<?php echo $id; ?> .pagination a.active:hover,
.category-<?php echo $id; ?> .pagination a span.page-number:hover,
.category-<?php echo $id; ?> #comments .pagination a:hover,
.category-<?php echo $id; ?> .longform-right a:hover{color:<?php echo $color; ?> !important;}
.compact-panel.category-<?php echo $id; ?>.active .article-title,
.border-panel.category-<?php echo $id; ?> {border-left-color:<?php echo $color; ?>;}
@media screen {
.category-icon-<?php echo $id; ?> {background:url(<?php echo $icon; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
.category-icon-<?php echo $id; ?>.white, .sort-sections a.active .category-icon-<?php echo $id; ?>, .sort-sections a.over .category-icon-<?php echo $id; ?>, #section-menu ul li.hover > a .category-icon-<?php echo $id; ?>, #section-menu ul li.over > a .category-icon-<?php echo $id; ?>, #section-menu ul li.current-menu-item > a .category-icon-<?php echo $id; ?> {background:url(<?php echo $iconwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}		
}
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dppx) {
.category-icon-<?php echo $id; ?> {background:url(<?php echo $iconhd; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
.category-icon-<?php echo $id; ?>.white, .sort-sections a.active .category-icon-<?php echo $id; ?>, .sort-sections a.over .category-icon-<?php echo $id; ?>, #section-menu ul li.hover > a .category-icon-<?php echo $id; ?>, #section-menu ul li.over > a .category-icon-<?php echo $id; ?>, #section-menu ul li.current-menu-item > a .category-icon-<?php echo $id; ?> {background:url(<?php echo $iconhdwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}		
}
			<?php } 
		}
	}
}	
#AWARDS/BADGES
$awards = it_get_setting('review_awards');
foreach($awards as $award){ 
	if(is_array($award)) {
		if(array_key_exists(0, $award)) {
			$awardname = stripslashes($award[0]->name);
			$awardid = it_get_slug($awardname, $awardname);
			$awardicon = $award[0]->icon;
			$awardiconwhite = $award[0]->iconwhite;
			if(empty($awardiconwhite)) $awardiconwhite = $awardicon;
			?>
.award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardicon; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
.white .award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardiconwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
		<?php } 
	}
}	
#APPLY CUSTOM CSS - leave the opening/closing php tags to create better view source readability
#general
if( it_get_setting( 'custom_css' ) ) echo stripslashes( it_get_setting( 'custom_css' ) );	
?>
<?php 
#large only
if( it_get_setting( 'custom_css_lg' ) ) { ?> 
@media (min-width: 1200px) {<?php echo stripslashes( it_get_setting( 'custom_css_lg' ) )?>} 
<?php }
#medium and down
if( it_get_setting( 'custom_css_md' ) ) { ?> 
@media (max-width: 1199px) {<?php echo stripslashes( it_get_setting( 'custom_css_md' ) )?>} 
<?php }
#medium only
if( it_get_setting( 'custom_css_md_only' ) ) { ?> 
@media (min-width: 992px) and (max-width: 1199px) {<?php echo stripslashes( it_get_setting( 'custom_css_md_only' ) )?>} 
<?php }
#small and down
if( it_get_setting( 'custom_css_sm' ) ) { ?> 
@media (max-width: 991px) {<?php echo stripslashes( it_get_setting( 'custom_css_sm' ) )?>} 
<?php }
#small only
if( it_get_setting( 'custom_css_sm_only' ) ) { ?> 
@media (min-width: 768px) and (max-width: 991px) {<?php echo stripslashes( it_get_setting( 'custom_css_sm_only' ) )?>} 
<?php }
#extra small only
if( it_get_setting( 'custom_css_xs' ) ) { ?> 
@media (max-width: 767px) {<?php echo stripslashes( it_get_setting( 'custom_css_xs' ) )?>} 
<?php }	?>
</style>