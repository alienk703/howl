<?php
/**
 *
 */
class itPopovers {
	
	/**
	 *
	 */
	public static function popover( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Popover', IT_TEXTDOMAIN ),
				'value' => 'popover',
				'options' => array(
				
					array(
						'name' => __( 'Popover-Enabled Content', IT_TEXTDOMAIN ),
						'desc' => __( 'Put text or HTML in here and it will trigger the popover when clicked', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),
					array(
						'name' => __( 'Popover Title', IT_TEXTDOMAIN ),
						'desc' => __( 'The title of the popover box', IT_TEXTDOMAIN ),
						'id' => 'title',
						'default' => '',
						'type' => 'text',
					),
					array(
						'name' => __( 'Popover Body', IT_TEXTDOMAIN ),
						'desc' => __( 'The body content of the popover box', IT_TEXTDOMAIN ),
						'id' => 'body',
						'default' => '',
						'type' => 'text',
					),
					array(
						'name' => __( 'Placement', IT_TEXTDOMAIN ),
						'desc' => __( 'The direction the popover should fly out', IT_TEXTDOMAIN ),
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
			'title'      => '',
			'body'       => '',
		    'placement'  => 'top'
	    ), $atts));

		$placement = ( $placement ) ? ' data-placement="'.$placement.'"' : '';
		
		$out = '<div class="popthis" data-title="'.$title.'" data-content="'.$body.'"'.$placement.'>'.do_shortcode($content).'</div>';

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
			'name' => __( 'Popovers', IT_TEXTDOMAIN ),
			'value' => 'popover',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
