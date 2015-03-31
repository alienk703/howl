<?php
/**
 *
 */
class itTable {
	
	/**
	 *
	 */
	public static function table( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Table', IT_TEXTDOMAIN ),
				'value' => 'table',
				'options' => array(
					array(
						'name' => __( 'Table Html', IT_TEXTDOMAIN ),
						'desc' => __( 'Type out the content of your table.  You need to use the HTML table tags when typing out your content.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea'
					),
					array(
						'name' => __( 'Style', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose the style of table you want to use.', IT_TEXTDOMAIN ),
						'id' => 'style',
						'default' => '',
						'options' => array(
							'' => __( 'Default Style', IT_TEXTDOMAIN ),
							'table-striped' => __( 'Striped', IT_TEXTDOMAIN ),
							'table-bordered' => __( 'Bordered', IT_TEXTDOMAIN ),
							'table-hover' => __( 'Hover Rows', IT_TEXTDOMAIN ),
							'table-condensed' => __( 'Condensed', IT_TEXTDOMAIN )
						),
						'type' => 'select',
						'target' => '',
					),
				'shortcode_has_atts' => true,
				'shortcode_carriage_return' => true
				)				
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'style'     => '',
	    ), $atts));
				
		return str_replace( '<table>', '<table class="table '.$style.'">', do_shortcode($content) );
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
			'name' => __( 'Table', IT_TEXTDOMAIN ),
			'value' => 'table',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
