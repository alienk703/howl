<?php
/**
 *
 */
class itCarousel {
	
	/**
	 *
	 */
	public static function carousel( $atts = null, $content = null, $code = null ) {
		if( $atts == 'generator' ) {
			$numbers = range(1,50);

			$option = array( 
				'name' => __( 'Carousel', IT_TEXTDOMAIN ),
				'value' => 'carousel',
				'options' => array(
					array(
						'name' => __( 'Display Nav Arrows', IT_TEXTDOMAIN ),
						'id' => 'arrows',
						'options' => array( 'display' => __( 'Display the navigation arrows', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox',
						'shortcode_dont_multiply' => true
					),	
					array(
						'name' => __( 'Display Nav Buttons', IT_TEXTDOMAIN ),
						'id' => 'buttons',
						'options' => array( 'display' => __( 'Display the navigation buttons in the top right corner', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox',
						'shortcode_dont_multiply' => true
					),				
					array(
						'name' => __( 'Display Caption', IT_TEXTDOMAIN ),
						'id' => 'caption',
						'options' => array( 'display' => __( 'Display the caption overlay', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox',
						'shortcode_dont_multiply' => true
					),
					array(
						'name' => __( 'Interval', IT_TEXTDOMAIN ),
						'desc' => __( 'The number of seconds to pause between auto-scrolling the carousel.', IT_TEXTDOMAIN ),
						'id' => 'interval',
						'target' => 'seconds',
						'type' => 'select',
						'shortcode_dont_multiply' => true
					),
					array(
						'name' => __( 'Number of Panels', IT_TEXTDOMAIN ),
						'desc' => __( 'Select the number of panels you want in this carousel. Each one will represent a unique panel to rotate through in the carousel.', IT_TEXTDOMAIN ),
						'id' => 'multiply',
						'default' => '',
						'options' => $numbers,
						'type' => 'select',
						'target' => '',
						'shortcode_multiplier' => true
					),
					array(
						'name' => __( 'Panel 1 Title', IT_TEXTDOMAIN ),
						'desc' => __( 'The text to use for the title in the carousel caption.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'default' => '',
						'type' => 'text',
						'shortcode_multiply' => true
					),
					array(
						'name' => __( 'Panel 1 Description', IT_TEXTDOMAIN ),
						'desc' => __( 'The text to use for the description under the title in the carousel caption.', IT_TEXTDOMAIN ),
						'id' => 'description',
						'default' => '',
						'type' => 'text',
						'shortcode_multiply' => true
					),
					array(
						'name' => __( 'Panel 1 Content', IT_TEXTDOMAIN ),
						'desc' => __( 'The content to use for the carousel panel.', IT_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea',
						'shortcode_multiply' => true
					),					
					array(
						'value' => 'panel',
						'nested' => true
					),
				'shortcode_has_atts' => true,
				)
			);

			return $option;
		}
		
		extract(shortcode_atts(array(
			'arrows'     => '',
			'buttons'    => '',
		    'caption'  => '',
			'interval' => '',
	    ), $atts));
		
		if (!preg_match_all("/(.?)\[(panel)\b(.*?)(?:(\/))?\](?:(.+?)\[\/panel\])?(.?)/s", $content, $matches)) {
			return it_cleanup_shortcode( $content );
		} else {
			
			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
			}
						
			$id = rand();
			
			$interval = ( $interval && $interval!='0' ) ? ' data-interval="'.$interval.'000"' : ' data-interval="false"';
			
			$arrowsout = '';
			if($arrows == 'display') {					
				$arrowsout .= '<a class="left carousel-control no-scroll" href="#carousel_'.$id.'" data-slide="prev"><span class="theme-icon-left-open"></span></a>';
				$arrowsout .= '<a class="right carousel-control no-scroll" href="#carousel_'.$id.'" data-slide="next"><span class="theme-icon-right-open"></span></a>';				
			}
			
			$out = '<div id="carousel_'.$id.'" class="carousel slide"'.$interval.' data-ride="carousel">';
			
				if($buttons == 'display') {
					
					$out .= '<ol class="carousel-indicators">';
					
						for($i = 0; $i < count($matches[0]); $i++) {
							$active='';
							if($i==0) $active=' class="active"';
							$out .= '<li data-target="#carousel_'.$id.'" data-slide-to="'.$i.'"'.$active.'></li>';
						}
					
					$out .= '</ol>';
					
				}
				
				$out .= '<div class="carousel-inner">';
				
					for($i = 0; $i < count($matches[0]); $i++) {
						$active='';
						if($i==0) $active=' active';
						$title = ( isset($matches[3][$i]['title']) ) ? '<h4>'.$matches[3][$i]['title'].'</h4>' : '';
						$description = ( isset($matches[3][$i]['description']) ) ? '<p>'.$matches[3][$i]['description'].'</p>' : '';
						
						$out .= '<div class="item'.$active.'">' . it_cleanup_shortcode( $matches[5][$i] );
						
						if($caption == 'display' && (!empty($title) || !empty($description))) $out .= '<div class="carousel-caption">'.$title.$description.'</div>';							
						
						$out .= '</div>';						
					}
				
				$out .= '</div>';
				
				$out .= $arrowsout;
			
			$out .= '</div>';
			
			return $out;
		}
		
	}
		
	/**
	 *
	 */
	public static function _options($class) {
		$shortcode = array();
		
		$class_methods = get_class_methods( $class );
		
		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}
		
		$options = array(
			'name' => __( 'Carousel', IT_TEXTDOMAIN ),
			'value' => 'carousel',
			'options' => $shortcode,
		);
		
		return $options;
	}
	
}

?>
