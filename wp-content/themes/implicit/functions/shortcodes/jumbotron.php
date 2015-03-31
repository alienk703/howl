<?php
/**
 *
 */
class itJumbotron {
	
	/**
	 *
	 */
	public static function jumbotron( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Jumbotron', IT_TEXTDOMAIN ),
				'value' => 'jumbotron',
				'options' => array(
				
					array(
						'name' => __( 'Heading', IT_TEXTDOMAIN ),
						'desc' => __( 'This is the main heading of the jumbotron', IT_TEXTDOMAIN ),
						'id' => 'heading',
						'default' => '',
						'type' => 'text'
					),
					array(
						'name' => __( 'Tagline', IT_TEXTDOMAIN ),
						'desc' => __( 'This is the tagline of the jumbotron', IT_TEXTDOMAIN ),
						'id' => 'tagline',
						'default' => '',
						'type' => 'text',
					),
					array(
						'name' => __( 'Content', IT_TEXTDOMAIN ),
						'desc' => __( 'Any additional content such as a call to action button that needs to display under the header and tagline.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),
					
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'heading'      => '',
		    'tagline'      => '',
	    ), $atts));

		$heading = ( $heading ) ? '<h1>'.$heading.'</h1>' : '';
		
		$tagline = ( $tagline ) ? '<p class="tagline">'.$tagline.'</p>' : '';
		
		$content = ( $content ) ? do_shortcode($content) : '';
		
		$out = '<div class="jumbotron">'.$heading.' '.$tagline.' '.$content.'</div>';

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
			'name' => __( 'Jumbotron', IT_TEXTDOMAIN ),
			'value' => 'jumbotron',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
