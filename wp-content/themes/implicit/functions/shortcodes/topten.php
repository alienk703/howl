<?php
/**
 *
 */
class itTopten {	
	
	public static function topten( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Top Ten', IT_TEXTDOMAIN ),
				'value' => 'topten',
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
						'name' => __( 'Sub-Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays the time period selected by default.', IT_TEXTDOMAIN ),
						'id' => 'subtitle',
						'type' => 'text'
					),
					array(
						'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
						'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
						'id' => 'disabled_filters',
						'options' => array(
							'liked' => __('Most Likes',IT_TEXTDOMAIN),
							'viewed' => __('Most Views',IT_TEXTDOMAIN),
							'reviewed' => __('Best Reviewed',IT_TEXTDOMAIN),
							'rated' => __('Highest Rated',IT_TEXTDOMAIN),
							'commented' => __('Commented On',IT_TEXTDOMAIN)
						),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Time Period', IT_TEXTDOMAIN ),
						'desc' => __( 'Limit published date of posts to this time period.', IT_TEXTDOMAIN ),
						'id' => 'timeperiod',
						'target' => 'timeperiod',
						'nodisable' => true,
						'type' => 'select'
					),
					array(
						'name' => __( 'Targeted', IT_TEXTDOMAIN ),
						'id' => 'targeted',
						'options' => array( 'true' => __( 'Aware of currently displayed category section', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'title'					=> '',
			'icon'					=> '',			
			'included_categories'	=> '',
			'excluded_categories'	=> '',
			'included_tags'			=> '',
			'excluded_tags'			=> '',
			'targeted'				=> '',
			'subtitle'				=> '',
			'disabled_filters'		=> '',
			'timeperiod'			=> ''
		), $atts));	
		
		$out = '';
		
		$loop = 'top ten';
		$location = 'overlay';
		$numarticles = 10;
		$timeperiod_label = it_timeperiod_label($timeperiod);
		if(empty($timeperiod_label)) $timeperiod_label = __('This Month', IT_TEXTDOMAIN);
		$timeperiod_label = ( !empty( $subtitle ) ) ? $subtitle : $timeperiod_label;
		$title = ( !empty( $title ) ) ? $title : __('Top Ten', IT_TEXTDOMAIN);
		$title .= ' ' . $timeperiod_label;
		
		#see if this builder is targeted
		$category_id = $targeted ? it_page_in_category($post->ID) : false;
		$category_and = array();
		if(!empty($category_id)) $category_and[] = $category_id; #add current category if targeted
		if(!empty($included_categories)) $category_in = explode(',',$included_categories);
		
		#setup wp_query args
		$args = array('posts_per_page' => $numarticles, 'order' => 'DESC', 'ignore_sticky_posts' => true);
		
		#limits
		if(!empty($category_and) || !empty($category_in)) {	
			#build the tax query
			$tax_query = array('relation' => 'AND');		
			if(!empty($category_and)) $tax_query[] = array('taxonomy' => 'category', 'field' => 'id', 'terms' => $category_and);	
			if(!empty($category_in)) $tax_query[] = array('taxonomy' => 'category', 'field' => 'id', 'terms' => $category_in, 'operator' => 'IN');
			$args['tax_query'] = $tax_query;	
		}
		if(!empty($included_tags)) $args['tag__in'] = explode(',',$included_tags);
		#excludes
		if(!empty($excluded_categories)) $args['category__not_in'] = explode(',',$excluded_categories);
		if(!empty($excluded_tags)) $args['tag__not_in'] = explode(',',$excluded_tags);
		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'nonajax' => true, 'numarticles' => $numarticles, 'size' => 'scroller-wide');
		
		#get array of disabled filters
		$disabled_filters = !empty($disabled_filters) ? explode(',',$disabled_filters) : array();
		$disabled_filters[] = 'recent';
		$disabled_filters[] = 'awarded';
		$disabled_filters[] = 'title';
		
		#setup sortbar args
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'cols' => '', 'disabled_filters' => $disabled_filters, 'numarticles' => $numarticles, 'disable_filters' => false, 'disable_title' => $title_disable, 'thumbnail' => true, 'rating' => false, 'icon' => true, 'award' => false, 'badge' => false, 'excerpt' => false, 'authorship' => false, 'meta' => false, 'timeperiod' => $timeperiod, 'theme_icon' => $icon);
		
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
		#set encoded value before adding view-specific args
		$args_encoded = json_encode($args);
		
		#adjust args for default filter
		$setup_filters = it_setup_filters($disabled_filters, $args, $format);
		$default_metric = $setup_filters['default_metric'];
		$default_label = $setup_filters['default_label'];
		$args = $setup_filters['args'];
		$format = $setup_filters['format'];
		
		$loop = it_loop($args, $format, $timeperiod);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_topten', it_get_setting('ad_topten_before'), 'before-topten');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_topten', it_get_setting('ad_topten_after'), 'after-topten');
		$after = ob_get_contents();
		ob_end_clean();	
    
		$out .= $before;
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
        
        $out .= "<div class='scroller clearfix post-container top-ten' data-currentquery='" . $args_encoded . "'>";
            
            $out .= it_get_sortbar($sortbarargs);
            
            $out .= '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';
        
            $out .= '<div class="top-ten-content loop">';
            
                 $out .= $loop['content'];
            
            $out .= '</div>'; 
        
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
			'name' => __( 'Top Ten', IT_TEXTDOMAIN ),
			'value' => 'topten',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
