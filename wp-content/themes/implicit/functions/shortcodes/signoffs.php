<?php
/**
 *
 */
class itSignoffs {
	
	/**
	 *
	 */
	public static function signoff( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Signoff', IT_TEXTDOMAIN ),
				'value' => 'signoff',
				'options' => array(												
					array(
						'name' => __( 'Predefined Content', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose one of the predefined alert box styles to use.', IT_TEXTDOMAIN ),
						'id' => 'predefined',
						'default' => '',
						'target' => 'signoff',
						'type' => 'select',
					),
					array(
						'name' => __( 'Custom Content', IT_TEXTDOMAIN ),
						'desc' => __( 'Type out the content of signoff text.  You can use HTML tags here if you want.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),	
					array(
						'name' => __( 'Icon', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose an icon image to use to the left of the box.', IT_TEXTDOMAIN ),
						'id' => 'icon',
						'default' => '',
						'target' => 'icons',
						'type' => 'select',
					),
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'predefined'      => '',
			'icon'	=> ''
	    ), $atts));
		
		$class = ( $icon=='none' || empty($icon) ) ? ' none' : '';

		$icon = ( $icon ) ? '<span class="icon theme-icon-'.$icon.'"></span>' : '';
		
		if(empty($content)) {			
			$signoff = it_get_setting('signoff');
			if ( isset($signoff['keys']) && $signoff['keys'] != '#' ) {
				$signoff_keys = explode(',',$signoff['keys']);
				foreach ($signoff_keys as $skey) {
					if ( $skey != '#') {
						$signoff_name = ( !empty( $signoff[$skey]['name'] ) ) ? stripslashes($signoff[$skey]['name']) : '#';	
						$signoff_content = ( !empty( $signoff[$skey]['content'] ) ) ? stripslashes($signoff[$skey]['content']) : '#';	
						if($signoff_name==$predefined) {
							$content = $signoff_content;	
						}
					}
				}
			}
			
		}
		
		$out = '<div class="signoff'.$class.'">'.$icon.do_shortcode(wpautop($content)).'</div>';

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
			'name' => __( 'Signoffs', IT_TEXTDOMAIN ),
			'value' => 'signoff',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
