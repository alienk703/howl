<?php
/**
 *
 */
class itSection {
	
	/**
	 *
	 */
	public static function section( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Content Section', IT_TEXTDOMAIN ),
				'value' => 'section',
				'options' => array(				
					
					array(
						'name' => __( 'Label', IT_TEXTDOMAIN ),
						'desc' => __( 'Text that appears in the content menu', IT_TEXTDOMAIN ),
						'id' => 'label',
						'default' => '',
						'type' => 'text',
					),		
					array(
						'name' => __( 'Anchor Text', IT_TEXTDOMAIN ),
						'desc' => __( 'This is used by the href of the anchor link and is useful if you are using Cyrillic characters in the Label since Cyrillics do not play well with anchor hrefs.', IT_TEXTDOMAIN ),
						'id' => 'anchor',
						'default' => '',
						'type' => 'text',
					),								
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'label'      => '',
			'anchor'     => ''
	    ), $atts));
		
		$id = empty($anchor) ? it_get_slug($label, $label) : it_get_slug($anchor, $anchor);
		
		$out = '<div id="' . $id . '" class="content-section-divider" data-label="' . $label . '"></div>';

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
			'name' => __( 'Content Section', IT_TEXTDOMAIN ),
			'value' => 'section',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
