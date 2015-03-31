<?php
class it_top_ten extends WP_Widget {
	function it_top_ten() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Top 10', 'description' => __( 'Widget version of the Top 10 builder panel.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_top_ten' );
		/* Create the widget. */
		$this->WP_Widget( 'it_top_ten', 'Top 10', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
	
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$selected_category = $instance['category'];
		$selected_tag = $instance['tag'];
		$disable_liked = $instance['disable_liked'];
		$disable_viewed = $instance['disable_viewed'];
		$disable_reviewed = $instance['disable_reviewed'];
		$disable_rated = $instance['disable_rated'];
		$disable_commented = $instance['disable_commented'];
		$timeperiod = $instance['timeperiod'];
		$timeperiod_label = it_timeperiod_label($timeperiod);
		if(empty($timeperiod_label)) $timeperiod_label = 'This Month';
		$topten_label = it_get_setting("topten_label");
		$topten_label = ( !empty( $topten_label ) ) ? $topten_label : __('Top 10', IT_TEXTDOMAIN);
		$topten_label .= ' ' . $timeperiod_label;
		if(empty($title)) $title = $topten_label;
		$numarticles = 10;
		
		#clear out unselected values
		if($selected_category=='All Categories') $selected_category = '';		
		if($selected_tag=='All Tags') $selected_tag = '';	
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'orderby' => 'meta_value_num', 'ignore_sticky_posts' => true, 'cat' => $selected_category, 'tag_id' => $selected_tag);
		
		#setup loop format
		$format = array('loop' => 'top ten', 'location' => 'overlay', 'nonajax' => true, 'numarticles' => $numarticles, 'size' => 'grid');	
		
