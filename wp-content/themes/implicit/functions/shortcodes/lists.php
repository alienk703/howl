<?php
/**
 *
 */
class itLists {
	
	/**
	 *
	 */
	public static function lists( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'List', IT_TEXTDOMAIN ),
				'value' => 'lists',
				'options' => array(
					array(
						'name' => __( 'Type', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose the style of list that you wish to use.  Each one has a different icon.', IT_TEXTDOMAIN ),
						'id' => 'style',
						'default' => '',
						'options' => array(
							'plus' => __( 'Plus List', IT_TEXTDOMAIN ),
							'liked' => __( 'Heart List', IT_TEXTDOMAIN ),
							'star' => __( 'Star List', IT_TEXTDOMAIN ),
							'check' => __( 'Check List', IT_TEXTDOMAIN ),
							'right-thin' => __( 'Arrow Thin List', IT_TEXTDOMAIN ),
							'right-fat' => __( 'Arrow Thick List', IT_TEXTDOMAIN ),
							'right-open' => __( 'Arrow Open List', IT_TEXTDOMAIN ),
							'x' => __( 'X List', IT_TEXTDOMAIN ),
							'tag' => __( 'Tag List', IT_TEXTDOMAIN ),
							'help-circled' => __( 'Question List', IT_TEXTDOMAIN ),
							'info-circled' => __( 'Info List', IT_TEXTDOMAIN ),
							'attention' => __( 'Attention List', IT_TEXTDOMAIN ),
							'minus' => __( 'Minus List', IT_TEXTDOMAIN ),
							'pencil' => __( 'Pencil List', IT_TEXTDOMAIN ),
							'thumbs-up' => __( 'Thumbs-Up List', IT_TEXTDOMAIN )
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Icon Color', IT_TEXTDOMAIN ),
						'desc' => __( 'The color of the icon image used in the list.', IT_TEXTDOMAIN ),
						'id' => 'color',
						'type' => 'color'
					),	
					array(
						'name' => __( 'List Html', IT_TEXTDOMAIN ),
						'desc' => __( 'Type out the content of your list.  You need to use the &#60;ul&#62; and &#60;li&#62; elements when typing out your list content.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea',
						'return' => true
					),
				'shortcode_has_atts' => true,
				'shortcode_carriage_return' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'style'     => '',
			'color'	    => '',
	    ), $atts));
	
		$style = ( $style ) ? '<span class="theme-icon-'.$style.'" style="color:'.$color.'"></span> ' : '';

		$content = str_replace( '<ul>', '<ul class="styled_list">', $content );
		$content = str_replace( '<li>', '<li>' . $style , $content );
	
		return it_cleanup_shortcode( $content );
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
			'name' => __( 'Lists', IT_TEXTDOMAIN ),
			'value' => 'lists',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
