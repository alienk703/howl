<?php
/**
 *
 */
class itConnect {	
	
	public static function connect( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Connect', IT_TEXTDOMAIN ),
				'value' => 'connect',
				'options' => array(
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the connect bar.', IT_TEXTDOMAIN ),
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
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'title'					=> '',
			'icon'					=> ''
		), $atts));	
		
		$out = '';
		
		#put the actions into variables
		ob_start();
		do_action('it_before_connect', it_get_setting('ad_connect_before'), 'before-connect');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_connect', it_get_setting('ad_connect_after'), 'after-connect');
		$after = ob_get_contents();
		ob_end_clean();	
		
		$out .= $before;
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
    
        $out .= '<div class="connect clearfix">';
        
			if(!empty($title) || !empty($icon)) {
				
				$out .= '<div class="bar-label-wrapper">';
		
					$out .= '<div class="bar-label has-icon">';
				
						$out .= '<div class="label-text">';
						
							if(!empty($icon)) $out .= '<span class="theme-icon-' . $icon . '"></span>';
							
							if(!empty($title)) $out .= $title;
							
						$out .= '</div>';
						
					$out .= '</div>';
				
				$out .= '</div>';
				
			}
            
            if(!it_get_setting('connect_email_disable')) $out .= it_email_form();
            
            if(!it_get_setting('connect_counts_disable')) {
            
                $out .= '<div class="connect-counts">';
                    
                    $out .= it_widget_panel('Connect Widgets', '', false);
                
                $out .= '</div>';
                
            }
            
            if(!it_get_setting('connect_social_disable')) {
            
                $out .= '<div class="connect-social">';
                    
                    $out .= it_social_badges('top');
                
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
			'name' => __( 'Connect', IT_TEXTDOMAIN ),
			'value' => 'connect',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
