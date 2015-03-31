<?php
class it_list_paged extends WP_Widget {
	function it_list_paged() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Paged Articles', 'description' => __( 'Displays paginated articles with several available filtering options.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_list_paged' );
		/* Create the widget. */
		$this->WP_Widget( 'it_list_paged', 'Paged Articles', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$selected_category = $instance['category'];
		$selected_tag = $instance['tag'];		
		$numarticles = $instance['numarticles'];	
		$sticky = $instance['sticky'];
		$layout = $instance['layout'];
		$disable_filters = it_get_setting('pagedgrid_filters_disable');
		$rating = it_get_setting('grid_rating_disable');
		$disabled = ( is_array( it_get_setting('loop_filter_disable') ) ) ? it_get_setting('loop_filter_disable') : array();
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
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'cat' => $selected_category, 'tag_id' => $selected_tag);
		
		#include sticky posts
		if(!$sticky) $args['ignore_sticky_posts'] = true;
		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'layout' => $layout, 'sort' => 'recent', 'paged' => 1, 'thumbnail' => true, 'rating' => !$rating, 'icon' => true, 'nonajax' => true, 'meta' => true, 'award' => true, 'badge' => true, 'excerpt' => false, 'authorship' => false, 'numarticles' => $numarticles, 'disable_ads' => true, 'size' => $size);	
				
		#adjust args for default filter
		$setup_filters = it_setup_filters($disabled, $args, $format);
		$default_metric = $setup_filters['default_metric'];
		$default_label = $setup_filters['default_label'];
		$args = $setup_filters['args'];
		$format = $setup_filters['format'];
		
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'layout' => $layout, 'disabled_filters' => $disabled, 'numarticles' => $numarticles, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => !$rating, 'meta' => true, 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => false, 'authorship' => false, 'theme_icon' => 'recent');		
					
		#encode current query for ajax purposes
		$current_query = array();
		if(!empty($selected_category)) $current_query['category__in'] = array($selected_category);
		if(!empty($selected_tag)) $current_query['tag__in'] = array($selected_tag);
		$current_query_encoded = json_encode($current_query);
		
		#get correct page number count
		$itposts = new WP_Query($args);
		$numpages = $itposts->max_num_pages;
		wp_reset_postdata();
		
		#fetch the loop
		$loop = it_loop($args, $format); 
		    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo "<div id='widgets-list' class='articles post-container " . $cssclass . $csscompact . " " . $layout . "' data-currentquery='" . $current_query_encoded . "'>";

			#display the sortbar
			if(!($disable_filters && $disable_title)) echo it_get_sortbar($sortbarargs);
			
			echo '<div class="content-inner clearfix">';
			
				echo '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';	
				
				echo '<div class="loop">';
					
					echo $loop['content'];
					
				echo '</div>';
				
			echo '</div>';
						
			echo '<div class="pagination-wrapper">';
			
				echo it_pagination($numpages, $format, it_get_setting('page_range'));
				
			echo '</div>';
			
			echo '<div class="pagination-wrapper mobile">';
			
				echo it_pagination($numpages, $format, it_get_setting('page_range_mobile'));
				
			echo '</div>';
			
		echo '</div>';
		
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
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );			
		$instance['sticky'] = isset( $new_instance['sticky'] );	
		$instance['layout'] = strip_tags( $new_instance['layout'] );	
		
		return $instance;
		
	}
	function form( $instance ) {	

		#set up some default widget settings.
		$defaults = array( 'title' => __('Most Recent', IT_TEXTDOMAIN), 'category' => 'All Categories', 'tag' => 'All Tags', 'numarticles' => 4, 'sticky' => false, 'layout' => 'widget_a' );		
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
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['sticky']) ? $instance['sticky'] : 0  ); ?> id="<?php echo $this->get_field_id( 'sticky' ); ?>" name="<?php echo $this->get_field_name( 'sticky' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'sticky' ); ?>"><?php _e( '"Sticky Post" Aware',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles per page',IT_TEXTDOMAIN); ?>
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