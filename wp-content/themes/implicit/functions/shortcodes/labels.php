<?php
/**
 *
 */
class itLabels {
	
	/**
	 *
	 */
	public static function label( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Label', IT_TEXTDOMAIN ),
				'value' => 'label',
				'options' => array(
					array(
						'name' => __( 'Label Text', IT_TEXTDOMAIN ),
						'desc' => __( 'Type out the text that you wish to display in the label.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),
					array(
						'name' => __( 'Style Variations', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose one of the predefined label styles to use.', IT_TEXTDOMAIN ),
						'id' => 'variation',
						'default' => '',
						'options' => array(
							'label-default' => __('Default', IT_TEXTDOMAIN ),
							'label-primary' => __('Primary', IT_TEXTDOMAIN ),
							'label-success' => __('Success', IT_TEXTDOMAIN ),
							'label-info' => __('Info', IT_TEXTDOMAIN ),	
							'label-warning' => __('Warning', IT_TEXTDOMAIN ),
							'label-danger' => __('Danger', IT_TEXTDOMAIN ),													
						),
						'type' => 'select',
						'target' => '',
					),
					
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'variation'	=> '',
	    ), $atts));
	
		$out = '<span class="label '.$variation.'">' . it_cleanup_shortcode( $content ) . '</span>';

	    return $out;
	}
	
	/**
	 *
	 */
	public static function badge( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Badge', IT_TEXTDOMAIN ),
				'value' => 'badge',
				'options' => array(
					array(
						'name' => __( 'Badge Text', IT_TEXTDOMAIN ),
						'desc' => __( 'Type out the text that you wish to display in the badge.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'variation'	=> '',
	    ), $atts));
	
		$out = '<span class="badge">' . it_cleanup_shortcode( $content ) . '</span>';

	    return $out;
	}
	
	/**
	 *
	 */
	public static function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods( $class );
		
		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}
		
		$options = array(
			'name' => __( 'Labels &amp; Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose which type of style you want to use.', IT_TEXTDOMAIN ),
			'value' => 'labels',
			'options' => $shortcode,
			'shortcode_has_types' => true
		);
		
		return $options;
	}
	
}

?>
