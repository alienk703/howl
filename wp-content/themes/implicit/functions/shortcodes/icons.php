<?php
/**
 *
 */
class itIcons	 {
	
	/**
	 *
	 */
	public static function icons( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Icons', IT_TEXTDOMAIN ),
				'value' => 'icons',
				'options' => array(
					array(
						'name' => __( 'Icons', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose which icon you want to insert into the content.', IT_TEXTDOMAIN ),
						'id' => 'icon',
						'default' => '',
						'target' => 'icons',
						'type' => 'select'
					),
					array(
						'name' => __( 'Color', IT_TEXTDOMAIN ),
						'desc' => __( 'The color of the icon image.', IT_TEXTDOMAIN ),
						'id' => 'color',
						'type' => 'color'
					),	
					array(
						'name' => __( 'Size', IT_TEXTDOMAIN ),
						'desc' => __( 'The height of the icon in pixels.', IT_TEXTDOMAIN ),
						'id' => 'size',
						'target' => 'icon_size',
						'nodisable' => true,
						'type' => 'select'
					),				
				'shortcode_has_atts' => true,
				'shortcode_carriage_return' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'icon'     => '',
			'color'    => '',
			'size'     => '',
	    ), $atts));
		
		$style = ' style="font-size:'.$size.'px;color:'.$color.'"';		
	
		$out = '<span class="theme-icon-'.$icon.'"'.$style.'></span>';

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
			'name' => __( 'Icons', IT_TEXTDOMAIN ),
			'value' => 'icons',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
