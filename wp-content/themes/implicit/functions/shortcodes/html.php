<?php
/**
 *
 */
class itHTML {	
	
	public static function html( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Custom Content', IT_TEXTDOMAIN ),
				'value' => 'html',
				'options' => array(	
					array(
						'name' => __( 'Content', IT_TEXTDOMAIN ),
						'desc' => __( 'This is shortcode and HTML/CSS/Javascript syntax enabled', IT_TEXTDOMAIN ),
						'id' => 'content',
						'type' => 'textarea'
					),					
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(), $atts));
		
		#put the actions into variables
		ob_start();
		do_action('it_before_html', it_get_setting('ad_html_before'), 'before-html');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_html', it_get_setting('ad_html_after'), 'after-html');
		$after = ob_get_contents();
		ob_end_clean();		
		
		$out = '';
		
		$out .= $before;
			
        $out .= '<div class="html-content clearfix">'; 
        
            $out .= do_shortcode(stripslashes($content));                
           
        $out .= '</div>';
        
        $out .= $after;
				
		return $out;
		
	}
		
	/**
	 *
	 */
	public static function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods($class);

		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}

		$options = array(
			'name' => __( 'Custom Content', IT_TEXTDOMAIN ),
			'value' => 'html',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
