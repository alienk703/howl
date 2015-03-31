<?php
/**
 *
 */
class itTabs {
	
	/**
	 *
	 */
	public static function tabs( $atts = null, $content = null, $code = null ) {
		if( $atts == 'generator' ) {
			$numbers = range(1,20);

			$option = array( 
				'name' => __( 'Tabs', IT_TEXTDOMAIN ),
				'value' => 'tabs',
				'options' => array(					
					array(
						'name' => __( 'Style', IT_TEXTDOMAIN ),
						'desc' => __( 'The style of the tab navigation', IT_TEXTDOMAIN ),
						'id' => 'style',
						'default' => '',
						'options' => array(
							'nav-tabs' => __('Tabs', IT_TEXTDOMAIN ),
							'nav-pills' => __('Pills', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
						'shortcode_dont_multiply' => true
					),					
					array(
						'name' => __( 'Number of tabs', IT_TEXTDOMAIN ),
						'desc' => __( 'Select the number of tabs you wish to display.  The tabs are the selectable areas which change the content.', IT_TEXTDOMAIN ),
						'id' => 'multiply',
						'default' => '',
						'options' => $numbers,
						'type' => 'select',
						'target' => '',
						'shortcode_multiplier' => true
					),
					array(
						'name' => __( 'Tab 1 Title', IT_TEXTDOMAIN ),
						'desc' => __( 'The text to use for the tab navigation', IT_TEXTDOMAIN ),
						'id' => 'title',
						'default' => '',
						'type' => 'text',
						'shortcode_multiply' => true
					),
					array(
						'name' => __( 'Tab 1 Content', IT_TEXTDOMAIN ),
						'desc' => __( 'The content of the tab. Shortcodes are accepted.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea',
						'shortcode_multiply' => true
					),
					array(
						'value' => 'tab',
						'nested' => true
					),
				'shortcode_has_atts' => true,
				)
			);

			return $option;
		}
		
		extract(shortcode_atts(array(
			'style'      => 'nav-tabs',			
	    ), $atts));
		
		if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
			return it_cleanup_shortcode( $content );
		} else {
			
			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
			}
						
			$id = rand();
			
			$out = '<div class="tabbable">';
			
				$out .= '<ul class="nav '.$style.'">';
				
					for($i = 0; $i < count($matches[0]); $i++) {
						$active='';
						if($i==0) $active=' class="active"';
						$out .= '<li'.$active.'><a href="#pane'.$i.'_'.$id.'" class="no-scroll" data-toggle="tab">' . $matches[3][$i]['title'] . '</a></li>';
					}
				
				$out .= '</ul>';
				
				$out .= '<div class="tab-content">';
				
					for($i = 0; $i < count($matches[0]); $i++) {
						$active='';
						if($i==0) $active=' in active';
						$out .= '<div id="pane'.$i.'_'.$id.'" class="tab-pane fade'.$active.'">' . it_cleanup_shortcode( $matches[5][$i] ) . '</div>';
					}
				
				$out .= '</div>';				
			
			$out .= '</div>';
			
			return $out;
		}
		
	}
		
	/**
	 *
	 */
	public static function _options($class) {
		$shortcode = array();
		
		$class_methods = get_class_methods( $class );
		
		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}
		
		$options = array(
			'name' => __( 'Tabs', IT_TEXTDOMAIN ),
			'value' => 'tabs',
			'options' => $shortcode,
		);
		
		return $options;
	}
	
}

?>
