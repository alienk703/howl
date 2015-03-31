<?php
/**
 *
 */
class itMenu {	
	
	public static function menu( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Utility Menu', IT_TEXTDOMAIN ),
				'value' => 'menu',
				'options' => array(
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the menu.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'type' => 'text'
					),
					array(
						'name' => __( 'Icon', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the title', IT_TEXTDOMAIN ),
						'id' => 'icon',
						'target' => 'icons',
						'type' => 'select'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'title'					=> '',
			'icon'					=> ''
		), $atts));	
		
		$out = '';
		
		#get the utility menu, stripping out title attributes
        $menu = preg_replace('/title=\"(.*?)\"/','',wp_nav_menu( array( 'theme_location' => 'utility-menu', 'container' => false, 'fallback_cb' => false, 'echo' => false ) ) );
    
		do_action('it_before_utility', it_get_setting('ad_utility_before'), 'before-utility');
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>';  

        $out .= '<div class="utility-menu" class="clearfix">';
                    
            $out .= '<div class="utility-menu-full">';
            
                $out .= '<div class="bar-label-wrapper">';
                
                    if(!empty($title) || !empty($icon)) {
            
                        $out .= '<div class="bar-label has-icon">';
                    
                            $out .= '<div class="label-text">';
                            
                                if(!empty($icon)) $out .= '<span class="theme-icon-' . $icon . '"></span>';
                                
                                if(!empty($title)) $out .= $title;
                                
                            $out .= '</div>';
                            
                        $out .= '</div>';
                        
                    }
                    
                    $out .= '<div class="home-button"><a class="styled" href="' . home_url() . '/"><span class="theme-icon-home"></span></a></div>';                       
                    
                $out .= '</div>';
                
                $out .= $menu;                                            
            
            $out .= '</div>';
                
            $out .= '<div class="utility-menu-compact">';
            
                $out .= '<div class="bar-label-wrapper">';
            
                    $out .= '<div class="bar-label has-icon">';
                    
                        $out .= '<ul>';
                    
                            $out .= '<li>';
                    
                                $out .= '<a class="utility-menu-selector" class="label-text">';
                                
                                    if(!empty($icon)) $out .= '<span class="theme-icon-' . $icon . '"></span>';
                                    
                                    if(!empty($title)) $out .= $title;
                                    
                                $out .= '</a>';
                                
                                $out .= $menu;
                            
                            $out .= '</li>';
                        
                        $out .= '</ul>';
                        
                    $out .= '</div>';
                    
                    $out .= '<div class="home-button"><a class="styled" href="' . home_url() . '/"><span class="theme-icon-home"></span></a></div>';                        
                    
                $out .= '</div>';
        
            $out .= '</div>'; 
        
        $out .= '</div>';
        
        do_action('it_after_utility', it_get_setting('ad_utility_after'), 'after-utility');
        
        wp_reset_query();
				
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
			'name' => __( 'Utility Menu', IT_TEXTDOMAIN ),
			'value' => 'menu',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
