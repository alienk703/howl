<?php
/**
 *
 */
class itLoops {	
	
	public static function grid( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Grid', IT_TEXTDOMAIN ),
				'value' => 'grid',
				'options' => array(					
					array(
						'name' => __( 'Included Categories', IT_TEXTDOMAIN ),
						'id' => 'included_categories',
						'target' => 'cat',
						'type' => 'multidropdown'
					),	
					array(
						'name' => __( 'Included Tags', IT_TEXTDOMAIN ),
						'id' => 'included_tags',
						'target' => 'tag',
						'type' => 'multidropdown'
					),
					array(
						'name' => __( 'Excluded Categories', IT_TEXTDOMAIN ),
						'id' => 'excluded_categories',
						'target' => 'cat',
						'type' => 'multidropdown'
					),	
					array(
						'name' => __( 'Excluded Tags', IT_TEXTDOMAIN ),
						'id' => 'excluded_tags',
						'target' => 'tag',
						'type' => 'multidropdown'
					),		
					array(
						'name' => __( 'Post Loading', IT_TEXTDOMAIN ),
						'desc' => __( 'How should subsequent pages of posts load', IT_TEXTDOMAIN ),
						'id' => 'loading',
						'default' => 'paged',
						'options' => array(
							'paged' => __('Paged', IT_TEXTDOMAIN ),
							'infinite' => __('Infinite', IT_TEXTDOMAIN ),
							'' => __('None', IT_TEXTDOMAIN ),
						),
						'type' => 'radio'
					),
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the sort controls.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'type' => 'text'
					),
					array(
						'name' => __( 'Icon', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the title', IT_TEXTDOMAIN ),
						'id' => 'icon',
						'target' => 'icons',
						'type' => 'select'
					),	
					array(
						'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
						'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
						'id' => 'disabled_filters',
						'options' => array(
							'liked' => __('Liked',IT_TEXTDOMAIN),
							'viewed' => __('Viewed',IT_TEXTDOMAIN),
							'reviewed' => __('Reviewed',IT_TEXTDOMAIN),
							'rated' => __('Rated',IT_TEXTDOMAIN),
							'commented' => __('Commented',IT_TEXTDOMAIN),
							'awarded' => __('Awarded',IT_TEXTDOMAIN),
							'title' => __('Alphabetical',IT_TEXTDOMAIN)
						),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Number of Rows', IT_TEXTDOMAIN ),
						'desc' => __( 'The number of total rows of posts to display before pagination or the load more button is displayed. This is also the number of rows that will load when the load more button is clicked. Note about mobile responsive layout: since posts do not float in columns the number of rows displayed for mobile view will always be larger than the number of rows selected here.', IT_TEXTDOMAIN ),
						'id' => 'rows',
						'target' => 'recommended_filters_number',
						'type' => 'select'
					),
					array(
						'name' => __( 'Wide Post Frequency', IT_TEXTDOMAIN ),
						'desc' => __( 'How often there should be a wide post after the first occurrance. Leave unselected to disable wide post formats.', IT_TEXTDOMAIN ),
						'id' => 'increment',
						'target' => 'grid_increment',
						'type' => 'select'
					),
					array(
						'name' => __( 'Wide Post Start Position', IT_TEXTDOMAIN ),
						'desc' => __( 'At what row should wide posts start occurring. Only used if Wide Post Frequency is set.', IT_TEXTDOMAIN ),
						'id' => 'start',
						'target' => 'ad_number',
						'type' => 'select',
						'nodisable' => true,
					),
					array(
						'name' => __( 'Disable Ads', IT_TEXTDOMAIN ),
						'id' => 'disable_ads',
						'options' => array( 'true' => __( 'Do not display ads within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'loading' 				=> 'paged',
			'title'					=> '',
			'icon'					=> '',
			'rows'					=> 4,
			'increment' 			=> '',
			'start'					=> '',
			'disable_ads'			=> '',
			'disabled_filters'		=> '',
			'included_categories'	=> '',
			'excluded_categories'	=> '',
			'included_tags'			=> '',
			'excluded_tags'			=> '',
		), $atts));	
		
		$out = '';
		
		global $wp, $wp_query;
		#get the current query to pass it to the ajax functions through the html data tag
		if(!is_single() && !is_page()) $current_query = $wp->query_vars;
		
		#default settings
		$args = array();
		$rating = it_get_setting('loop_rating_disable');
		$disabled_filters = !empty($disabled_filters) ? explode(',',$disabled_filters) : array();
		$disabled_count = !empty($disabled_filters) ? count($disabled_filters) : 0;
		$disable_filters = $disabled_count > 6 ? true : false;
		
		#determine posts per page
		$start = empty($start) ? 1 : $start;
		$showwide = empty($increment) ? false : true;
		if(empty($rows)) $rows = 1;
		$cols = 3;
		$subtract = 0;
		$next = 0;
		$subtract_per_row = $cols - 1;
		$rows_to_subtract = 0;
		#find out how many wide rows are showing 
		if($start <= $rows && $showwide) {
			$next = $start;
			while($next <= $rows) {
				$rows_to_subtract++;
				$next += $increment;				
			}
		}
		$subtract = $rows_to_subtract * $subtract_per_row;
		$postsperpage = ($rows * $cols) - $subtract;
		$loop = 'main';
		$location = 'grid';
		$disable_title = empty($title) ? true : false;
		$cssload = ' load-sort';
		
		#query args
		$args = array('posts_per_page' => $postsperpage, 'ignore_sticky_posts' => true);
		
		#check and see if we care about excludes and limits
		if(!(is_archive() || is_search())) $ignore_excludes = false;
		if(!$ignore_excludes) {
			#limits
			if(!empty($included_categories)) $current_query['category__in'] = explode(',',$included_categories);
			if(!empty($included_categories)) $args['category__in'] = explode(',',$included_categories);	
			if(!empty($included_tags)) $current_query['tag__in'] = explode(',',$included_tags);	
			if(!empty($included_tags)) $args['tag__in'] = explode(',',$included_tags);
			#excludes
			if(!empty($excluded_categories)) $current_query['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_categories)) $args['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_tags)) $current_query['tag__not_in'] = explode(',',$excluded_tags);
			if(!empty($excluded_tags)) $args['tag__not_in'] = explode(',',$excluded_tags);
		}
		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'sort' => 'recent', 'paged' => 1, 'thumbnail' => true, 'rating' => !$rating, 'icon' => true, 'nonajax' => true, 'meta' => true, 'award' => false, 'badge' => false, 'excerpt' => false, 'authorship' => false, 'numarticles' => $postsperpage, 'disable_ads' => $disable_ads, 'increment' => $increment, 'start' => $start);
		
