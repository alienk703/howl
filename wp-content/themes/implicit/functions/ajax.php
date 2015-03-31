<?php
if(!function_exists('itajax_view')) {	
	#user rating
	function itajax_view() {
		
		$postid=$_POST['postID'];
		
		$views = 0;
		
		#don't count bots and crawlers as views
		if(!is_bot() && !empty($postid)) {	
		
			#get the user's ip address
			$ip=it_get_ip();
			
			#get meta info
			$ips = get_post_meta($postid, IT_META_VIEW_IP_LIST, $single = true);
			$addipmeta = !metadata_exists('post', $postid, IT_META_VIEW_IP_LIST) ? true : false;
			
			$views = get_post_meta($postid, IT_META_TOTAL_VIEWS, $single = true);
			$addviewsmeta = !metadata_exists('post', $postid, IT_META_TOTAL_VIEWS) ? true : false;
			
			$do_update=true;
			if(strpos($ips,$ip) !== false && !it_get_setting('unique_views_disable')) $do_update=false;
			
			#$do_update=true; #testing purposes only
			
			if($do_update) {
				$ip.=';'; #add delimiter	
				$ips.=$ip; #add ip to string
				$views+=1; #increase views	
			
				#figure out whether to add or update the ip address meta field
				if($addipmeta) {
					add_post_meta($postid, IT_META_VIEW_IP_LIST, $ips);
				} else {
					update_post_meta($postid, IT_META_VIEW_IP_LIST, $ips);
				}
				
				#figure out whether to add or update the total views meta field
				if($addviewsmeta) {
					add_post_meta($postid, IT_META_TOTAL_VIEWS, $views);
				} else {
					update_post_meta($postid, IT_META_TOTAL_VIEWS, $views);
				}	
			}
			
		}
		
		#generate the response
		$response = json_encode( array( 'content' => $views ) );
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;
	}
}
if(!function_exists('itajax_share')) {	
	#post loop sharing
	function itajax_share() {
		
		$postid=$_POST['postID'];
		$labels=$_POST['labels'];
		
		$likesargs = array('postid' => $postid, 'label' => false, 'icon' => true, 'clickable' => true, 'showifempty' => true, 'tooltip_hide' => true);			
		$viewsargs = array('postid' => $postid, 'label' => false, 'icon' => true, 'tooltip_hide' => true);		
		$commentsargs = array('postid' => $postid, 'label' => false, 'icon' => true, 'showifempty' => false, 'anchor_link' => false, 'tooltip_hide' => true);
		$sharingargs = array('title' => get_the_title($postid), 'description' => '', 'url' => get_permalink($postid), 'showmore' => false, 'style' => 'loop', 'tooltip_hide' => true);
		
		#begin output
		$out = '';
								
		$out .= '<div class="share-trending clearfix">';
		
			if($labels=='show') $out .= '<div class="share-label">' . __('Trending',IT_TEXTDOMAIN) . '</div>';
		
			if(!it_get_setting('share_likes_disable')) $out .= it_get_likes($likesargs);
			
			if(!it_get_setting('share_views_disable')) $out .= it_get_views($viewsargs);
			
			if(!it_get_setting('share_comments_disable')) $out .= it_get_comments($commentsargs);
		
		$out .= '</div>';
		
		$out .= '<div class="share-sharing clearfix">';
		
			if($labels=='show') $out .= '<div class="share-label">' . __('Sharing',IT_TEXTDOMAIN) . '</div>';
		
			$out .= it_get_sharing($sharingargs);
		
		$out .= '</div>';
		
		#generate the response
		$response = json_encode( array( 'content' => $out ) );
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;	
	}
}
if(!function_exists('itajax_like')) {
	#like button
	function itajax_like() {
		
		$postid=$_POST["postID"];
		$likeaction=$_POST["likeaction"];
		$location=$_POST["location"];
		
		$ip=it_get_ip();
		
		#get meta info
		$ips = get_post_meta($postid, IT_META_LIKE_IP_LIST, $single = true);
		$likes = get_post_meta($postid, IT_META_TOTAL_LIKES, $single = true);
		
		$ip.=';'; #add delimiter
		
		if($likeaction=='like') {
			$ips.=$ip; #add ip to string
			$likes+=1; #increase likes
		} else {
			$ips = str_replace($ip,'',$ips); #remove ip from string
			$likes-=1; #decrease likes
		}
		
		#update post meta
		update_post_meta($postid, IT_META_LIKE_IP_LIST, $ips);
		update_post_meta($postid, IT_META_TOTAL_LIKES, $likes);
		
		if($likes=='') $likes=0;
		#determine label
		if($location=='single-page') {
			if($likes==1) {
				$likes.='<span class="labeltext">'.__(' like',IT_TEXTDOMAIN).'</span>';
			} else {
				$likes.='<span class="labeltext">'.__(' likes',IT_TEXTDOMAIN).'</span>';
			}
		} else {
			if($likes==0) $likes=''; #don't display 0 count
		}
		
		#generate the response
		$response = json_encode( array( 'content' => $likes ) );
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;	
	}
}
if(!function_exists('itajax_reaction')) {
	#user reaction
	function itajax_reaction() {
		
		$postid=$_POST["postID"];
		$reaction=$_POST["reaction"];
		$unlimitedreactions=$_POST["unlimitedreactions"];
		
		$ip = it_get_ip();
		$ip .= ';';
		$response_number = 0;
		$addflag = false;
		$removeflag = false;
		$response = array();
		$numbers = array();
		
		#get total reactions for this post
		$total_reactions = get_post_meta($postid, IT_META_TOTAL_REACTIONS, $single = true);
		$total_reactions = !empty($total_reactions) ? $total_reactions : 0;
		
		#are there any reactions in the theme options?
		$reactions = it_get_setting('reactions');
		if ( isset($reactions['keys']) && $reactions['keys'] != '#' ) {
			
			#get excluded reactions for this post
			$excluded_reactions = get_post_meta($postid, IT_META_REACTIONS, $single = true);
			if(unserialize($excluded_reactions)) $excluded_reactions = unserialize($excluded_reactions);
			
			#loop through all possible reaction metas and adjust as necessary
			$reactions_keys = explode(',',$reactions['keys']);
			foreach ($reactions_keys as $rkey) {
				if ( $rkey != '#') {
					$reaction_name = ( !empty( $reactions[$rkey]['name'] ) ) ? stripslashes($reactions[$rkey]['name']) : '#';
					$reaction_slug = ( !empty( $reactions[$rkey]['slug'] ) ) ? $reactions[$rkey]['slug'] : it_get_slug($reaction_name, $reaction_name);	
					
					#check to see if this reaction is excluded for this post
					if(!empty($reaction_slug) && !in_array($reaction_slug,$excluded_reactions)) {	
					
						#get current reaction ips
						$ips = get_post_meta($postid, '_'.$reaction_slug.'_ips', $single = true);
						#$ips = get_post_meta($postid, $reaction_slug.'_ips', $single = true);
						#get current reaction number
						$number = get_post_meta($postid, '_'.$reaction_slug, $single = true);
						#$number = get_post_meta($postid, $reaction_slug, $single = true);
						$number = !empty($number) ? $number : 0;
						
						#see if ip already exists (might exist if unlimited reactions is turned on)
						$pos = strpos($ips,$ip);
						#is this the reaction that was clicked?
						if($reaction_slug == $reaction) {
							if($pos === false) {
								$ips .= $ip;
							}
							$addflag = true; #we added a reaction
							#increment number by one
							$number += 1;
							#this is the number we return to the ajax call
							$response_number = $number;
						} else {
							if(!$unlimitedreactions && $pos !== false) {
								$ips = str_replace($ip,'',$ips); #remove ip from string
								if($number > 0) $number -= 1;
								$removeflag = true; #we removed a reaction
							}
						}
						
						#update post meta
						update_post_meta($postid, '_'.$reaction_slug.'_ips', $ips);
						update_post_meta($postid, '_'.$reaction_slug, $number);
						#update_post_meta($postid, $reaction_slug.'_ips', $ips);
						#update_post_meta($postid, $reaction_slug, $number);
						
						$numbers[$reaction_slug] = $number;
						
					}
				}
			}
		}
		
		#increase and update total reactions if this is a new reaction and not a "switch"
		if($addflag && !$removeflag) {
			$total_reactions += 1;
			update_post_meta($postid, IT_META_TOTAL_REACTIONS, $total_reactions);
		}
		
		foreach($numbers as $reaction => $number) {
		
			#calculate new percentage
			$percentage = $total_reactions != 0 ? round(($number / $total_reactions) * 100, 0) : 0;
			$percentage .= '%';
			$response[$reaction] = $percentage;
			
		}
		
		#generate the response
		$response = json_encode( $response );
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;	
	}
}
if(!function_exists('itajax_user_rate')) {	
	#user rating
	function itajax_user_rate() {
		
		$postid=$_POST["postID"];
		$meta=$_POST["meta"];
		$metric=$_POST["metric"];
		$rating=$_POST["rating"];
		$divID=$_POST["divID"];
		
		#setup the args
		$ratingargs = array('postid' => $postid, 'meta' => $meta, 'metric' => $metric, 'rating' => $rating);
		
		#perform the actual meta updates
		$ratings = it_save_user_ratings($ratingargs);
		
		#generate the response
		$response = json_encode(array('newrating' => $ratings['new_rating'], 'totalrating' => $ratings['total_rating'], 'normalized' => $ratings['normalized'], 'divID' => $divID, 'unlimitedratings' => $ratings['unlimitedratings'], 'cssfill' => $ratings['cssfill'], 'amount' => $ratings['amount']));
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;
	}
}
if(!function_exists('itajax_menu_terms')) {	
	#mega menu hovers
	function itajax_menu_terms() {
		
		$object=$_POST["object"];
		$objectid=$_POST["objectid"];
		$object_name=$_POST["object_name"];
		$loop=$_POST["loop"];
		$thumbnail=$_POST["thumbnail"];
		$numarticles=$_POST["numarticles"];
		$type=$_POST["type"];
		
		$menu_args = array('object' => $object, 'objectid' => $objectid, 'object_name' => $object_name, 'loop' => $loop, 'thumbnail' => $thumbnail, 'numarticles' => $numarticles, 'type' => $type, 'useparent' => false);
		
		$menu_content = it_mega_menu_item($menu_args);	
		
		#generate the response
		$response = json_encode( array( 'content' => $menu_content ) );
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;	
	}
}
if(!function_exists('itajax_sort')) {	
	#loop sorting
	function itajax_sort() {
		
		$postid=isset($_POST["postID"]) ? $_POST["postID"] : '';
		$loop=isset($_POST["loop"]) ? $_POST["loop"] : '';
		$location=isset($_POST["location"]) ? $_POST["location"] : '';
		$layout=isset($_POST["layout"]) ? $_POST["layout"] : '';
		$thumbnail=isset($_POST["thumbnail"]) ? $_POST["thumbnail"] : '';
		$icon=isset($_POST["icon"]) ? $_POST["icon"] : '';
		$meta=isset($_POST["meta"]) ? $_POST["meta"] : '';
		$icon=isset($_POST["icon"]) ? $_POST["icon"] : '';
		$award=isset($_POST["award"]) ? $_POST["award"] : '';
		$badge=isset($_POST["badge"]) ? $_POST["badge"] : '';
		$authorship=isset($_POST["authorship"]) ? $_POST["authorship"] : '';
		$excerpt=isset($_POST["excerpt"]) ? $_POST["excerpt"] : '';
		$paginated=isset($_POST["paginated"]) ? $_POST["paginated"] : '';
		$rating=isset($_POST["rating"]) ? $_POST["rating"] : '';
		$numarticles=isset($_POST["numarticles"]) ? $_POST["numarticles"] : '';
		$sorter=isset($_POST["sorter"]) ? $_POST["sorter"] : '';
		$method=isset($_POST["method"]) ? $_POST["method"] : '';
		$title=isset($_POST["title"]) ? $_POST["title"] : '';	
		$query=isset($_POST["currentquery"]) ? $_POST["currentquery"] : '';
		$object=isset($_POST["object"]) ? $_POST["object"] : '';
		$object_name=isset($_POST["object_name"]) ? $_POST["object_name"] : '';
		$timeperiod=isset($_POST["timeperiod"]) ? $_POST["timeperiod"] : '';
		$size=isset($_POST["size"]) ? $_POST["size"] : '';
		$increment=isset($_POST["increment"]) ? $_POST["increment"] : '';
		$start=isset($_POST["start"]) ? $_POST["start"] : '';
		
		#defaults
		$out = '';
		$args = array();
		$format = array();
		$content_before = '';
		$content_after = '';
		
		switch ($loop) {
			case 'trending':
				#setup loop format
				$format = array('loop' => $loop, 'location' => $location, 'numarticles' => $numarticles, 'metric' => $sorter);
				switch($sorter) {					
					case 'liked':
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_LIKES);	
						break;
					case 'viewed':
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_VIEWS);	
						break;					
					case 'commented':
						$args = array('orderby' => 'comment_count');	
						break;					
				}
				$args['posts_per_page'] = $numarticles;
				#add current query to new query args
				if(!empty($query) && is_array($query)) $args = array_merge($args, $query);
			break;
			case 'top ten':
				#setup loop format
				$format = array('loop' => $loop, 'location' => $location, 'metric' => $sorter);
				switch($sorter) {
					case 'liked':
						$args = array('order' => 'DESC', 'meta_key' => IT_META_TOTAL_LIKES, 'orderby' => 'meta_value_num');
						break;
					case 'viewed':
						$args = array('order' => 'DESC', 'meta_key' => IT_META_TOTAL_VIEWS, 'orderby' => 'meta_value_num');	
						break;
					case 'users':
						$format['rating'] = true;
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_USER_SCORE_NORMALIZED, 'meta_query' => array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ), array( 'key' => IT_META_TOTAL_USER_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN')));	
						break;
					case 'reviewed':
						$format['rating'] = true;
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_SCORE_NORMALIZED, 'meta_query' => array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ), array( 'key' => IT_META_TOTAL_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN')));	
						break;
					case 'commented':
						$args = array('orderby' => 'comment_count');	
						break;
				}
				$args['posts_per_page'] = 10;
				#add current query to new query args
				if(!empty($query) && is_array($query)) $args = array_merge($args, $query);
			break;
			case 'main':
				#setup loop format
				$format = array('loop' => $loop, 'location' => $location, 'layout' => $layout, 'sort' => $sorter, 'paged' => $paginated, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'numarticles' => $numarticles, 'increment' => $increment, 'start' => $start);
				switch($sorter) {
					case 'recent':
						$args = array('orderby' => 'date');
						break;
					case 'liked':
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_LIKES);	
						break;
					case 'viewed':
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_VIEWS);	
						break;
					case 'reviewed':
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_SCORE_NORMALIZED, 'meta_query' => array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ), array( 'key' => IT_META_TOTAL_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN')));	
						break;
					case 'users':
						$format['rating'] = true;
						$args = array('orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_USER_SCORE_NORMALIZED, 'meta_query' => array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ), array( 'key' => IT_META_TOTAL_USER_SCORE_NORMALIZED, 'value' => '0', 'compare' => 'NOT IN')));	
						break;
					case 'commented':
						$args = array('orderby' => 'comment_count');	
						break;
					case 'awarded':
						$args = array('orderby' => 'date', 'order' => 'DESC', 'meta_query' => array( array( 'key' => IT_META_AWARDS, 'value' => array(''), 'compare' => 'NOT IN') ));	
						break;
					case 'title':
						$args = array('orderby' => 'title', 'order' => 'ASC');
						break;
				}
				$args['posts_per_page'] = $numarticles;
				$args['paged'] = $paginated;
				#add current query to new query args
				if(!empty($query) && is_array($query)) $args = array_merge($args, $query);
			break;			
			case 'menu':
				#setup loop format
				$format = array('loop' => $loop, 'location' => $location, 'thumbnail' => $thumbnail, 'rating' => false, 'icon' => false, 'size' => $size, 'width' => $width, 'height' => $height);
				$args = array('posts_per_page' => $numarticles, $object_name => $sorter);
				
				#add loading to content
				$content_before = '<div class="loading"><span class="theme-icon-spin2"></span></div>';
				
				#add more link to content
				$term_link = get_term_link($sorter, $object);				
				
			break;
			case 'sections':
				#setup loop format
				$format = array('loop' => 'sections', 'location' => $location, 'layout' => $layout, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'nonajax' => true, 'numarticles' => $numarticles, 'sort' => 'recent', 'size' => $size);
				$args = array('posts_per_page' => $numarticles, 'order' => 'DESC', 'ignore_sticky_posts' => true, 'cat' => $sorter);
				
				#add more link to content
				$link = get_category_link( $sorter );
				$content_after = '<div class="longform-wrapper"><a class="longform-more" href="' . esc_url($link) . '">' . __('VIEW ALL',IT_TEXTDOMAIN) . '<span class="theme-icon-right-thin"></span></a></div>';
				
			break;
			case 'recommended':									
				#format
				$format = array('loop' => $loop, 'location' => $location, 'sort' => $sorter, 'paged' => $paginated, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'numarticles' => $numarticles);	
				switch($method) {
					case 'tags':
						$args=array('tag_id' => $sorter);	
						break;
					case 'categories':
						$args=array('cat' => $sorter);	
						break;
				}
				$args['posts_per_page'] = $numarticles;
				$args['post__not_in'] = array($postid);
				#recommended targeted
				if(!empty($targeted)) $args['post_type'] = $targeted;
			break;
		}
		#add the time period to the args
		$week = date('W');
		$month = date('n');
		$year = date('Y');
		switch($timeperiod) {
			case 'This Week':
				$args['year'] = $year;
				$args['w'] = $week;
				$timeperiod='';
			break;	
			case 'This Month':
				$args['monthnum'] = $month;
				$args['year'] = $year;
				$timeperiod='';
			break;
			case 'This Year':
				$args['year'] = $year;
				$timeperiod='';
			break;
			case 'all':
				$timeperiod='';
			break;			
		}
		#WP AJAX calls by default include draft posts so we need to always exclude them
		$args['post_status'] = 'publish';
		#build the loop html and return to ajax call	
		$loop = it_loop($args, $format, $timeperiod);
		$loop_content = '';
		$loop_pages = 0;
		$loop_updatepagination = '';
		$buildquery = '';
		if(array_key_exists('content',$loop)) $loop_content = $loop['content'];
		if(array_key_exists('pages',$loop)) $loop_pages = $loop['pages'];
		if(array_key_exists('updatepagination',$loop)) $loop_updatepagination = $loop['updatepagination'];
		if(!empty($query)) $buildquery = http_build_query($query);
		#add in before and after content
		$loop_content = $content_before . $loop_content . $content_after;
		
		#generate the response
		$response = json_encode(array('content' => $loop_content, 'pagination' => it_pagination($loop_pages, $format, it_get_setting('page_range')), 'paginationmobile' => it_pagination($loop_pages, $format, it_get_setting('page_range_mobile')), 'pages' => $loop_pages, 'updatepagination' => $loop_updatepagination, 'utility' => $buildquery));
	 
		#response output
		header( "Content-Type: application/json" );
		echo $response;
		
		exit;	
	}
}
?>