<?php 
if(!function_exists('it_loop')) {
	function it_loop($args, $format, $timeperiod = '') {
	
		if(!is_array($format)) $format = array();
		extract($format);
		if(empty($location)) $location = $loop; #a specified location overrides the loop parameter
		
		#don't care about pagename if we're displaying a post loop on a content page
		$args['pagename'] = '';
		
		#add a filter if this loop needs a time constraint (can't add to query args directly)
		global $timewhere;
		$timewhere = $timeperiod;
		if(!empty($timeperiod)) {		
			add_filter( 'posts_where', 'filter_where' );
		}	
		#query the posts
		$itposts = new WP_Query( $args );
		#remove the filter after we're done
		if(!empty($timeperiod)) {				
			remove_filter( 'posts_where', 'filter_where' );
		}
		
		#setup ads array
		$ads=array();
		$ad1=it_get_setting('loop_ad_1');
		$ad2=it_get_setting('loop_ad_2');
		$ad3=it_get_setting('loop_ad_3');
		$ad4=it_get_setting('loop_ad_4');
		$ad5=it_get_setting('loop_ad_5');
		$ad6=it_get_setting('loop_ad_6');
		$ad7=it_get_setting('loop_ad_7');
		$ad8=it_get_setting('loop_ad_8');
		$ad9=it_get_setting('loop_ad_9');
		$ad10=it_get_setting('loop_ad_10');
		if(!empty($ad1)) array_push($ads,$ad1);
		if(!empty($ad2)) array_push($ads,$ad2);
		if(!empty($ad3)) array_push($ads,$ad3);
		if(!empty($ad4)) array_push($ads,$ad4);
		if(!empty($ad5)) array_push($ads,$ad5);
		if(!empty($ad6)) array_push($ads,$ad6);
		if(!empty($ad7)) array_push($ads,$ad7);
		if(!empty($ad8)) array_push($ads,$ad8);
		if(!empty($ad9)) array_push($ads,$ad9);
		if(!empty($ad10)) array_push($ads,$ad10);
		if(it_get_setting('ad_shuffle')) shuffle($ads);
	
		#counters
		$i=0; #incremented after post display
		$p=0; #incremented before post display
		$a=0; #ad counter
		$r=0; #row counter
		$flag=false;
		$right=false;
		$out='';
		#sometimes the following variables are not passed
		$width = isset($width) ? $width : '';
		$height = isset($height) ? $height : '';
		$size = isset($size) ? $size : '';
		$nonajax = isset($nonajax) ? $nonajax : '';
		$disable_ads = isset($disable_ads) ? $disable_ads : false;
		
		$updatepagination=1;
		if(array_key_exists('posts_per_page',$args)) {
			$perpage = $args['posts_per_page'];
		} else {
			$perpage = 10;
		}
		$posts_shown = $itposts->found_posts;
		if($posts_shown > $perpage) $posts_shown = $perpage;
		$percol = ceil($posts_shown / 4); #articles per column for new articles panel
		$first = true;
		if ($itposts->have_posts()) : while ($itposts->have_posts()) : $itposts->the_post(); $p++;	
			
			#featured video
			$video = get_post_meta(get_the_ID(), "_featured_video", $single = true);
			
			#subtitle
			$subtitle = get_post_meta(get_the_ID(), "_subtitle", $single = true);
				
			#get just the primary category id
			$categoryargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => false, 'white' => true, 'single' => true, 'wrapper' => false, 'id' => true);	
			$category_id = it_get_primary_categories($categoryargs);
			
			#re-setup category args for actual display
			$categoryargs = array('postid' => get_the_ID(), 'label' => true, 'icon' => true, 'white' => false, 'single' => false, 'wrapper' => false, 'id' => false);
				
			$awardsargs = array('postid' => get_the_ID(), 'single' => true, 'badge' => false, 'white' => false, 'wrapper' => true);
			
			$editorargs = array('postid' => get_the_ID(), 'single' => false, 'meter' => false, 'label' => true);
			
			$userargs = array('postid' => get_the_ID(), 'single' => false, 'user_icon' => false, 'small' => '', 'label' => true);
			
			$likesargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'clickable' => false, 'showifempty' => false);
			
			$viewsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true);
			
			$commentsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'showifempty' => false, 'anchor_link' => false);
			
			$imageargs = array('postid' => get_the_ID(), 'size' => $size, 'width' => $width, 'height' => $height, 'wrapper' => false, 'itemprop' => false, 'link' => false, 'type' => 'normal', 'caption' => false);
			
			$videoargs = array('url' => $video, 'video_controls' => it_get_setting('loop_video_controls'), 'parse' => true, 'width' => $width, 'height' => $height, 'frame' => true, 'autoplay' => 0, 'type' => 'link');
					
			switch ($location) {
				case 'menu': #articles within the menu
				
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
				
					$labels = 'hide';
															
					$out .= '<div class="overlay-panel add-active clearfix category-' . $category_id . '">';
					
						$out .= '<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
					
						$out .= '<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						$out .= '<div class="overlay-layer"></div>';
						
						$out .= '<div class="overlay-info">';
														
							$out .= '<div class="article-title textfill">' . it_title(70) . '</div>';
							
						$out .= '</div>';
						
						$out .= '<div class="share-panel">';
						
							$out .= '<div class="share-button side add-active" data-postid="' . get_the_ID() . '" data-labels="' . $labels . '"><span class="theme-icon-plus"></span></div>';
						
							$out .= '<div class="share-content"></div>';
						
						$out .= '</div>';
						
						$out .= '<div class="overlay-more"><span class="theme-icon-right-thin"></span></div>';	
						
						$out .= '<div class="loading loading-small"><span class="theme-icon-spin2"></span></div>';					
						 
					$out .= '</div>';
				
				break;	
				
				case 'headliner': #HEADLINER
								
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
					
					#get title
					$title = '<div class="article-title"><div class="textfill">';
					$title .= '<span class="title-text">' . it_title(80) . '</span>';
					$title .= '</div></div>';
				
					$out.='<div class="headliner-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
						
					$out.='<a class="headliner-link" href="' . get_permalink() . '">&nbsp;</a>';
					
					$out.='<div class="headliner-layer"></div>';
					
					$out.='<div class="headliner-info clearfix">';
					
						$out.=$title;
						
					$out.='</div>';
				
				break;		
				case 'scroller': #HORIZONTAL SCROLLER				
					
					$size = 'grid';
					$len_title = 150;
					
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
					
					#loop specific arg adjustments
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = true;
					$categoryargs['single'] = true;	
					$categoryargs['label'] = false;
					
					$cats = it_get_primary_categories($categoryargs);
					
					#get title
					$title = '<div class="article-title"><div class="textfill">';
					$title .= '<span class="title-text">' . it_title($len_title) . '</span>';
					$title .= '</div></div>';
					
					#get review identifier
					$reviewlabel = it_has_rating(get_the_ID(),'user') || it_has_rating(get_the_ID(),'editor') ? '<div class="review-label">' . __('REVIEW',IT_TEXTDOMAIN) . '<span class="theme-icon-star"></span></div>' : '';
				
					#begin html output											
					$out.='<div class="overlay-panel add-active clearfix category-' . $category_id . ' ' . $size . '">';
					
						$out.='<div class="overlay-panel-inner">';
					
							$out.='<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
							
							$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
							
							$out.='<div class="overlay-layer"></div>';
							
							$out.='<div class="overlay-more"><span class="theme-icon-right-thin"></span></div>';
							
							$out.='<div class="overlay-hover">';
							
								if($rating) {
									
									$out.=it_show_editor_rating($editorargs);	
									
									$out.=it_show_user_rating($userargs);	
									
								}
							
							$out.='</div>';
							
							$out.='<div class="overlay-info">';
							
								$out .= $cats;
								
								$out .= $reviewlabel;
								
								$out .= $title;	
								
							$out.='</div>';		
							
						$out.='</div>';						
						 
					$out.='</div>';
				
				break;
				case 'trending builder': #TRENDING BUILDER PANEL	
				
					$size = 'scroller-wide';
					$len_title = 150;
					
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
										
					#get title
					$title = '<div class="article-title"><div class="textfill">';
					$title .= '<span class="title-text">' . it_title($len_title) . '</span>';
					$title .= '</div></div>';
					
					#get review identifier
					$reviewlabel = it_has_rating(get_the_ID(),'user') || it_has_rating(get_the_ID(),'editor') ? '<div class="review-label">' . __('REVIEW',IT_TEXTDOMAIN) . '<span class="theme-icon-star"></span></div>' : '';
				
					#begin html output											
					$out.='<div class="overlay-panel add-active clearfix category-' . $category_id . ' ' . $size . '">';
					
						$out.='<div class="overlay-panel-inner">';
					
							$out.='<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
							
							$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
							
							$out.='<div class="overlay-layer"></div>';
							
							$out.='<div class="overlay-more"><span class="theme-icon-right-thin"></span></div>';
							
							$out.='<div class="overlay-info">';
							
								$out.='<div class="trending-number">';
						
									if($metric=='liked') $out.=it_get_likes($likesargs);
										
									if($metric=='viewed') $out.=it_get_views($viewsargs);
									
									if($metric=='commented') $out.=it_get_comments($commentsargs);
								
								$out.='</div>';
								
								$out .= $reviewlabel;
								
								$out .= $title;	
								
							$out.='</div>';		
							
						$out.='</div>';						
						 
					$out.='</div>';
				
				break;
				case 'overlay': #overlay style panels
				
					$number = $i+1;	
										
					$len_title = 90;
					
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
										
					#get title
					$title = '<div class="article-title"><div class="textfill">';
					$title .= '<span class="title-text">' . it_title($len_title) . '</span>';
					$title .= '</div></div>';	
				
					#begin html output											
					$out.='<div class="overlay-panel add-active clearfix category-' . $category_id . ' ' . $size . '">';
					
						$out.='<div class="overlay-panel-inner">';
					
							$out.='<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
							
							$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
							
							$out.='<div class="overlay-layer"></div>';
							
							$out.='<div class="overlay-more"><span class="theme-icon-right-thin"></span></div>';
							
							$out.='<div class="overlay-info">';
							
								$out.='<div class="overlay-number">' . $number . '</div>';
								
								$out .= $title;	
								
							$out.='</div>';		
							
						$out.='</div>';						
						 
					$out.='</div>';
					
					if (($i+1) % 5 == 0) $out.='<br class="clearer hidden-xs" />';
					
					if (($i+1) % 2 == 0) $out.='<br class="clearer visible-xs" />';
				
				break;
				case 'grid': #GRID
					
					#setup variables	
					$start = empty($start) ? 1 : $start;
					$showwide = empty($increment) ? false : true;
					$layout = empty($layout) ? '' : $layout;
					$len_title = 150;		
					$width = 400;
					$height = 288;
					$size = 'grid';
					$csscol = ' third';
					$cssshare = ' share-grid';
					$columns = 3;
					$labels = 'hide';
					$hide_clearer = false;	
					$cats = '';									
					#see if this is a wide post
					$wide = false;
					$first = ($start - 1) * $columns;
					$increment = empty($increment) ? 0 : $increment;
					$between = ($increment - 1) * $columns;
					$counter = $p;
					$categoryargs['label'] = false;
					#first wide post
					if(!$flag && $counter == $first + 1) {
						$flag = true;
						$wide = true;
					}
					#subsequent wide posts
					if($flag && $counter == $between + 1) {
						$wide = true;						
					}
					#disregard increment settings for widgets
					if($layout=='widget_a') {
						$wide = false;
						$csscol = ' single-column';
						$columns = 1;
						$size = 'grid';
						$width = 400;
						$height = 288;
						$hide_clearer = true;	
					} elseif($layout=='directory-loop') {
						$wide = false;	
					}
					if($wide && $showwide) {
						$width = 1200;
						$height = 334;
						$size = 'grid-wide';
						$csscol = ' wide';	
						$cssshare = ' share-blog';
						$categoryargs['label'] = true;
						$p = 0;	
					}					
					
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
					$csscolor = empty($featured_image[0]) ? ' solid' : '';			
										
					#loop specific arg adjustments
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = true;
					$categoryargs['single'] = true;						
					$videoargs['width'] = $width;
					$videoargs['height'] = $height;
					
					if(!it_get_setting('loop_category_disable')) $cats = it_get_primary_categories($categoryargs);					
					$csscat = !empty($cats) ? '' : ' no-margin';
					
					#get title
					$title = '<h2 class="article-title"><div class="textfill">';
					$title .= '<span class="title-text">' . it_title($len_title) . '</span>';
					$title .= '</div></h2>';
					
					#get review identifier
					$reviewlabel = it_has_rating(get_the_ID(),'user') || it_has_rating(get_the_ID(),'editor') ? '<div class="review-label">' . __('REVIEW',IT_TEXTDOMAIN) . '<span class="theme-icon-star"></span></div>' : '';
					
					$video_disable = false;
					if(empty($video) || !it_get_setting('loop_video')) $video_disable = true;
					$cssvideo = $video_disable ? '' : ' video';
					
					#new row
					$newrow = $p % $columns == 0 || $wide && $showwide ? true : false;
					
					#begin html output											
					$out.='<div class="overlay-panel add-active clearfix category-' . $category_id . $csscol . $cssvideo . $csscolor . ' ' . $size . '">';
					
						$out.='<div class="overlay-panel-inner">';
						
							$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
						
							$out.='<div class="overlay-image-wrapper">';
					
								$out.='<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
								
								$out.='<div class="overlay-layer"></div>';
								
								$out.='<div class="overlay-more">' . __('READ MORE', IT_TEXTDOMAIN) . '<span class="theme-icon-right-thin"></span></div>';
								
								$out.='<div class="overlay-hover">';
								
									if($rating) {
										
										$out.=it_show_editor_rating($editorargs);	
										
										$out.=it_show_user_rating($userargs);	
										
									}
								
								$out.='</div>';
								
								$out .= $cats;
							
							$out.='</div>';
							
							$out.='<div class="overlay-info-wrapper">';
							
								$out.='<div class="overlay-info">';
									
									$out .= $title;
									
									$out .= $reviewlabel;
									
								$out.='</div>';	
								
							$out.='</div>';	
							
							$out.='<div class="share-panel">';
							
								$out.='<div class="share-content clearfix"></div>';
							
							$out.='</div>';
							
							$out.='<div class="loading loading-small"><span class="theme-icon-spin2"></span></div>';
							
							$out.='<div class="share-button' . $cssshare . ' add-active" data-postid="' . get_the_ID() . '" data-labels="' . $labels . '"><span class="theme-icon-plus"></span></div>';
							
							if(!$video_disable) {	
									
								$out.='<a class="styled overlay-play info colorbox-iframe" title="' . __('Video',IT_TEXTDOMAIN) . '" href="' . it_video($videoargs) . '" data-type="video">';
								
									$out.='<span class="theme-icon-play"></span>';
									
								$out.='</a>';
															
							}
							
						$out.='</div>';						
						 
					$out.='</div>';
					
					if($newrow && !$hide_clearer) $out.='<br class="clearer" />';
					
					#show ads in the loop					
					if(!$disable_ads) {	
						if($newrow) {
							$r++;									
							$the_ad = it_get_ad($ads, $r, $a, $nonajax);
							$a = $the_ad['adcount']; #get updated ad count	
							$out .= $the_ad['ad'];							
						}
					}	
				
				break;
				case 'blog': #BLOG
				
					$r++;
				
					#setup variables		
					$len_excerpt = it_get_setting('loop_excerpt_length');									
					$len_excerpt = empty($len_excerpt) ? 1500 : $len_excerpt;
					$len_title = 300;						
					$csspost = is_sticky() ? ' sticky-post' : '';	
					$right = !$right;
					$width = 1200;
					$height = 334;
					$size = 'grid-wide';	
					$columns = 1;
					$labels = 'hide';
					$cats = '';
					
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
					$csscolor = empty($featured_image[0]) ? ' solid' : '';			
						
					#show ads in the loop
					if(!$disable_ads) {			
						$the_ad = it_get_ad($ads, $r, $a, $nonajax);
						$a = $the_ad['adcount']; #get updated ad count	
					}
					
					#loop specific arg adjustments
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = true;
					$categoryargs['single'] = true;					
					$likesargs['clickable'] = true;
					$videoargs['width'] = $width;
					$videoargs['height'] = $height;
					
					if(!it_get_setting('loop_category_disable')) $cats = it_get_primary_categories($categoryargs);					
					$csscat = !empty($cats) ? '' : ' no-margin';
					
					#get title
					$title = '<h2 class="article-title"><div class="textfill">';
					if(is_sticky()) $title .= '<span class="theme-icon-pin"></span>';
					$title .= '<span class="title-text">' . it_title($len_title) . '</span>';
					$title .= '</div></h2>';
					
					#get review identifier
					$reviewlabel = it_has_rating(get_the_ID(),'user') || it_has_rating(get_the_ID(),'editor') ? '<div class="review-label">' . __('REVIEW',IT_TEXTDOMAIN) . '<span class="theme-icon-star"></span></div>' : '';
					
					$video_disable = false;
					if(empty($video) || !it_get_setting('loop_video')) $video_disable = true;
					$cssvideo = $video_disable ? '' : ' video';
					
					#begin html output
					$out .= $the_ad['ad'];
					
					$out.='<div class="longform-wrapper add-active category-' . $category_id . '">';
					
						$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
											
						$out.='<div class="overlay-panel clearfix wide category-' . $category_id . $csspost . $cssvideo . $csscolor . ' ' . $size . '">';
						
							$out.='<div class="overlay-panel-inner">';
							
								$out.='<div class="overlay-image-wrapper">';
						
									$out.='<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
									
									$out.='<div class="overlay-layer"></div>';
									
									$out.='<div class="overlay-more">' . __('READ MORE', IT_TEXTDOMAIN) . '<span class="theme-icon-right-thin"></span></div>';
									
									$out.='<div class="overlay-hover">';
									
										if($rating) {
											
											$out.=it_show_editor_rating($editorargs);	
											
											$out.=it_show_user_rating($userargs);	
											
										}
									
									$out.='</div>';
									
									$out .= $cats;
									
								$out.='</div>';							
							
								$out.='<div class="overlay-info-wrapper">';
									
									$out.='<div class="overlay-info">';
									
										$out .= $title;
										
										$out .= $reviewlabel;
										
									$out.='</div>';									
									
								$out.='</div>';
								
								$out.='<div class="share-panel">';
								
										$out.='<div class="share-content clearfix"></div>';
								
								$out.='</div>';
								
								$out.='<div class="loading loading-small"><span class="theme-icon-spin2"></span></div>';
								
								$out.='<div class="share-button share-blog add-active" data-postid="' . get_the_ID() . '" data-labels="' . $labels . '"><span class="theme-icon-plus"></span></div>';			
							 
							$out.='</div>';
							
						$out.='</div>';
						
						$out.='<div class="longform clearfix">';
						
							if($authorship) $out.=it_get_authorship('both', true, false);
							
							if($excerpt) $out.='<div class="longform-excerpt">' . it_excerpt($len_excerpt) . '</div>';
						
							if(!it_get_setting('list_more_disable')) $out.='<a href="' . get_permalink() . '" class="longform-more styled">' . __('CONTINUE READING', IT_TEXTDOMAIN) . '<span class="theme-icon-right-thin"></span></a>';
						
						$out.='</div>';	
					
					$out.='</div>';
				
				break;				
				case 'widget_b': #WIDGET B				
					
					$imageargs['size'] = 'micro';
					$imageargs['width'] = 30;
					$imageargs['height'] = 30;	
					
					$len_title = 200;
					
					$cssimage = has_post_thumbnail(get_the_ID()) && $thumbnail ? '' : ' no-image';	
											
					$out.='<div class="compact-panel add-active active-image clearfix category-' . $category_id . $cssimage . '">';
					
						$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						if(has_post_thumbnail(get_the_ID()) && $thumbnail) {
					
							$out.='<div class="article-image-wrapper">';   												
									                    
								$out.=it_featured_image($imageargs);
						
							$out.='</div>';  
							
						}
						
						$out .= '<div class="article-info">';
								
							$out .= '<div class="article-title">' . it_title($len_title) . '</div>';
							
						$out.='</div>';						
						 
					$out.='</div>';
				
				break;
				case 'widget_c': #WIDGET C
				
					$len_title = 200;
											
					$out.='<div class="border-panel add-active clearfix category-' . $category_id . '">';
					
						$out.='<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						$out .= '<div class="article-info">';
						
							$out .= it_get_authorship('date', false, false);
								
							$out .= '<div class="article-title">' . it_title($len_title) . '</div>';
							
							$out .= it_get_authorship('author');
							
						$out.='</div>';	
					
					$out.='</div>';
				
				break;
								
				case 'trending': #TRENDING WIDGET
				
					$viewsargs['icon'] = false;
					$likesargs['icon'] = false;
					$commentsargs['icon'] = false;
					
					$size = 'large';
					if($i>0) $size = 'medium';
					if($i>3) $size = 'small';
					if($i>5) $size = 'tiny';
				
					$out.='<div class="trending-bar add-active bar-' . $i . ' ' . $size . '">';
					
						$out.='<a class="trending-link" href="'.get_permalink().'">&nbsp;</a>';	
						
						$out.='<div class="title">'.it_title('200').'</div>';
						
						$out.='<div class="trending-meta">';
							
							if($metric=='liked') $out.=it_get_likes($likesargs);
							
							if($metric=='viewed') $out.=it_get_views($viewsargs);
							
							if($metric=='commented') $out.=it_get_comments($commentsargs);
						
						$out.='</div>';	
						
						$out.='<div class="trending-color"></div>';
						
					$out.='</div>';				
				
				break;					
			} 
			
			$i++; endwhile; 
			else:
				
				$out.='<div class="filter-error">'.__('Try a different filter', IT_TEXTDOMAIN).'</div>';
				$updatepagination=0;
			
			endif;
		
		$pages = $itposts->max_num_pages;
		$posts = $posts_shown;
		wp_reset_postdata();
		
		return array('content' => $out, 'pages' => $pages, 'updatepagination' => $updatepagination, 'posts' => $posts);
	} 
}
?>