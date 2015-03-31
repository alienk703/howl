<?php
/**
 *
 */
class itButtons {
	
	/**
	 *
	 */
	public static function button( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {			
			$option = array( 
				'name' => __( 'Button', IT_TEXTDOMAIN ),
				'value' => 'button',
				'options' => array(
				
					array(
						'name' => __( 'Button Text', IT_TEXTDOMAIN ),
						'desc' => __( 'This is the text that will appear on your button.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'text'
					),
					array(
						'name' => __( 'Button Type', IT_TEXTDOMAIN ),
						'desc' => __( "Use button as the type if you don't want it to take the user to an external page (i.e. if you want to use the button in conjunction with a modal dialog box or a popover for instance).", IT_TEXTDOMAIN ),
						'id' => 'type',
						'default' => 'link',
						'options' => array( 
							'link' => __('Link', IT_TEXTDOMAIN ),
							'button' => __('Button', IT_TEXTDOMAIN )
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Link Url', IT_TEXTDOMAIN ),
						'desc' => __( 'Paste a URL here to use as a link for the button (only applies to button type of Link).', IT_TEXTDOMAIN ),
						'id' => 'link',
						'default' => '',
						'type' => 'text',
					),
					array(
						'name' => __( 'Size', IT_TEXTDOMAIN ),
						'desc' => __( 'You can choose between four sizes for your button.', IT_TEXTDOMAIN ),
						'id' => 'size',
						'default' => '',
						'options' => array(
							'btn-xs' => __('Extra Small', IT_TEXTDOMAIN ),
							'btn-sm' => __('Small', IT_TEXTDOMAIN ),
							'' => __('Medium', IT_TEXTDOMAIN ),
							'btn-lg' => __('Large', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Style Variations', IT_TEXTDOMAIN ),
						'desc' => __( 'Choose one of the predefined button styles to use.', IT_TEXTDOMAIN ),
						'id' => 'variation',
						'default' => '',
						'options' => array(
							'btn-default' => __('Default', IT_TEXTDOMAIN ),
							'btn-primary' => __('Primary', IT_TEXTDOMAIN ),
							'btn-info' => __('Info', IT_TEXTDOMAIN ),
							'btn-success' => __('Success', IT_TEXTDOMAIN ),
							'btn-warning' => __('Warning', IT_TEXTDOMAIN ),
							'btn-danger' => __('Danger', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Block', IT_TEXTDOMAIN ),
						'id' => 'block',
						'options' => array( 'btn-block' => __( 'Button should be block-level (wide)', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),					
					array(
						'name' => __( 'Target', IT_TEXTDOMAIN ),
						'desc' => __( "Opens the link in a new tab when the reader clicks on the button (only applies to button type of Link).", IT_TEXTDOMAIN ),
						'id' => 'target',
						'options' => array( 'blank' => __('Blank', IT_TEXTDOMAIN )),
						'type' => 'checkbox',
					),
				'shortcode_has_atts' => true,
				)
			);
		
			return $option;
		}
			
		extract(shortcode_atts(array(
			'size'      => '',
		    'link'      => '',
			'target'    => '',
			'variation'	=> '',
			'type'      => '',
			'block'     => ''
	    ), $atts));

		$target = ( $target == 'blank' ) ? 'target="_blank"' : '';
		
		if($type=='link') {
		
			$out = '<a role="button" href="' . esc_url( $link ) . '" class="btn ' . $size . ' ' . $variation . ' ' . $block . '" ' . $target . '>' . it_cleanup_shortcode( $content ) . '</a>';
			
		} else {
			
			$out = '<button type="button" class="btn ' . $size . ' ' . $variation . ' ' . $block . '">' . it_cleanup_shortcode( $content ) . '</button>';
			
		}

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
			'name' => __( 'Buttons', IT_TEXTDOMAIN ),
			'value' => 'button',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>
