<?php
/**
 *
 */
class itAlerts {
	
	/**
	 *
	 */
	public static function alert( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Alert', IT_TEXTDOMAIN ),
				'value' => 'alert',
				'options' => array(
				
					array(
						'name' => __( 'Alert Html', IT_TEXTDOMAIN ),
						'desc' => __( 'Type out the content of your alert box.  You can use HTML tags here if you want.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),					
					array(
						'name' => __( 'Style Variations', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose one of the predefined alert box styles to use.', IT_TEXTDOMAIN ),
						'id' => 'variation',
						'default' => '',
						'options' => array(
							'alert-warning' => __('Alert', IT_TEXTDOMAIN ),
							'alert-danger' => __('Error', IT_TEXTDOMAIN ),
							'alert-success' => __('Success', IT_TEXTDOMAIN ),
							'alert-info' => __('Info', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Dismiss Button', IT_TEXTDOMAIN ),
						'id' => 'dismiss',
						'options' => array( 'dismiss' => __( 'Display the alert box dismissal button', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'variation'	=> '',
			'dismiss'     => ''
	    ), $atts));

		$dismiss = ( $dismiss ) ? '<button type="button" class="close" data-dismiss="alert">&times;</button>' : '';
		
		$out = '<div class="alert alert-dismissable '.$variation.'">'.$dismiss.do_shortcode($content).'</div>';

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
			'name' => __( 'Alert Boxes', IT_TEXTDOMAIN ),
			'value' => 'alert',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
