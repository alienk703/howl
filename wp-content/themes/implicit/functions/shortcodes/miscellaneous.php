<?php
/**
 *
 */
class itMiscellaneous {

	/**
	 *
	 */
	public static function styled_amp( $atts = null, $content = null ) {
	
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Styled Amp', IT_TEXTDOMAIN ),
				'value' => 'styled_amp',
				'options' => array(					
					array(
						'name' => __( 'Size', IT_TEXTDOMAIN ),
						'desc' => __( 'The font size of the ampersand.', IT_TEXTDOMAIN ),
						'id' => 'size',
						'target' => 'icon_size',
						'nodisable' => true,
						'type' => 'select',
					),				
				'shortcode_has_atts' => true
				)				
			);

			return $option;
		}
		
		extract(shortcode_atts(array(
			'size'     => '',
	    ), $atts));
		
		$size = ( $size ) ? ' style="font-size:'.$size.'px;line-height:'.$size.'px;"' : '';
		
		return '<span class="styled_amp"'.$size.'>&amp;</span>';
	}

	/**
	 *
	 */
	public static function divider( $atts = null, $content = null, $code = null ) {
		
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Divider', IT_TEXTDOMAIN ),
				'value' => 'divider'
			);

			return $option;
		}
			
		return '<div class="divider"></div>';
	}
	
	/**
	 *
	 */
	public static function divider_top( $atts = null, $content = null, $code = null ) {
		
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Divider Top', IT_TEXTDOMAIN ),
				'value' => 'divider_top'
			);

			return $option;
		}
			
		return '<div class="divider top"><a href="#top"><span class="theme-icon-up-fat"></span>' . __( 'Top', IT_TEXTDOMAIN ) . '</a></div>';
	}
	
	/**
	 *
	 */
	public static function clear( $atts = null, $content = null, $code = null ) {
		
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Content Clearer', IT_TEXTDOMAIN ),
				'value' => 'clear'
			);

			return $option;
		}
			
		return '<div class="clearer"></div>';
	}
	
	/**
	 *
	 */
	public static function div( $atts = null, $content = null, $code = null ) {
		$option = array( 
			'name' => __( 'Div', IT_TEXTDOMAIN ),
			'value' => 'div',
			'options' => array(
				array(
					'name' => __( 'Class', IT_TEXTDOMAIN ),
					'desc' => __( 'Type in the name of the class you wish to assign to this div.', IT_TEXTDOMAIN ),
					'id' => 'class',
					'default' => '',
					'type' => 'text'
				),
				array(
					'name' => __( 'Style', IT_TEXTDOMAIN ),
					'desc' => __( 'You can set a custom style here for your div.', IT_TEXTDOMAIN ),
					'id' => 'style',
					'default' => '',
					'type' => 'text'
				),
				array(
					'name' => __( 'Content', IT_TEXTDOMAIN ),
					'desc' => __( 'Type in the content that you wish to display inside this div.', IT_TEXTDOMAIN ),
					'id' => 'content',
					'default' => '',
					'type' => 'textarea'
				),
			'shortcode_has_atts' => true,
			)
		);
		
		if( $atts == 'generator' )
			return $option;
			
		extract(shortcode_atts(array(
			'style'      => '',
			'class'      => '',
	    	), $atts));

	   return '<div class="' . $class . '" style="' . $style . '">' . it_cleanup_shortcode( $content ) . '</div>';
	}
	
	/**
	 *
	 */
	public static function span( $atts = null, $content = null, $code = null ) {
		$option = array( 
			'name' => __( 'Span', IT_TEXTDOMAIN ),
			'value' => 'span',
			'options' => array(
				array(
					'name' => __( 'Class', IT_TEXTDOMAIN ),
					'desc' => __( 'Type in the name of the class you wish to assign to this span.', IT_TEXTDOMAIN ),
					'id' => 'class',
					'default' => '',
					'type' => 'text'
				),
				array(
					'name' => __( 'Style', IT_TEXTDOMAIN ),
					'desc' => __( 'You can set a custom style here for yourspan.', IT_TEXTDOMAIN ),
					'id' => 'style',
					'default' => '',
					'type' => 'text'
				),
				array(
					'name' => __( 'Content', IT_TEXTDOMAIN ),
					'desc' => __( 'Type in the content that you wish to display inside this span.', IT_TEXTDOMAIN ),
					'id' => 'content',
					'default' => '',
					'type' => 'textarea'
				),
			'shortcode_has_atts' => true,
			)
		);
		
		if( $atts == 'generator' )
			return $option;
			
		extract(shortcode_atts(array(
			'style'      => '',
			'class'      => '',
	    	), $atts));

	   return '<span class="' . $class . '" style="' . $style . '">' . it_cleanup_shortcode( $content ) . '</span>';
	}
		
	/**
	 *
	 */
	public static function hidden( $atts = null, $content = null ) {

		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Hidden', IT_TEXTDOMAIN ),
				'value' => 'hidden',
				'options' => array(					
					array(
						'name' => __( 'Content', IT_TEXTDOMAIN ),
						'desc' => __( 'Any content entered into this area will be included in the code but hidden from view.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),
				'shortcode_has_atts' => true,
				)
			);

			return $option;
		}

		return '<div class="hidden">' . it_cleanup_shortcode( $content ) . '</div>';
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
			'name' => __( 'Miscellaneous', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which Miscellaneous shortcode you wish to use.', IT_TEXTDOMAIN ),
			'value' => 'miscellaneous',
			'options' => $shortcode,
			'shortcode_has_types' => true
		);
		
		return $options;
	}
}
?>
