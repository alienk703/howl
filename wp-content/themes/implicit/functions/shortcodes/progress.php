<?php
/**
 *
 */
class itProgress {
	
	/**
	 *
	 */
	public static function progress( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Progress Bar', IT_TEXTDOMAIN ),
				'value' => 'progress',
				'options' => array(
				
					array(
						'name' => __( 'Progress Percentage', IT_TEXTDOMAIN ),
						'desc' => __( 'What position should this progress bar be in?', IT_TEXTDOMAIN ),
						'id' => 'size',
						'target' => 'percentage',
						'nodisable' => true,
						'type' => 'select'
					),
					array(
						'name' => __( 'Style Variations', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose one of the predefined progress bar styles to use.', IT_TEXTDOMAIN ),
						'id' => 'variation',
						'default' => '',
						'options' => array(
							'progress-bar-info' => __('Info', IT_TEXTDOMAIN ),
							'progress-bar-success' => __('Success', IT_TEXTDOMAIN ),
							'progress-bar-warning' => __('Warning', IT_TEXTDOMAIN ),
							'progress-bar-danger' => __('Danger', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Striped', IT_TEXTDOMAIN ),
						'id' => 'striped',
						'options' => array( 'progress-striped' => __( 'Add subtle stripe style to this progress bar', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Animated', IT_TEXTDOMAIN ),
						'id' => 'animated',
						'options' => array( 'active' => __( 'Add an animation effect to this progress bar', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'size'      => '',
			'variation'	=> '',
			'striped'   => '',
			'animated'  => ''
	    ), $atts));

		$out = '<div class="progress '.$striped.' '.$animated.'"><div class="progress-bar '.$variation.'" role="progressbar" aria-valuenow="'.$size.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$size.'%;"></div></div>';

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
			'name' => __( 'Progress Bars', IT_TEXTDOMAIN ),
			'value' => 'progress',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
