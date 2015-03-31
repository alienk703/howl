<?php
class it_social_tabs extends WP_Widget {
	function it_social_tabs() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Social Tabs', 'description' => __( 'Displays Latest Tweets, Facebook Like Box, Flickr Photos, and Recent Comments',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 290, 'height' => 350, 'id_base' => 'it_social_tabs' );
		/* Create the widget. */
		$this->WP_Widget( 'it_social_tabs', 'Social Tabs', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {		

		extract( $args );

		/* User-selected settings. */
		$twitter = $instance['twitter'];
		$numtweets = $instance['numtweets'];
		$facebook = $instance['facebook'];
		$pinterest = $instance['pinterest'];
		$flickr = $instance['flickr'];
		$numphotos = $instance['numphotos'];
		$comments = $instance['comments'];
		$numcomments = $instance['numcomments'];
		/*defaults*/
		$twitter_shown = false;
		$pinterest_shown = false;
		$facebook_shown = false;
		$flickr_shown = false;
		$comments_shown = false;
		    
        #Before widget (defined by themes)
        echo $before_widget;

        #HTML output
		echo '<div class="it-widget-tabs it-social-tabs section-buttons">';	
		echo '<ul class="sort-buttons clearfix">';
		
		if($twitter && !$twitter_shown) echo '<li><a href="#twitter-social-tab" class="info theme-icon-twitter" title="' . __('Twitter', IT_TEXTDOMAIN) . '"></a></li>';
		if($pinterest && !$pinterest_shown) echo '<li><a href="#pinterest-social-tab" class="info theme-icon-pinterest" title="' . __('Pinterest', IT_TEXTDOMAIN) . '"></a></li>';
		if($facebook && !$facebook_shown) echo '<li><a href="#facebook-social-tab" class="info theme-icon-facebook" title="' . __('Facebook', IT_TEXTDOMAIN) . '"></a></li>';		
		if($flickr && !$flickr_shown) echo '<li><a href="#flickr-social-tab" class="info theme-icon-flickr" title="' . __('Flickr', IT_TEXTDOMAIN) . '"></a></li>';
		if($comments && !$comments_shown) echo '<li><a href="#comments-social-tab" class="info theme-icon-commented" title="' . __('Recent Comments', IT_TEXTDOMAIN) . '"></a></li>';
		echo '</ul>';		
		
		if($twitter) {
			echo '<div id="twitter-social-tab">';
			echo it_get_setting('twitter_widget_code');
			echo '</div>';
		}		
		if($pinterest) {
			$pinteresturl = it_get_setting('pinterest_url');
			echo '<div id="pinterest-social-tab">';
			echo '<a data-pin-do="embedUser" href="' . esc_url($pinteresturl) . '" data-pin-scale-height="300"></a>';
			echo '</div>';
		}
		if($facebook) {   
			$url = it_get_setting('facebook_url');
			$colorscheme = it_get_setting('facebook_color_scheme');
			$showfaces = it_get_setting('facebook_show_faces');
			if($showfaces) { 
				$showfaces = 'true';
			} else { 
				$showfaces = 'false'; 
			}
			$stream = it_get_setting('facebook_stream');
			if($stream) { 
				$stream = 'true';
			} else { 
				$stream = 'false'; 
			}			
			$header = it_get_setting('facebook_show_header');
			if($header) { 
				$header = 'true';
			} else { 
				$header = 'false'; 
			}	
			$bordercolor = it_get_setting('facebook_border_color');
			echo '<div id="facebook-social-tab">';
			echo '<div class="fb-like-box" data-href="' . esc_url($url) . '" data-colorscheme="' . $colorscheme . '" data-show-faces="' . $showfaces . '" data-stream="' . $stream . '" data-header="' . $header . '" data-border-color="' . $bordercolor . '"></div>';
			echo '</div>';
		}		
		if($flickr) {
			$flickrid = it_get_setting('flickr_id');
			echo '<div id="flickr-social-tab" aria-expanded="true" aria-hidden="false">';
			echo '<ul class="flickr"></ul><br class="clearer" /><a class="more-link" href="http://www.flickr.com/photos/'. esc_url($flickrid) . '" target="_blank">' . __( 'View more photos', IT_TEXTDOMAIN ) . ' &raquo;</a>';            
			echo '</div>';
		}
		if($comments) {
			echo '<div id="comments-social-tab">';
			echo '<ul>';
			$args = array(
				'status' => 'approve',
				'number' => $numcomments
			);
			$comments = get_comments($args);
			foreach($comments as $comment) :								
				$commentcontent = strip_tags($comment->comment_content);			
				if (mb_strlen($commentcontent)>110) {
					$commentcontent = mb_substr($commentcontent, 0, 107) . "...";
				}
				$commentauthor = $comment->comment_author;
				if (mb_strlen($commentauthor)>50) {
					$commentauthor = mb_substr($commentauthor, 0, 47) . "...";			
				}
				$commentid = $comment->comment_ID;
				$commenturl = get_comment_link($commentid);
				echo '<li><a href="' . esc_url($commenturl) . '">"' . $commentcontent . '"<span> -&nbsp;' . $commentauthor . '</span></a></li>';
			endforeach;
			echo '</ul>';
			echo '</div>';
		}
		echo '</div>'; #end it-widget-tabs div	
		
		wp_reset_query();			
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
			
		$instance = $old_instance;		
		
		$instance['twitter'] = isset( $new_instance['twitter'] );
		$instance['numtweets'] = strip_tags( $new_instance['numtweets'] );
		$instance['facebook'] = isset( $new_instance['facebook'] );
		$instance['pinterest'] = isset( $new_instance['pinterest'] );
		$instance['flickr'] = isset( $new_instance['flickr'] );
		$instance['numphotos'] = strip_tags( $new_instance['numphotos'] );		
		$instance['comments'] = isset( $new_instance['comments'] );
		$instance['numcomments'] = strip_tags( $new_instance['numcomments'] );	
		
		return $instance;
		
	}
	function form( $instance ) {	

		#set up some default widget settings.
		$defaults = array( 'numtweets' => 5, 'twitter' => true, 'facebook' => true, 'pinterest' => true, 'flickr' => true, 'numphotos' => 9, 'comments' => true, 'numcomments' => 5);	
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
        <p>
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['twitter']) ? $instance['twitter'] : 0  ); ?> id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Show Latest Tweets', IT_TEXTDOMAIN); ?></label><br />         
        </p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['facebook']) ? $instance['facebook'] : 0  ); ?> id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Show Facebook Likebox',IT_TEXTDOMAIN); ?></label><br />         
    	</p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['pinterest']) ? $instance['pinterest'] : 0  ); ?> id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Show Pinterest Profile',IT_TEXTDOMAIN); ?></label><br />             
    	</p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['flickr']) ? $instance['flickr'] : 0  ); ?> id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e( 'Show ', IT_TEXTDOMAIN); ?> <input id="<?php echo $this->get_field_id( 'numphotos' ); ?>" name="<?php echo $this->get_field_name( 'numphotos' ); ?>" value="<?php echo $instance['numphotos']; ?>" style="width:30px" /> <?php _e( 'Flickr Photos',IT_TEXTDOMAIN); ?></label><br />            
    	</p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['comments']) ? $instance['comments'] : 0  ); ?> id="<?php echo $this->get_field_id( 'comments' ); ?>" name="<?php echo $this->get_field_name( 'comments' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'comments' ); ?>"><?php _e( 'Show ', IT_TEXTDOMAIN); ?> <input id="<?php echo $this->get_field_id( 'numcomments' ); ?>" name="<?php echo $this->get_field_name( 'numcomments' ); ?>" value="<?php echo $instance['numcomments']; ?>" style="width:30px" /> <?php _e( ' Recent Comments',IT_TEXTDOMAIN); ?></label>
		</p>
		<?php
	}
}
?>