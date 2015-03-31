<?php
/**
 *
 */
class itWidgets {	
	
	public static function widgets( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array();
			
			return $option;
		}
		
		extract(shortcode_atts(array(), $atts));	
		
		$out = '';
		
		$col1 = __('Widgets Column 1',IT_TEXTDOMAIN);
		$col2 = __('Widgets Column 2',IT_TEXTDOMAIN);
		$col3 = __('Widgets Column 3',IT_TEXTDOMAIN);
		$class = 'widgets';	
		
		#put the actions into variables
		ob_start();
		do_action('it_before_widgets', it_get_setting('ad_widgets_before'), 'before-widgets');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_widgets', it_get_setting('ad_widgets_after'), 'after-widgets');
		$after = ob_get_contents();
		ob_end_clean();		
		
		$out .= $before;
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
			
		$out .= '<div class="container-fluid widgets-outer">';
			
			$out .= '<div class="row no-margin">';
				
				$out .= '<div class="widget-panel left col-md-4">';
				
					$out .= it_widget_panel($col1, $class);
					
				$out .= '</div>';
			
				$out .= '<div class="widget-panel mid col-md-4">';
				
					$out .= it_widget_panel($col2, $class);
					
				$out .= '</div>';
			
				$out .= '<div class="widget-panel right col-md-4">';
				
					$out .= it_widget_panel($col3, $class);
					
				$out .= '</div> ';       
				
			$out .= '</div>';
			
		$out .= '</div>';
		
		$out .= $after;
				
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
			'name' => __( 'Widgets', IT_TEXTDOMAIN ),
			'value' => 'widgets',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
