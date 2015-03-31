<?php 
if(!function_exists('it_enqueue_scripts')) {
	#enqueue scripts
	function it_enqueue_scripts() {
		
		wp_register_script('it-plugins', THEME_JS_URI . '/plugins.min.js', false, false, true);
		#wp_register_script('it-plugins', THEME_JS_URI . '/plugins.js', false, false, true);	
		wp_register_script('it-scripts', THEME_JS_URI . '/scripts.min.js', false, false, true);	
		#wp_register_script('it-scripts', THEME_JS_URI . '/scripts.js', false, false, true);	
		wp_register_script('it-addthis', 'http://s7.addthis.com/js/300/addthis_widget.js#async=1', false, false, true);		
		
		#jquery
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('jquery-effects-slide');
		wp_enqueue_script('jquery-touch-punch');
		
		#other scripts
		wp_enqueue_script('it-plugins');
		wp_enqueue_script('it-scripts');
		wp_enqueue_script('it-addthis');			
		 
		#wp ajax library
		wp_enqueue_script('itajax-request', THEME_URI . '/js/ajax.min.js', array( 'jquery' ));
		#wp_enqueue_script('itajax-request', THEME_URI . '/js/ajax.js', array( 'jquery' ));
		wp_localize_script('itajax-request', 'itAjax', array('ajaxurl' => admin_url( 'admin-ajax.php' )));		
	}
}
if(!function_exists('fallback_categories')) {
	#get fallback categories
	function fallback_categories() {	
		echo "<ul>";
		$menu = wp_list_categories('title_li=&depth=0&echo=0');
		$menu = preg_replace('/title=\"(.*?)\"/','',$menu);
		echo $menu;
		echo "</ul>";
	}
}
if(!function_exists('fallback_pages')) {
	#get fallback pages
	function fallback_pages() {	
		echo "<ul>";
		$menu = wp_list_pages('title_li=&depth=1&echo=0');
		$menu = preg_replace('/title=\"(.*?)\"/','',$menu);
		echo $menu;
		echo "</ul>";
	}
}
if(!function_exists('show_posts_nav')) {
	#if more than one page exists, return true
	function show_posts_nav($total_comments) {    
		$page_comments = get_option('page_comments');
		$comments_per_page = get_option('comments_per_page');
		if ($page_comments && ($total_comments>$comments_per_page)) {
			return true;
		} else {
			return false;
		}
	}
}
if(!function_exists('get_category_id')) {
	#get a category id from a category name
	function get_category_id($cat_name){
		$term = get_term_by('name', $cat_name, 'category');
		return $term->term_id;
	}
}
if(!function_exists('get_tag_id')) {
	#get a tag id from a tag name
	function get_tag_id($tag_name){
		$term = get_term_by('name', $tag_name, 'post_tag');
		return $term->term_id;
	}
}
if(!function_exists('get_ID_by_slug')) {
	#returns page ID from page slug
	function get_ID_by_slug($page_slug) {
		$page = get_page_by_path($page_slug);
		if ($page) {
			return $page->ID;
		} else {
			return null;
		}
	}
}
if(!function_exists('get_term_top_most_parent')) {
	#determine the topmost parent of a term
	function get_term_top_most_parent($term_id, $taxonomy){
		#start from the current term
		$parent  = get_term_by( 'id', $term_id, $taxonomy);
		if($parent->parent) {
			#climb up the hierarchy until we reach a term with parent = '0'
			while ($parent->parent != '0'){
				$term_id = $parent->parent;	
				$parent  = get_term_by( 'id', $term_id, $taxonomy);
			}
		}
		return $parent;
	}
}
if(!function_exists('it_get_template_part')) {
	#get template parts from inc/ folder
	function it_get_template_part($template_part, $require_once = true) {
		do_action( 'it_get_template_part' );
		if ( file_exists( CHILD_THEME_DIR . '/inc/' . $template_part . '.php') )
			load_template( CHILD_THEME_DIR . '/inc/' . $template_part . '.php', $require_once);
		else if ( file_exists( THEME_DIR . '/inc/' . $template_part . '.php') )
			load_template( THEME_DIR . '/inc/' . $template_part . '.php', $require_once);
	}
}
if(!function_exists('it_get_template_file')) {
	#which template file is currently being displayed
	function it_get_template_file() {
		global $wp_query;
		$page_id = $wp_query->get_queried_object_id();
		$template_file = get_post_meta( $page_id, '_wp_page_template', true );	
		return $template_file;
	}
}
if(!function_exists('it_component_disabled')) {
	#determine if a component should be disabled for a specific part of the theme
	function it_component_disabled($component, $postid = NULL, $forcepage = false) {
		$disable = false;
		$template = it_get_template_file();
		#the default setting
		if(it_get_setting($component . '_disable')) $disable = true;
		#archive-specific setting
		if(is_archive()) {
			if(it_get_setting('archive_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#search-specific setting
		if(is_search()) {
			if(it_get_setting('search_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#404-specific setting
		if(is_404()) {
			if(it_get_setting('404_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#page-specific setting
		if(is_page() && (!$forcepage && !is_front_page())) {
			if(it_get_setting('page_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#post-specific setting
		if(is_single()) {
			if(it_get_setting('post_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#template-specific setting
		if($template=='template-directory.php') {
			if(it_get_setting('directory_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#force page-specific setting - mostly used for front page
		if(is_page() && $forcepage) {
			if(it_get_setting('page_' . $component . '_disable')) {
				$disable = true;
			} else {
				$disable = false;	
			}
		}
		#global setting overrides all other settings
		if(it_get_setting($component . '_disable_global')) $disable = true;
			
		return $disable;
	}
}
if(!function_exists('it_get_slug')) {
	#turn a name into a safe slug
	function it_get_slug($slug, $name) {
		$safe_slug = ( !empty( $slug ) ) ? stripslashes(preg_replace('/[^a-z0-9_]/i', '', strtolower($slug))) : preg_replace('/[^a-z0-9_]/i', '', strtolower($name));
		return $safe_slug;	
	}
}
if(!function_exists('it_get_url_slug')) {
	#turn a name into a safe url string
	function it_get_url_slug($name, $slug) {
		$safe_url_slug = stripslashes(preg_replace('/[^a-z0-9_]/i', '', strtolower($name)));
		if(empty($safe_url_slug)) $safe_url_slug = stripslashes(preg_replace('/[^a-z0-9_]/i', '', strtolower($slug)));
		$safe_url_slug = str_replace('_','-',$safe_url_slug);
		return $safe_url_slug;	
	}
}
if(!function_exists('it_timeperiod_label')) {
	#setup time period labels
	function it_timeperiod_label($timeperiod) {
		switch($timeperiod) {
			case '-7 days':
				$timeperiod = __('Past Week',IT_TEXTDOMAIN);
			break;	
			case '-30 days':
				$timeperiod = __('Past Month',IT_TEXTDOMAIN);
			break;	
			case '-60 days':
				$timeperiod = __('Past 2 Months',IT_TEXTDOMAIN);
			break;	
			case '-90 days':
				$timeperiod = __('Past 3 Months',IT_TEXTDOMAIN);
			break;
			case '-180 days':
				$timeperiod = __('Past 6 Months',IT_TEXTDOMAIN);
			break;
			case '-365 days':
				$timeperiod = __('Past Year',IT_TEXTDOMAIN);
			break;	
			case 'all':
				$timeperiod = __('All Time',IT_TEXTDOMAIN);
			break;	
			default:
				$timeperiod = $timeperiod;
			break;		
		}
		return $timeperiod;
	}
}
if(!function_exists('it_get_setting')) {
	#get theme options
	function it_get_setting( $option = '' ) {
		$settings = '';
	
		if ( !$option )
			return false;
	
		$settings = str_replace('\"', '"', get_option( IT_SETTINGS ));
		$settings = str_replace("\'", "'", $settings);
		
		if( !empty( $settings[$option] ) )
			return $settings[$option];
			
		return false;
	}
}
if(!function_exists('it_setup_filters')) {
	#get default filter args based on disabled filters
	function it_setup_filters($disabled, $args, $format) {		
		if(!in_array('recent', $disabled)) {
			$default_metric = 'recent';
			$args['orderby'] = 'date';
			$default_label = __('Most Recent', IT_TEXTDOMAIN);
		} elseif(!in_array('viewed', $disabled)) {
			$default_metric = 'viewed';
			$args['meta_key'] = IT_META_TOTAL_VIEWS;
			$args['orderby'] = 'meta_value_num';
			$default_label = __('Most Views', IT_TEXTDOMAIN);
		} elseif (!in_array('liked', $disabled)) {
			$default_metric = 'liked';
			$args['meta_key'] = IT_META_TOTAL_LIKES;
			$args['orderby'] = 'meta_value_num';
			$default_label = __('Most Likes', IT_TEXTDOMAIN);
		} elseif (!in_array('reviewed', $disabled)) {
			$default_metric = 'reviewed';
			$format['rating'] = true;
			$args['meta_key'] = IT_META_TOTAL_SCORE_NORMALIZED;
			$args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ), array( 'key' => IT_META_TOTAL_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN'));
			$args['orderby'] = 'meta_value_num';
			$default_label = __('Best Reviewed', IT_TEXTDOMAIN);
		} elseif (!in_array('rated', $disabled)) {
			$default_metric = 'users';
			$format['rating'] = true;
			$args['meta_key'] = IT_META_TOTAL_USER_SCORE_NORMALIZED;
			$args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ), array( 'key' => IT_META_TOTAL_USER_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN'));
			$args['orderby'] = 'meta_value_num';
			$default_label = __('Highest Rated', IT_TEXTDOMAIN);
		} elseif (!in_array('commented', $disabled)) {
			$default_metric = 'commented';
			$args['orderby'] = 'comment_count';
			$args['meta_key'] = '';
			$default_label = __('Most Comments', IT_TEXTDOMAIN);
		} elseif (!in_array('awarded', $disabled)) {
			$default_metric = 'awarded';
			$args['meta_key'] = '';
			$args['meta_query'] = array( array( 'key' => IT_META_AWARDS, 'value' => array(''), 'compare' => 'NOT IN') );
			$args['orderby'] = 'date';
			$default_label = __('Recently Awarded', IT_TEXTDOMAIN);
		}
		$format['metric'] = $default_metric;
		#setup return array
		$return = array('default_metric' => $default_metric, 'default_label' => $default_label, 'args' => $args, 'format' => $format);
		return $return;
	}
}
if(!function_exists('it_get_authors')) {
	#get object of authors 
	function it_get_authors($display_admins, $order_by, $role, $hide_empty, $manual_exclude) {
		
		#setup initial arrays
		$args = array();
		$exclude = array();
		
		#ordering
		$order_by = empty($order_by) ? 'display_name' : $order_by;
		$args['orderby'] = $order_by;
		
		#specific role
		if($role!='all' && $role!='nonsubscriber') $args['role'] = $role;
		
		#exclude subscribers
		if($role!='subscriber' && $role!='all') {
			$subscribers = get_users('role=subscriber');
			foreach($subscribers as $sub) {
				$exclude[] = $sub->ID;	
			}
		}
		#exclude admins
		if(empty($display_admins) && $role!='administrator') {		
			$admins = get_users('role=administrator');		
			foreach($admins as $ad) {
				$exclude[] = $ad->ID;
			}				
		}
		#add manual excludes
		if(!empty($manual_exclude)) {		
			$manual_exclude = explode(',', $manual_exclude);
			foreach($manual_exclude as $username) {
				$user = get_userdatabylogin($username);	
				$exclude[] = $user->ID;
			}		
		}
		$args['exclude'] = $exclude;
		$users = get_users($args);
		$authors = array();
		foreach ($users as $user) {
			$thisuser = get_userdata($user->ID);
			if(!empty($hide_empty)) {
				$numposts = count_user_posts($thisuser->ID);
				if($numposts < 1) continue;
			}
			$authors[] = (array) $thisuser;
		}	
		return $authors;
	}
}
if(!function_exists('filter_where')) {
	#used by the where filter in the post loop
	function filter_where( $where = '' ) {	
		global $timewhere;	
		$where .= " AND post_date > '" . date('Y-m-d', strtotime($timewhere)) . "'";
		return $where;
	}
}
if(!function_exists('author_link_new_window')) {	
	#open comment author's links in new windows
	function author_link_new_window() {
		$url = get_comment_author_url();
		$author = get_comment_author();
		if (empty( $url ) || 'http://' == $url)
			$return = $author;
		else
			$return = "<a href='$url' rel='external nofollow' class='url' target='_blank'>$author</a>";
		return $return;
	}
}
if(!function_exists('it_hide_comment')) {
	#if comment is empty add specific text to use to target and hide it later
	function it_hide_comment($postid){
		if(it_get_setting('review_allow_blank_comments')) {
			if(!(it_get_setting('review_user_rating_disable') && it_get_setting('review_user_comment_procon_disable') && it_get_setting('review_user_comment_rating_disable'))) {
				$val = rand(0, 384534);
				if(empty($_POST['comment'])) $_POST['comment'] = $val."_it_hide_this_comment";
			}
		}
	}
}
if(!function_exists('it_encode')) {
	#used for exporting/importing theme options
	function it_encode( $content, $serialize = false ) {	
		if( $serialize )
			$encode = rtrim(strtr(base64_encode(gzdeflate(htmlspecialchars(serialize( $content )), 9)), '+/', '-_'), '=');
		else
			$encode = rtrim(strtr(base64_encode(gzdeflate(htmlspecialchars( $content ), 9)), '+/', '-_'), '=');		
		
		return $encode;
	}
}
if(!function_exists('it_decode')) {
	#used for exporting/importing theme options
	function it_decode( $content, $unserialize = false ) {
		$decode = @gzinflate(base64_decode(strtr( $content, '-_', '+/')));
		
		if( !$unserialize )
			$decode = htmlspecialchars_decode( $decode );
		else
			$decode = unserialize(htmlspecialchars_decode( $decode ) );
		
		return $decode;
	}
}
if(!function_exists('it_ajax_request')) {
	#determine if current call is AJAX
	function it_ajax_request() {
		if( ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) && ( strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) )
			return true;		
		return false;
	}
}
if(!function_exists('it_cleanup_shortcode')) {
	function it_cleanup_shortcode( $content ) { 
		$content = do_shortcode( shortcode_unautop( $content ) ); 
		$content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}
if(!function_exists('it_shortcodes_exempt')) {
	function it_shortcodes_exempt($shortcodes){
		$shortcodes[] = 'toggles';
		$shortcodes[] = 'tabs';
		$shortcodes[] = 'carousel';
		return $shortcodes;
	}
}
if(!function_exists('it_nospam')) {
	#obfuscates email addresses
	function it_nospam( $email, $filterLevel = 'normal' ) {
		$email = strrev( $email );
		$email = preg_replace( '[@]', '//', $email );
		$email = preg_replace( '[\.]', '/', $email );
	
		if( $filterLevel == 'low' ) 	{
			$email = strrev( $email );
		}	
		return $email;
	}
}
if(!function_exists('it_shortcodes')) {
	#get list of shortcodes
	function it_shortcodes() {
		$shortcodes = array();
		if ( is_dir( THEME_SHORTCODES ) ) {
			if ( $dh = opendir( THEME_SHORTCODES ) ) {
				while ( false !== ( $file = readdir( $dh ) ) ) {
					if( $file != '.' && $file != '..' && stristr( $file, '.php' ) !== false )
						$shortcodes[] = $file;
				}
				
				closedir( $dh );
			}
		}
		asort( $shortcodes );
		return $shortcodes;
	}
}
if (!function_exists('it_shortcodes_init')) {
	#initialize shortcodes
	function it_shortcodes_init() {
		foreach( it_shortcodes() as $shortcodes )
			if ( file_exists( CHILD_THEME_SHORTCODES . '/' . $shortcodes ) )
				require_once( CHILD_THEME_SHORTCODES . '/' . $shortcodes );
			else if ( file_exists( THEME_SHORTCODES . '/' . $shortcodes ) )
				require_once THEME_SHORTCODES . '/' . $shortcodes;
			
		if( is_admin() )
			return;		
			
		# Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
		//@ini_set('pcre.backtrack_limit', 9000000);
			
		foreach( it_shortcodes() as $shortcodes ) {
			$class = 'it' . ucfirst( preg_replace( '/[0-9-_]/', '', str_replace( '.php', '', $shortcodes ) ) );
			$class_methods = get_class_methods( $class );
	
			foreach( $class_methods as $shortcode )
				if( $shortcode[0] != '_' )
					add_shortcode( $shortcode, array( $class, $shortcode ) );
		}
	}
}
if(!function_exists('feedReader')) {
	#used by twitter/facebook/rss functions
	function feedReader($source, $method) {
		if (function_exists('curl_init')) {
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_URL, $source);
			$data = curl_exec($ch);
			curl_close($ch);
		} else {
			$data = file_get_contents($source);
			}
		if ($method == "xml") {
			$resource = new SimpleXMLElement($data, LIBXML_NOCDATA);
		}
		else if ($method == "json") {
			$resource = json_decode($data, true);
			}
		return $resource;
	}
}
if(!function_exists('wpse12721_wp_redirect')) {
	#debugging purposes to trace and print the redirects done by wordpress
	function wpse12721_wp_redirect( $location ) {
		#get a backtrace of who called us
		debug_print_backtrace();
		#cancel the redirect
		return false;
	}
}
if(!function_exists('it_custom_login_logo')) {
	#custom Login Logo
	function it_custom_login_logo() {
		if (it_get_setting("login_logo_url")) {
			$out = '<style type="text/css">#login h1 a { background:url('.it_get_setting("login_logo_url").') no-repeat center center !important; background-size: auto auto !important;width:auto; }
		</style>';
		print $out;
		}
	}
}
if(!function_exists('it_wp_title')) {
	#pollish up the title
	function it_wp_title( $title, $sep ) {
		global $paged, $page;
	
		if ( is_feed() ) return $title;
	
		# add the site name.
		$title .= get_bloginfo( 'name' );
	
		# add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
	
		# add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', IT_TEXTDOMAIN ), max( $paged, $page ) );
	
		return $title;
	}
}
if(!function_exists('it_custom_menus')) {
	#custom menus
	function it_custom_menus() {
		register_nav_menus(array( 'section-menu' => __( 'Section Menu',IT_TEXTDOMAIN ), 'secondary-menu' => __( 'Secondary Menu',IT_TEXTDOMAIN ), 'utility-menu' => __( 'Utility Menu',IT_TEXTDOMAIN )));
	}
}
if(!function_exists('it_get_best_rating')) {
	#get the best rating for rich snippet purposes
	function it_get_best_rating($postid) {	
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		switch($metric) {
			case 'number':
				$best_rating = 10;
			break;
			case 'percentage':	
				$best_rating = 100;
			break;
			case 'letter':
				$best_rating = 100;
			break;
			case 'stars':
				$best_rating = 5;
			break;
		}	
		return $best_rating;
	}
}
if(!function_exists('it_facebook_image')) {
	#facebook thumbnail image
	function it_facebook_image() {
		$out = '';
		global $post;
		$postid = isset($post) ? $post->ID : '';
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'widget-post' ); 
		if(!empty($image)) $out .= '<meta property="og:image" content="'.$image[0].'" />'; 
		echo $out;
	}
}
if(!function_exists('it_woocommerce_page')) {
	#check for woocommerce page
	function it_woocommerce_page() {
		if((function_exists('is_cart') && is_cart()) || (function_exists('is_account_page') && is_account_page()) || (function_exists('is_checkout') && is_checkout()) || (function_exists('is_woocommerce') && is_woocommerce()) || (function_exists('is_order_received_page') && is_order_received_page())) {
			return true;
		} else {
			return false;
		}	
	}
}
if(!function_exists('it_buddypress_page')) {
	#check for buddypress or bbpress page
	function it_buddypress_page() {
		if((function_exists('bp_current_component') && bp_current_component()) || (function_exists('is_bbpress') && is_bbpress())) {
			return true;
		} else {
			return false;
		}	
	}
}
if(!function_exists('it_boxed_page')) {
	#determine if current page should have boxed layout
	function it_boxed_page() {
		$boxed = false;
		$template = it_get_template_file();
		
		if(is_single() && it_get_setting('post_boxed')) $boxed = true;
		if((is_page() || is_404()) && it_get_setting('page_boxed')) $boxed = true;
		if(is_front_page() && it_get_setting('front_boxed')) $boxed = true;
		if((is_search() || is_archive()) && it_get_setting('archive_boxed')) $boxed = true;
		if($template=='template-authors.php' && it_get_setting('author_boxed')) $boxed = true;
		if($template=='template-directory.php' && it_get_setting('directory_boxed')) $boxed = true;
		if(it_buddypress_page()) {
			if(it_get_setting('bp_boxed')) {
				$boxed = true;
			} else {
				$boxed = false;
			}			
		}
		if(it_woocommerce_page()) {
			if(it_get_setting('woo_boxed')) {
				$boxed = true;
			} else {
				$boxed = false;
			}			
		}
		
		return $boxed;
	}
}
if(!function_exists('it_page_in_category')) {
	#determine if the current page is within a managed category
	function it_page_in_category($postid = NULL) {	
		if(!(is_archive() || is_single())) return false;
		if(is_single()) {
			#get just the primary category id
			$categoryargs = array('postid' => $postid, 'label' => false, 'icon' => false, 'white' => true, 'single' => true, 'wrapper' => false, 'id' => true);	
			$category_id = it_get_primary_categories($categoryargs);
		} elseif(is_archive()) {
			$category_id = get_query_var('cat');
		}		
		return $category_id;
	}
}
if(!function_exists('it_page_like_button')) {
	#display like button on pages
	function it_page_like_button() {
		global $post;
		$likesargs = array('postid' => $post->ID, 'label' => true, 'icon' => true, 'clickable' => true, 'long_label' => true, 'showifempty' => true);
		if(get_post_type($post->ID)=='page' && !it_woocommerce_personal())
			if(!it_component_disabled('likes', $post->ID)) echo it_get_likes($likesargs);	
	}
}
if(!function_exists('it_post_pagination')) {
	#display post pagination
	function it_post_pagination() {
		global $post;
		$args = array('echo' => 1, 'before' => '<div class="pagination bar-header clearfix"><div class="bar-label-wrapper"><div class="bar-label light"><div class="label-text">' . __('PAGES',IT_TEXTDOMAIN) . '<span class="theme-icon-right-fat"></span></div></div></div>', 'after' => '</div>', 'link_before' => '<span class="page-number">', 'link_after' => '</span>');			
		wp_link_pages($args);	
	}
}
if(!function_exists('it_get_random_article')) {
	#get random article permalink
	function it_get_random_article() {
		$out = '';
		$args = array('posts_per_page' => 1, 'orderby' => 'rand', 'ignore_sticky_posts' => 1);
		$rand_loop = new WP_Query($args);
		if ($rand_loop->have_posts()) : while ($rand_loop->have_posts()) : $rand_loop->the_post();						
			$out .= get_permalink();
		endwhile; 
		endif; 
		wp_reset_query();
		return $out;
	}
}
if(!function_exists('it_twitter_count')) {	
	function it_twitter_count($username){	
		$count = get_transient( 'it_twitter_count' );
		if($count === false || $count == -1) {						
			require_once('twitter.php');	
			$settings = array(
				'oauth_access_token' => IT_TWITTER_USER_TOKEN,
				'oauth_access_token_secret' =>  IT_TWITTER_USER_SECRET,
				'consumer_key' => IT_TWITTER_CONSUMER_KEY,
				'consumer_secret' => IT_TWITTER_CONSUMER_SECRET
			);
			if(empty($username)) $username = 'envato'; 
			$url = 'https://api.twitter.com/1.1/users/show.json';
			$getfield = '?screen_name=' . $username;
			$requestMethod = 'GET';
			
			$twitter = new TwitterAPIExchange($settings);
			$results = $twitter->setGetfield($getfield)
						 ->buildOauth($url, $requestMethod)
						 ->performRequest();
						 
			$results = json_decode($results, true);
			if(is_array($results)) {
				if(array_key_exists('followers_count',$results)) $count = $results['followers_count'];
			}
			if(empty($count)) $count = -1;
			set_transient( 'it_twitter_count', $count, HOUR_IN_SECONDS * 6 );
		}
		return $count;
	}
}
if(!function_exists('it_facebook_count')) {
	function it_facebook_count($url) {
		$count = get_transient( 'it_facebook_count' );
		if($count === false || $count == -1) {	
			if(empty($url)) $url = 'https://www.facebook.com/envato'; 
			$fb_id = basename($url);
			$query = 'http://graph.facebook.com/'.$fb_id;
			$result = feedReader($query, "json");
			if(is_array($result)) {
				if(array_key_exists('likes',$result)) {
					$count = $result["likes"];
				}
			}
			if(empty($count)) $count = -1;
			set_transient( 'it_facebook_count', $count, HOUR_IN_SECONDS * 6 );
		}
		return $count;
	}
}
if(!function_exists('it_gplus_count')) {
	function it_gplus_count($url) {
		$count = get_transient( 'it_gplus_count' );
		if($count === false || $count == -1) {	
			if(empty($url)) $url = 'https://plus.google.com/u/0/112286665725634842068?rel=author';
			$data = file_get_contents($url);
			if($data) {
				if (preg_match('/>([0-9,]+) people</i', $data, $matches)) {
					$results =  str_replace(',', '', $matches[1]);
				}	 
				if ( isset ( $results ) && !empty ( $results ) ) {
					$count = $results;
				} else {
					 $count = -1;
				}
				set_transient( 'it_gplus_count', $count, HOUR_IN_SECONDS * 6 );
			}
		}
		return $count;
	}
}
if(!function_exists('it_youtube_count')) {
	function it_youtube_count($username) {
		$count = get_transient( 'it_youtube_count' );
		if($count === false || $count == -1) {	
			if(is_simplexml() && function_exists('file_get_contents')) {			
				if(empty($username)) $username = 'screenjunkies';                   
				$data = file_get_contents('http://gdata.youtube.com/feeds/api/users/' . $username); 
				$xml = new SimpleXMLElement($data);
				$stats_data = (array)$xml->children('yt', true)->statistics->attributes();
				$stats_data = $stats_data['@attributes'];
				$count = $stats_data['subscriberCount'];
			} else {
				$count = __('Enable SimpleXML and file_get_contents', IT_TEXTDOMAIN);	
				$count = __('Enable SimpleXML and/or file_get_contents', IT_TEXTDOMAIN);	
			}
			if(empty($count)) $count = -1;
			set_transient( 'it_youtube_count', $count, HOUR_IN_SECONDS * 6 );
		}
		return $count;		
	}
}
if(!function_exists('it_pinterest_count')) {
	function it_pinterest_count($url) {
		$count = get_transient( 'it_pinterest_count' );
		if($count === false || $count == -1) {	
			$url = rtrim($url, '/');
			if(is_curl()) {
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $url . '/likes');
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
				$json = curl_exec($ch);
				curl_close($ch);
				$count = json_decode($json, true);
				$count = $count['meta']['count'];
			} else {
				$count = __('Enable Curl', IT_TEXTDOMAIN);
			}
			if(empty($count)) $count = -1;
			set_transient( 'it_pinterest_count', $count, HOUR_IN_SECONDS * 6 );
		}
		return $count;		
	}
}
if(!function_exists('is_bot')) {
	#check if user is bot/crawler
	function is_bot(){ 
		$bot_list= array("Ask Jeeves","Baiduspider","Butterfly","FAST","Feedfetcher-Google","Firefly","Gigabot","Googlebot","InfoSeek","Me.dium","Mediapartners-Google","NationalDirectory","Rankivabot","Scooter","Slurp","Sogou web spider","Spade","TECNOSEEK","TechnoratiSnoop","Teoma","TweetmemeBot","Twiceler","Twitturls","URL_Spider_SQL","WebAlta Crawler","WebBug","WebFindBot","ZyBorg","alexa","appie","crawler","froogle","girafabot","inktomi","looksmart","msnbot","rabaz","www.galaxy.com");
		$user_agent= $_SERVER["HTTP_USER_AGENT"];	 
		 
		foreach($bot_list as $bot){	 
			if(strpos($user_agent,$bot)!== false){		 
				return true;		 
			} 	 
			return false;	 
		} 
	}
}
if(!function_exists('it_get_ip')) {
	#get the user's ip address
	function it_get_ip() {
		if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ip_address = $_SERVER["REMOTE_ADDR"];
		} else {
			$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		if(strpos($ip_address, ',') !== false) {
			$ip_address = explode(',', $ip_address);
			$ip_address = $ip_address[0];
		}
		return esc_attr($ip_address);
	}
}
if(!function_exists('is_curl')) {
	function is_curl(){
		return function_exists('curl_version');
	}
}
if(!function_exists('is_simplexml')) {
	function is_simplexml() {
		$array = array();
		$array = get_loaded_extensions();
		$result = false;
		foreach ($array as $i => $value) {
			if (strtolower($value) == "simplexml") $result = true;
		}
		return $result;
	}
}

if(!function_exists('it_save_profile_fields')) {
	#save author profile fields
	function it_save_profile_fields($userID) {
		if (!current_user_can('edit_user', $userID)) return false;
		update_user_meta($userID, 'twitter', $_POST['twitter']);
		update_user_meta($userID, 'facebook', $_POST['facebook']);
		update_user_meta($userID, 'googleplus', $_POST['googleplus']);
		update_user_meta($userID, 'linkedin', $_POST['linkedin']);
		update_user_meta($userID, 'pinterest', $_POST['pinterest']);
		update_user_meta($userID, 'flickr', $_POST['flickr']);
		update_user_meta($userID, 'youtube', $_POST['youtube']);
		update_user_meta($userID, 'instagram', $_POST['instagram']);
		update_user_meta($userID, 'vimeo', $_POST['vimeo']);	
		update_user_meta($userID, 'stumbleupon', $_POST['stumbleupon']);
	}
}
if(!function_exists('it_user_profile_fields')) {
	#display author profile fields
	function it_user_profile_fields($user) {
	?>
		<h3><?php _e( 'Social Profiles', IT_TEXTDOMAIN ); ?></h3>
	
		<table class='form-table'>
			<tr>
				<th><label for='twitter'><?php _e( 'Twitter', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='twitter' id='twitter' value='<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your Twitter username.', IT_TEXTDOMAIN ); ?> http://www.twitter.com/<strong>username</strong></span>
				</td>
			</tr>
			<tr>
				<th><label for='facebook'><?php _e( 'Facebook', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='facebook' id='facebook' value='<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your Facebook username/alias.', IT_TEXTDOMAIN ); ?> http://www.facebook.com/<strong>username</strong></span>
				</td>
			</tr>
			<tr>
                <th><label for='googleplus'><?php _e( 'Google Plus', IT_TEXTDOMAIN ); ?></label></th>
                <td>
                    <input type='text' name='googleplus' id='googleplus' value='<?php echo esc_attr(get_the_author_meta('googleplus', $user->ID)); ?>' class='regular-text' />
                    <br />
                    <span class='description'><?php _e( 'Enter your Google Plus URL.', IT_TEXTDOMAIN ); ?> <strong>http://plus.google.com/112286665725634842068</strong></span>
                </td>
			</tr>
			<tr>
				<th><label for='linkedin'><?php _e( 'LinkedIn', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='linkedin' id='linkedin' value='<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your LinkedIn username.', IT_TEXTDOMAIN ); ?> http://www.linkedin.com/in/<strong>username</strong></span>
				</td>
			</tr>
			<tr>
				<th><label for='pinterest'><?php _e( 'Pinterest', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='pinterest' id='pinterest' value='<?php echo esc_attr(get_the_author_meta('pinterest', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your Pinterest username.', IT_TEXTDOMAIN ); ?> http://www.pinterest.com/<strong>username</strong>/</span>
				</td>
			</tr>        
			<tr>
				<th><label for='flickr'><?php _e( 'Flickr', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='flickr' id='flickr' value='<?php echo esc_attr(get_the_author_meta('flickr', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your Flickr username.', IT_TEXTDOMAIN ); ?> http://www.flickr.com/photos/<strong>username</strong>/</span>
				</td>
			</tr>
			<tr>
				<th><label for='youtube'><?php _e( 'YouTube', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='youtube' id='youtube' value='<?php echo esc_attr(get_the_author_meta('youtube', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your YouTube username.', IT_TEXTDOMAIN ); ?> http://www.youtube.com/user/<strong>username</strong>/</span>
				</td>
			</tr>
			<tr>
				<th><label for='instagram'><?php _e( 'Instagram', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='instagram' id='instagram' value='<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your Instagram username.', IT_TEXTDOMAIN ); ?> http://instagram.com/<strong>username</strong></span>
				</td>
			</tr>
			<tr>
				<th><label for='vimeo'><?php _e( 'Vimeo', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='vimeo' id='vimeo' value='<?php echo esc_attr(get_the_author_meta('vimeo', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your Vimeo username.', IT_TEXTDOMAIN ); ?> http://www.vimeo.com/<strong>username</strong>/</span>
				</td>
			</tr>
			<tr>
				<th><label for='stumbleupon'><?php _e( 'StumbleUpon', IT_TEXTDOMAIN ); ?></label></th>
				<td>
					<input type='text' name='stumbleupon' id='stumbleupon' value='<?php echo esc_attr(get_the_author_meta('stumbleupon', $user->ID)); ?>' class='regular-text' />
					<br />
					<span class='description'><?php _e( 'Enter your StumbleUpon username.', IT_TEXTDOMAIN ); ?> http://www.stumbleupon.com/stumbler/<strong>username</strong>/</span>
				</td>
			</tr>
		</table>
	<?php }
}
#Disable BuddyPress registration in favor of default WordPress registration
function it_disable_bp_registration() {
	if(it_get_setting('bp_register_disable')) {
		remove_action( 'bp_init',    'bp_core_wpsignup_redirect' );
		remove_action( 'bp_screens', 'bp_core_screen_signup' );
	}
}
function it_redirect_bp_signup_page($page ){
	if(it_get_setting('bp_register_disable')) {
		return bp_get_root_domain() . '/wp-signup.php'; 
	}
}
if(!function_exists('hex2rgb')) {
	function hex2rgb($hexString){
		$hexString = preg_replace("/[^abcdef0-9]/i","",$hexString);
		if(strlen($hexString)==6){			
			list($r,$g,$b) = str_split($hexString,2);
			return Array("r"=>hexdec($r),"g"=>hexdec($g),"b"=>hexdec($b));
		}
		return false;
	}
}
if(!function_exists('it_embed_html')) {
	function it_embed_html( $html ) {
		return '<div class="video-container">' . $html . '</div>';
	}
}
?>