		#determine default options
		$default_metric = 'viewed';
		$args['meta_key'] = IT_META_TOTAL_VIEWS;
		$default_label = __('Most Views', IT_TEXTDOMAIN);
		$default_icon = '';
		#loop through each metric and set to default until one is found
		if(!$disable_viewed) {
			$default_metric = 'viewed';
			$args['meta_key'] = IT_META_TOTAL_VIEWS;
			$default_label = __('Most Views', IT_TEXTDOMAIN);
		} elseif (!$disable_liked) {
			$default_metric = 'liked';
			$args['meta_key'] = IT_META_TOTAL_LIKES;
			$default_label = __('Most Likes', IT_TEXTDOMAIN);
		} elseif (!$disable_reviewed) {
			$default_metric = 'reviewed';
			$format['rating'] = true;
			$args['meta_key'] = IT_META_TOTAL_SCORE_NORMALIZED;
			$args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ));
			$default_label = __('Best Reviewed', IT_TEXTDOMAIN);
		} elseif (!$disable_rated) {
			$default_metric = 'users';
			$format['rating'] = true;
			$default_icon = 'rated';
			$args['meta_key'] = IT_META_TOTAL_USER_SCORE_NORMALIZED;
			$args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ));
			$default_label = __('Highest Rated', IT_TEXTDOMAIN);
		} elseif (!$disable_commented) {
			$default_metric = 'commented';
			$args['orderby'] = 'comment_count';
			$default_label = __('Most Comments', IT_TEXTDOMAIN);
		}
		$format['metric'] = $default_metric;
		if(empty($default_icon)) $default_icon = $default_metric;	
		
		$disabled_filters = array('recent', 'awarded', 'title');
		if($disable_liked) $disabled_filters[] = 'liked';
		if($disable_viewed) $disabled_filters[] = 'viewed';
		if($disable_reviewed) $disabled_filters[] = 'reviewed';
		if($disable_rated) $disabled_filters[] = 'rated';
		if($disable_commented) $disabled_filters[] = 'commented';
		
		$sortbarargs = array('title' => $title, 'loop' => 'top ten', 'location' => 'overlay', 'icon' => $default_metric, 'cols' => '', 'disabled_filters' => $disabled_filters, 'numarticles' => $numarticles, 'prefix' => false, 'disable_title' => false, 'disable_filters' => false, 'thumbnail' => true, 'rating' => false, 'meta' => false, 'award' => false, 'badge' => false, 'excerpt' => false, 'authorship' => false, 'timeperiod' => $timeperiod, 'size' => 'grid');
		
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
		
		#encode current query for ajax purposes
		$current_query = array();
		if(!empty($selected_category)) $current_query['category__in'] = array($selected_category);
		if(!empty($selected_tag)) $current_query['tag__in'] = array($selected_tag);
		$current_query_encoded = json_encode($current_query);
		
		#fetch the loop
		$loop = it_loop($args, $format, $timeperiod); 
		    
        #Before widget (defined by themes)
        echo $before_widget;

        #HTML output
		echo "<div class='topten-widget scroller clearfix post-container' data-currentquery='" . $current_query_encoded . "'>";
		
			echo it_get_sortbar($sortbarargs);
			
			echo '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';	
			
			echo '<div class="loop">';
			       
				echo $loop['content'];
			
			echo '</div>'; #end post-list div 	
				
		echo '</div>'; #end trending-latest div	
		
		wp_reset_query();			
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['tag'] = strip_tags( $new_instance['tag'] );	
		$instance['disable_liked'] = isset( $new_instance['disable_liked'] );
		$instance['disable_viewed'] = isset( $new_instance['disable_viewed'] );
		$instance['disable_reviewed'] = isset( $new_instance['disable_reviewed'] );
		$instance['disable_rated'] = isset( $new_instance['disable_rated'] );
		$instance['disable_commented'] = isset( $new_instance['disable_commented'] );
		$instance['timeperiod'] = strip_tags( $new_instance['timeperiod'] );	
		
		return $instance;
		
	}
	function form( $instance ) {	

		#set up some default widget settings.
		$defaults = array( 'category' => 'All Categories', 'tag' => 'All Tags', 'disable_liked' => false, 'disable_viewed' => false, 'disable_reviewed' => false, 'disable_rated' => false, 'disable_commented' => false, 'timeperiod' => 'This Year' );		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>	
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
            <span style="font-style:italic;font-size:11px;color:#888;"><?php _e( 'Automatically generated if left blank',IT_TEXTDOMAIN); ?></span>
		</p>
        
        <p>
			<?php _e( 'Category:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'category' ); ?>">
				<option<?php if($instance['category']=='All Categories') { ?> selected<?php } ?> value="All Categories"><?php _e( 'All Categories', IT_TEXTDOMAIN ); ?></option>
				<?php 
				$catargs = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0);
				$categories = get_categories($catargs);
				foreach($categories as $category){ ?>
                	<option<?php if($instance['category']==$category->term_id) { ?> selected<?php } ?> value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
				<?php } ?>
			</select>
		</p>
        
         <p>
			<?php _e( 'Tag:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'tag' ); ?>">
				<option<?php if($instance['tag']=='All Tags') { ?> selected<?php } ?> value="All Tags"><?php _e( 'All Tags', IT_TEXTDOMAIN ); ?></option>
				<?php 
				$tagargs = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0);
				$tags = get_tags($tagargs);
				foreach($tags as $tag){ ?>
                	<option<?php if($instance['tag']==$tag->term_id) { ?> selected<?php } ?> value="<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p><?php _e( 'Disable Filters:',IT_TEXTDOMAIN); ?></p>	        
                          
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_liked']) ? $instance['disable_liked'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_liked'); ?>" id="<?php echo $this->get_field_id('disable_liked'); ?>" />
        <label for="<?php echo $this->get_field_id('disable_liked'); ?>"><?php _e('Liked',IT_TEXTDOMAIN); ?></label><br />
                      
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_viewed']) ? $instance['disable_viewed'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_viewed'); ?>" id="<?php echo $this->get_field_id('disable_viewed'); ?>" />
        <label for="<?php echo $this->get_field_id('disable_viewed'); ?>"><?php _e('Viewed',IT_TEXTDOMAIN); ?></label><br />
                     
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_reviewed']) ? $instance['disable_reviewed'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_reviewed'); ?>" id="<?php echo $this->get_field_id('disable_reviewed'); ?>" />
        <label for="<?php echo $this->get_field_id('disable_reviewed'); ?>"><?php _e('Reviewed',IT_TEXTDOMAIN); ?></label><br />
                      
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_rated']) ? $instance['disable_rated'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_rated'); ?>" id="<?php echo $this->get_field_id('disable_rated'); ?>" />
        <label for="<?php echo $this->get_field_id('disable_rated'); ?>"><?php _e('Rated',IT_TEXTDOMAIN); ?></label><br />
                       
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_commented']) ? $instance['disable_commented'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_commented'); ?>" id="<?php echo $this->get_field_id('disable_commented'); ?>" />
        <label for="<?php echo $this->get_field_id('disable_commented'); ?>"><?php _e('Commented',IT_TEXTDOMAIN); ?></label>            
        
        <p>
			<?php _e( 'Time Period:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'timeperiod' ); ?>">
                <option<?php if($instance['timeperiod']=='This Week') { ?> selected<?php } ?> value="This Week"><?php _e( 'This Week', IT_TEXTDOMAIN ); ?></option>
				<option<?php if($instance['timeperiod']=='This Month') { ?> selected<?php } ?> value="This Month"><?php _e( 'This Month', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='This Year') { ?> selected<?php } ?> value="This Year"><?php _e( 'This Year', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-7 days') { ?> selected<?php } ?> value="-7 days"><?php _e( 'Within Past Week', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-30 days') { ?> selected<?php } ?> value="-30 days"><?php _e( 'Within Past Month', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-60 days') { ?> selected<?php } ?> value="-60 days"><?php _e( 'Within Past 2 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-90 days') { ?> selected<?php } ?> value="-90 days"><?php _e( 'Within Past 3 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-180 days') { ?> selected<?php } ?> value="-180 days"><?php _e( 'Within Past 6 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-365 days') { ?> selected<?php } ?> value="-365 days"><?php _e( 'Within Past Year', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='all') { ?> selected<?php } ?> value="all"><?php _e( 'All Time', IT_TEXTDOMAIN ); ?></option>
			</select>
		</p>
		
		<?php
	}
}
?>