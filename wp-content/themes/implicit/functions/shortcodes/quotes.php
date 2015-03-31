<?php
/**
 *
 */
class itQuotes {
	
	/**
	 *
	 */
	public static function blockquote( $atts = null, $content = null ) {
		$option = array( 
			'name' => __( 'Blockquotes', IT_TEXTDOMAIN ),
			'value' => 'blockquote',
			'options' => array(
				array(
					'name' => __( 'Blockquote Content', IT_TEXTDOMAIN ),
					'desc' => __( 'Type out the text that you wish to display with your quote.', IT_TEXTDOMAIN ),
					'id' => 'content',
					'default' => '',
					'type' => 'textarea'
				),
				array(
					'name' => __( 'Align Right', IT_TEXTDOMAIN ),
					'id' => 'right',
					'options' => array( 'pull-right' => __( 'Blockquote should be right-aligned.', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Cite', IT_TEXTDOMAIN ),
					'desc' => __( 'The cite for this blockquote, if any.', IT_TEXTDOMAIN ),
					'id' => 'cite',
					'default' => '',
					'type' => 'text'
				),
			'shortcode_has_atts' => true,
			)
		);
		
		if( $atts == 'generator' )
			return $option;
			
		extract(shortcode_atts(array(
			'cite'		=> '',
			'right'     => ''
		), $atts));
		
		$cite = ( $cite ) ? ' <small><cite title="'.$cite.'">' . $cite . '</cite></small>' : '' ;
		
		$right = ( $right ) ? ' class="'.$right.'"' : '' ;

		$out = '<blockquote' . $right . '><p>' . it_cleanup_shortcode( $content ) . $cite . '</p></blockquote>';
		
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
			'name' => __( 'Blockquote', IT_TEXTDOMAIN ),
			'value' => 'blockquote',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
