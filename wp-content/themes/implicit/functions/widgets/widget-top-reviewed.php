<?php
class it_top_reviewed extends WP_Widget {
	function it_top_reviewed() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Top Reviewed', 'description' => __( 'Displays top reviewed articles from a designated recent time period.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_top_reviewed' );
		/* Create the widget. */
		$this->WP_Widget( 'it_top_reviewed', 'Top Reviewed', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$selected_category = $instance['category'];
		$selected_tag = $instance['tag'];
		$numarticles = $instance['numarticles'];
		$orderby = $instance['orderby'];
		$timeperiod = $instance['timeperiod'];		
		$layout = $instance['layout'];		
		$rating = it_get_setting('grid_rating_disable');
		$loop = 'main';
		$location = $layout;
		$size = '';
		$disable_title = empty($title) ? true : false;
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
		
		#clear out unselected values
		if($selected_category=='All Categories') $selected_category = '';		
		if($selected_tag=='All Tags') $selected_tag = '';
		
		if(empty($orderby)) $orderby = IT_META_TOTAL_SCORE_NORMALIZED;
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'ignore_sticky_posts' => true, 'meta_key' => $orderby, 'orderby' => 'meta_value_num', 'meta_query' => array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' )), 'cat' => $selected_category, 'tag_id' => $selected_tag);		
				
		#set time period args
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
        
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'layout' => $layout, 'sort' => 'recent', 'paged' => 1, 'thumbnail' => true, 'rating' => !$rating, 'icon' => true, 'nonajax' => true, 'meta' => true, 'award' => true, 'badge' => true, 'excerpt' => false, 'authorship' => false, 'numarticles' => $numarticles, 'disable_ads' => true, 'size' => $size);	
		
		#setup sortbar
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'layout' => $layout, 'disabled_filters' => array(), 'numarticles' => $numarticles, 'disable_filters' => true, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => !$rating, 'meta' => true, 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => false, 'authorship' => false, 'theme_icon' => 'recent');
        
		#fetch the loop
        $loop = it_loop($args, $format, $timeperiod); 
		
        #Before widget (defined by themes)
        echo $before_widget;

        echo '<div class="articles post-container' . $cssclass . $csscompact . ' ' . $layout . '">';

			#Title of widget
			if ($title) { 
			                	
				echo it_get_sortbar($sortbarargs);
				
			} 
        
        	echo '<div class="content-inner">';
				
				echo '<div class="loop">';
					
					echo $loop['content'];
					
				echo '</div>';
				
			echo '</div>';	
		
		echo '</div>';
		
		wp_reset_query();				
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['tag'] = strip_tags( $new_instance['tag'] );	
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		$instance['timeperiod'] = strip_tags( $new_instance['timeperiod'] );		
		$instance['layout'] = strip_tags( $new_instance['layout'] );

		return $instance;
	}
	function form( $instance ) {		

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Top Rated This Week', 'category' => 'All Categories', 'tag' => 'All Tags', 'numarticles' => 5, 'orderby' => 'Total Score', 'timeperiod' => 'This Year',  'layout' => 'widget_a' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
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
                <option<?php if($instance['timeperiod']=='-180 days') { ?> selected<?php } ?> value="-90 days"><?php _e( 'Within Past 6 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-365 days') { ?> selected<?php } ?> value="-365 days"><?php _e( 'Within Past Year', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='all') { ?> selected<?php } ?> value="all"><?php _e( 'All Time', IT_TEXTDOMAIN ); ?></option>
			</select>
		</p>
        
        <p>
			<?php _e( 'Rank By:',IT_TEXTDOMAIN); ?>
        </p>
        
        <p>          
            <input class="radio" type="radio" <?php if($instance['orderby']==IT_META_TOTAL_SCORE_NORMALIZED) { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo IT_META_TOTAL_SCORE_NORMALIZED; ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>_editor" />                
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>_editor"><?php _e( 'Editor Rating',IT_TEXTDOMAIN); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;   
            <input class="radio" type="radio" <?php if($instance['orderby']==IT_META_TOTAL_USER_SCORE_NORMALIZED) { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo IT_META_TOTAL_USER_SCORE_NORMALIZED; ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>_user" />
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>_user"><?php _e( 'User Rating',IT_TEXTDOMAIN); ?></label>              
        </p>		
	
		<p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'reviews',IT_TEXTDOMAIN); ?>
		</p>
                
        <p><?php _e( 'Layout:',IT_TEXTDOMAIN); ?></p>	
                 
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;float:left;margin-right:10px;margin-bottom:10px;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
            	<input class="radio" type="radio" <?php if($instance['layout']=='widget_a') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_a" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_a" />  
            </div>
            <div style="float:left;">
            	<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_a"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_a.png' ?>" /></label>
            </div>
        </div>
          
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;margin-bottom:10px;margin-right:10px;float:left;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
        		<input class="radio" type="radio" <?php if($instance['layout']=='widget_b') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_b" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_b" /> 
        	</div>
            <div style="float:left;">               
        		<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_b"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_b.png' ?>" /></label>  
        	</div>
        </div>
        
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;float:left;margin-right:10px;margin-bottom:10px;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
            	<input class="radio" type="radio" <?php if($instance['layout']=='widget_c') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_c" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_c" />  
            </div>
            <div style="float:left;">
            	<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_c"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_c.png' ?>" /></label>
            </div>
        </div>
          
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;margin-bottom:10px;margin-right:10px;float:left;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
        		<input class="radio" type="radio" <?php if($instance['layout']=='widget_d') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_d" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_d" /> 
        	</div>
            <div style="float:left;">               
        		<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_d"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_d.png' ?>" /></label>  
        	</div>
        </div>   
                
        <div style="clear:both;">&nbsp;</div>        
		
		<?php
	}
}
?>