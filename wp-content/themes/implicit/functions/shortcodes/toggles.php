<?php
/**
 *
 */
class itToggles {
	
	/**
	 *
	 */
	public static function toggles( $atts = null, $content = null, $code = null ) {
		if( $atts == 'generator' ) {
			$numbers = range(1,100);

			$option = array( 
				'name' => __( 'Toggle', IT_TEXTDOMAIN ),
				'value' => 'toggles',
				'options' => array(					
					array(
						'name' => __( 'Behavior', IT_TEXTDOMAIN ),
						'desc' => __( 'Should the toggles be individual or grouped together as an accordion style.', IT_TEXTDOMAIN ),
						'id' => 'behavior',
						'default' => '',
						'options' => array(
							'toggle' => __('Toggle', IT_TEXTDOMAIN ),
							'accordion' => __('Accordion', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
						'shortcode_dont_multiply' => true
					),
					array(
						'name' => __( 'Number of toggles', IT_TEXTDOMAIN ),
						'desc' => __( 'Select the number of toggles you wish to display.', IT_TEXTDOMAIN ),
						'id' => 'multiply',
						'default' => '',
						'options' => $numbers,
						'type' => 'select',
						'target' => '',
						'shortcode_multiplier' => true
					),
					array(
						'name' => __( 'Toggle 1 Title', IT_TEXTDOMAIN ),
						'desc' => __( 'The text to use for the toggle selector', IT_TEXTDOMAIN ),
						'id' => 'title',
						'default' => '',
						'type' => 'text',
						'shortcode_multiply' => true
					),
					array(
						'name' => __( 'Toggle 1 Content', IT_TEXTDOMAIN ),
						'desc' => __( 'The content of the toggle container. Shortcodes are accepted.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea',
						'shortcode_multiply' => true
					),
					array(
						'name' => __( 'Toggle 1 Default State', IT_TEXTDOMAIN ),
						'desc' => __( 'Should this toggle be expanded or collapsed by default.', IT_TEXTDOMAIN ),
						'id' => 'expanded',
						'default' => '',
						'options' => array(
							'' => __('Collapsed', IT_TEXTDOMAIN ),
							'in' => __('Expanded', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
						'shortcode_multiply' => true
					),
					array(
						'value' => 'toggle',
						'nested' => true
					),
				'shortcode_has_atts' => true,
				)
			);

			return $option;
		}
		
		extract(shortcode_atts(array(
			'behavior'      => 'toggle',
			'expanded'      => '',
	    ), $atts));
		
		if (!preg_match_all("/(.?)\[(toggle)\b(.*?)(?:(\/))?\](?:(.+?)\[\/toggle\])?(.?)/s", $content, $matches)) {
			return it_cleanup_shortcode( $content );
		} else {
			
			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
			}
						
			$id = rand();			
			$out = '';
			$accordionid = '';
			$parent = '';
			
			if($behavior=='accordion') {	
			
				$accordionid = ' id="accordion_'.$id.'"';
				
				$parent = ' data-parent="#accordion_'.$id.'"';	
				
			}
								
			$out .= '<div class="panel-group"'.$accordionid.'>';
			
			for($i = 0; $i < count($matches[0]); $i++) {
				
				$expanded = !empty($matches[3][$i]['expanded']) ? $matches[3][$i]['expanded'] : '';
				
				if($behavior=='accordion') {
						
					$collapseid = 'collapse_'.$i.'_'.$id;
					
				} else {
					
					$collapseid = 'toggle_'.$i.'_'.$id;	
					
				}
				
				$out .= '<div class="panel panel-default">';
			
					$out .= '<div class="panel-heading">';
				
						$out .= '<h3 class="panel-title"><a class="no-scroll" data-toggle="collapse"'.$parent.' href="#'.$collapseid.'">' . $matches[3][$i]['title'] . '</a></h3>';
					
					$out .= '</div>';
					
					$out .= '<div id="'.$collapseid.'" class="panel-collapse collapse '.$expanded.'">';
					
						$out .= '<div class="panel-body">' . it_cleanup_shortcode( $matches[5][$i] ) . '</div>';
					
					$out .= '</div>';
					
				$out .= '</div>';
			}
			
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
			'name' => __( 'Toggles & Accordions', IT_TEXTDOMAIN ),
			'value' => 'toggles',
			'options' => $shortcode,
		);
		
		return $options;
	}
	
}

?>