		if(!is_single() && !is_page()) $args = array_merge($args, $current_query);
		
		#setup sortbar
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'numarticles' => $postsperpage, 'disabled_filters' => $disabled_filters, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => !$rating, 'meta' => true, 'icon' => true, 'award' => false, 'badge' => false, 'excerpt' => false, 'authorship' => false, 'theme_icon' => $icon, 'increment' => $increment, 'start' => $start);
		
		#get correct page number count
		$itposts = new WP_Query($args);
		$numpages = $itposts->max_num_pages;
		wp_reset_postdata();
		
		#setup load more button
		if($loading=='infinite') {
			$loadmoreargs = $format;
			$loadmoreargs['numpages'] = $numpages;
			$cssload = ' load-infinite';
		}
		
		$current_query_encoded = json_encode($current_query);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_grid', it_get_setting('ad_grid_before'), 'before-grid');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_grid', it_get_setting('ad_grid_after'), 'after-grid');
		$after = ob_get_contents();
		ob_end_clean();	
    
		$out .= $before;
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
            
        $out .= "<div class='articles post-container post-grid' data-currentquery='" . $current_query_encoded . "'>";
            
            $out .= it_archive_title();
        
            $out .= it_get_sortbar($sortbarargs);
            
            $out .= '<div class="content-inner clearfix">';
            
                $out .= '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';
            
                $out .= '<div class="loop">';
                
                    $loop = it_loop($args, $format); 
					$out .= $loop['content'];
                    
                $out .= '</div>';
                
                $out .= '<div class="loading' . $cssload . '"><span class="theme-icon-spin2"></span></div>';
                
            $out .= '</div>';
            
            if($loading=='infinite') {
			
				$out .= it_get_loadmore($loadmoreargs);
				
				$out .= '<div class="last-page">' . __('End of the line!',IT_TEXTDOMAIN) . '</div>';
				
			} elseif($loading=='paged') {
				
				$out .= '<div class="pagination-wrapper">';
        
					$out .= it_pagination($numpages, $format, it_get_setting('page_range'));
					
				$out .= '</div>';
				
			}
                
        $out .= '</div>';
        
        $out .= $after;
        
        wp_reset_query();
				
		return $out;
		
	}
	
	public static function blog( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Blog', IT_TEXTDOMAIN ),
				'value' => 'blog',
				'options' => array(					
					array(
						'name' => __( 'Included Categories', IT_TEXTDOMAIN ),
						'id' => 'included_categories',
						'target' => 'cat',
						'type' => 'multidropdown'
					),	
					array(
						'name' => __( 'Included Tags', IT_TEXTDOMAIN ),
						'id' => 'included_tags',
						'target' => 'tag',
						'type' => 'multidropdown'
					),
					array(
						'name' => __( 'Excluded Categories', IT_TEXTDOMAIN ),
						'id' => 'excluded_categories',
						'target' => 'cat',
						'type' => 'multidropdown'
					),	
					array(
						'name' => __( 'Excluded Tags', IT_TEXTDOMAIN ),
						'id' => 'excluded_tags',
						'target' => 'tag',
						'type' => 'multidropdown'
					),		
					array(
						'name' => __( 'Post Loading', IT_TEXTDOMAIN ),
						'desc' => __( 'How should subsequent pages of posts load', IT_TEXTDOMAIN ),
						'id' => 'loading',
						'default' => 'paged',
						'options' => array(
							'paged' => __('Paged', IT_TEXTDOMAIN ),
							'infinite' => __('Infinite', IT_TEXTDOMAIN ),
							'' => __('None', IT_TEXTDOMAIN ),
						),
						'type' => 'radio'
					),
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the sort controls.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'type' => 'text'
					),
					array(
						'name' => __( 'Icon', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the title', IT_TEXTDOMAIN ),
						'id' => 'icon',
						'target' => 'icons',
						'type' => 'select'
					),	
					array(
						'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
						'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
						'id' => 'disabled_filters',
						'options' => array(
							'liked' => __('Liked',IT_TEXTDOMAIN),
							'viewed' => __('Viewed',IT_TEXTDOMAIN),
							'reviewed' => __('Reviewed',IT_TEXTDOMAIN),
							'rated' => __('Rated',IT_TEXTDOMAIN),
							'commented' => __('Commented',IT_TEXTDOMAIN),
							'awarded' => __('Awarded',IT_TEXTDOMAIN),
							'title' => __('Alphabetical',IT_TEXTDOMAIN)
						),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Posts Per Page', IT_TEXTDOMAIN ),
						'desc' => __( 'The number of total posts to display before pagination or the load more button is displayed. This is also the number of rows that will load when the load more button is clicked.', IT_TEXTDOMAIN ),
						'id' => 'postsperpage',
						'target' => 'range_number',
						'type' => 'select'
					),
					array(
						'name' => __( 'Disable Ads', IT_TEXTDOMAIN ),
						'id' => 'disable_ads',
						'options' => array( 'true' => __( 'Do not display ads within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Disable Excerpt', IT_TEXTDOMAIN ),
						'id' => 'disable_excerpt',
						'options' => array( 'true' => __( 'Do not display post excerpts within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Disable Authorship', IT_TEXTDOMAIN ),
						'id' => 'disable_authorship',
						'options' => array( 'true' => __( 'Do not display authorship within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'loading' 				=> 'paged',
			'title'					=> '',
			'icon'					=> '',
			'postsperpage'			=> 5,
			'disable_ads'			=> '',
			'disabled_filters'		=> '',
			'disable_excerpt'		=> '',
			'disable_authorship'	=> '',
			'included_categories'	=> '',
			'excluded_categories'	=> '',
			'included_tags'			=> '',
			'excluded_tags'			=> '',
		), $atts));	
		
		$out = '';
		
		global $wp, $wp_query;
		#get the current query to pass it to the ajax functions through the html data tag
		if(!is_single() && !is_page()) $current_query = $wp->query_vars;
		
		#default settings
		$args = array();
		$rating = it_get_setting('loop_rating_disable');
		$disabled_filters = !empty($disabled_filters) ? explode(',',$disabled_filters) : array();	
		$disabled_count = !empty($disabled_filters) ? count($disabled_filters) : 0;
		$disable_filters = $disabled_count > 6 ? true : false;
		
		$cols = 1;
		$loop = 'main';
		$location = 'blog';
		$disable_title = empty($title) ? true : false;
		$cssload = ' load-sort';
		
		#query args
		$args = array('posts_per_page' => $postsperpage);
		
		#check and see if we care about excludes and limits
		if(!(is_archive() || is_search())) $ignore_excludes = false;
		if(!$ignore_excludes) {
			#limits
			if(!empty($included_categories)) $current_query['category__in'] = explode(',',$included_categories);
			if(!empty($included_categories)) $args['category__in'] = explode(',',$included_categories);	
			if(!empty($included_tags)) $current_query['tag__in'] = explode(',',$included_tags);	
			if(!empty($included_tags)) $args['tag__in'] = explode(',',$included_tags);
			#excludes
			if(!empty($excluded_categories)) $current_query['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_categories)) $args['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_tags)) $current_query['tag__not_in'] = explode(',',$excluded_tags);
			if(!empty($excluded_tags)) $args['tag__not_in'] = explode(',',$excluded_tags);
		}
		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'sort' => 'recent', 'paged' => 1, 'thumbnail' => true, 'rating' => !$rating, 'icon' => true, 'nonajax' => true, 'meta' => true, 'award' => false, 'badge' => false, 'excerpt' => !$disable_excerpt, 'authorship' => !$disable_authorship, 'numarticles' => $postsperpage, 'disable_ads' => $disable_ads);
		
		if(!is_single() && !is_page()) $args = array_merge($args, $current_query);
		
		#setup sortbar
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'numarticles' => $postsperpage, 'disabled_filters' => $disabled_filters, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => !$rating, 'meta' => true, 'icon' => true, 'award' => false, 'badge' => false, 'excerpt' => !$disable_excerpt, 'authorship' => !$disable_authorship, 'theme_icon' => $icon);
		
		#get correct page number count
		$itposts = new WP_Query($args);
		$numpages = $itposts->max_num_pages;
		wp_reset_postdata();
		
		#setup load more button
		if($loading=='infinite') {
			$loadmoreargs = $format;
			$loadmoreargs['numpages'] = $numpages;
			$cssload = ' load-infinite';
		}
		
		$current_query_encoded = json_encode($current_query);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_list', it_get_setting('ad_list_before'), 'before-list');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_list', it_get_setting('ad_list_after'), 'after-list');
		$after = ob_get_contents();
		ob_end_clean();	
    
		$out .= $before;
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
            
        $out .= "<div class='articles post-container post-blog' data-currentquery='" . $current_query_encoded . "'>";
            
            $out .= it_archive_title();
        
            $out .= it_get_sortbar($sortbarargs);
            
            $out .= '<div class="content-inner clearfix">';
            
                $out .= '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';
            
                $out .= '<div class="loop">';
                
                    $loop = it_loop($args, $format); 
					$out .= $loop['content'];
                    
                $out .= '</div>';
                
                $out .= '<div class="loading' . $cssload . '"><span class="theme-icon-spin2"></span></div>';
                
            $out .= '</div>';
            
            if($loading=='infinite') {
			
				$out .= it_get_loadmore($loadmoreargs);
				
				$out .= '<div class="last-page">' . __('End of the line!',IT_TEXTDOMAIN) . '</div>';
				
			} elseif($loading=='paged') {
				
				$out .= '<div class="pagination-wrapper">';
        
					$out .= it_pagination($numpages, $format, it_get_setting('page_range'));
					
				$out .= '</div>';
				
			}
                
        $out .= '</div>';
        
        $out .= $after;
        
        wp_reset_query();
				
		return $out;
		
	}
		
	/**
	 *
	 */
	public static function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods($class);

		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}

		$options = array(
			'name' => __( 'Loops', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose which type of post loop you wish to use.', IT_TEXTDOMAIN ),
			'value' => 'loops',
			'options' => $shortcode,
			'shortcode_has_types' => true
		);

		return $options;
	}

}

?>
