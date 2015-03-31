<?php
class it_latest_articles extends WP_Widget {
	function it_latest_articles() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Latest Articles', 'description' => __( 'Displays latest articles and can be limited to a specific category and/or tag.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_latest_articles' );
		/* Create the widget. */
		$this->WP_Widget( 'it_latest_articles', 'Latest Articles', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$selected_category = $instance['category'];
		$selected_tag = $instance['tag'];
		$numarticles = $instance['numarticles'];	
		$more = $instance['more'];		
		$layout = $instance['layout'];	
		$link = '';		
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
		
		#selected category
		if($selected_category=='All Categories') {
			$selected_category = '';
		} else {
			$link = get_category_link( $selected_category );
		}
		
		#selected tag
		if($selected_tag=='All Tags') {
			$selected_tag = '';
		} else {
			$link = get_tag_link( $selected_tag );	
		}
		
		if(empty($selected_tag) && empty($selected_category)) $more = false;
		
		#setup the query            
		$args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'order_by' => 'date', 'cat' => $selected_category, 'tag_id' => $selected_tag, 'ignore_sticky_posts' => true);
		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'layout' => $layout, 'sort' => 'recent', 'paged' => 1, 'thumbnail' => true, 'rating' => !$rating, 'icon' => true, 'nonajax' => true, 'meta' => true, 'award' => true, 'badge' => true, 'excerpt' => false, 'authorship' => false, 'numarticles' => $numarticles, 'disable_ads' => true, 'size' => $size);	
		
		#setup sortbar
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'layout' => $layout, 'disabled_filters' => array(), 'numarticles' => 0, 'disable_filters' => true, 'disable_title' => false, 'thumbnail' => true, 'rating' => !$rating, 'meta' => true, 'icon' => true, 'award' => false, 'badge' => false, 'excerpt' => false, 'authorship' => false, 'theme_icon' => 'recent');
		
		#fetch the loop
		$loop = it_loop($args, $format); 
				    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo '<div class="articles post-container' . $cssclass . $csscompact . ' ' . $layout . '">';

			#Title of widget
			if ($title) { 
			         
				echo it_get_sortbar($sortbarargs); 	
								
			} 
        
        	echo '<div class="content-inner clearfix">';
				
				echo '<div class="loop">';
					
					echo $loop['content'];
					
				echo '</div>';
				
				if($more) {
					echo '<div class="longform-wrapper">';
						echo '<a class="longform-more" href="' . esc_url($link) . '">' . __('VIEW ALL',IT_TEXTDOMAIN) . '<span class="theme-icon-right-thin"></span></a>';
					echo '</div>';
				}
				
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
		$instance['more'] = isset( $new_instance['more'] );		
		$instance['layout'] = strip_tags( $new_instance['layout'] );		

		return $instance;
	}
	function form( $instance ) {		

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Latest Articles', 'category' => 'All Categories', 'tag' => 'All Tags', 'numarticles' => 5, 'more' => true, 'layout' => 'widget_a');
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
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles',IT_TEXTDOMAIN); ?>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['more']) ? $instance['more'] : 0  ); ?> id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'more' ); ?>"><?php _e( 'Display "View All" link after posts',IT_TEXTDOMAIN); ?></label>             
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