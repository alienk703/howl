<?php
/**
 *
 */
class itTooltips {
	
	/**
	 *
	 */
	public static function tooltip( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Tooltip', IT_TEXTDOMAIN ),
				'value' => 'tooltip',
				'options' => array(
				
					array(
						'name' => __( 'Tooltip-Enabled Text', IT_TEXTDOMAIN ),
						'desc' => __( 'The text that you want to be tooltip-enebled', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'text'
					),
					array(
						'name' => __( 'Tooltip', IT_TEXTDOMAIN ),
						'desc' => __( 'That text that displays when you hover over the tooltip-enabled text', IT_TEXTDOMAIN ),
						'id' => 'text',
						'default' => '',
						'type' => 'text',
					),
					array(
						'name' => __( 'Placement', IT_TEXTDOMAIN ),
						'desc' => __( 'The direction the tooltip should fly out', IT_TEXTDOMAIN ),
						'id' => 'placement',
						'default' => '',
						'options' => array(
							'top' => __('top', IT_TEXTDOMAIN ),
							'bottom' => __('bottom', IT_TEXTDOMAIN ),
							'left' => __('left', IT_TEXTDOMAIN ),
							'right' => __('right', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
					),					
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'text'      => '',
		    'placement'      => ''
	    ), $atts));

		$placement = ( $placement ) ? ' data-placement="'.$placement.'"' : '';
		
		$out = '<a href="#" class="info" data-toggle="tooltip" title="'.$text.'"'.$placement.'>'.do_shortcode($content).'</a>';

	    return $out;
	}
	
	public static function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods( $class );
		
		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}
		
		$options = array(
			'name' => __( 'Tooltips', IT_TEXTDOMAIN ),
			'value' => 'tooltip',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
