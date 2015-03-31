<?php
/**
 *
 */
class itVideo {
	
	private static $video_id = 1;
	
	/**
	 *
	 */
	function _video_id() {
	    return self::$video_id++;
	}
	
	/**
	 * http://code.google.com/intl/en/apis/youtube/player_parameters.html
	 */
	public static function youtube( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'YouTube', IT_TEXTDOMAIN ),
				'value' => 'youtube',
				'options' => array(
					array(
						'name' => __( 'YouTube Video URL', IT_TEXTDOMAIN ),
						'desc' => __( 'When viewing your youtube video in your web browser copy the URL and paste it here.  Here is an example of what it might look like,<br /><br />http://www.youtube.com/watch?v=SX728EemOPOIw&feature=related', IT_TEXTDOMAIN ),
						'id' => 'url',
						'default' => '',
						'type' => 'text'
					),					
					array(
						'name' => __( 'Autohide', IT_TEXTDOMAIN ),
						'id' => 'autohide',
						'options' => array(
							'0' => __( 'Visible', IT_TEXTDOMAIN ),
							'1' => __( 'Hide all', IT_TEXTDOMAIN ),
							'2' => __( 'Hide video progress bar', IT_TEXTDOMAIN ),
						),
						'type' => 'select',
						'target' => '',
					),
					array(
						'name' => __( 'Autoplay', IT_TEXTDOMAIN ),
						'id' => 'autoplay',
						'options' => array( '1' => __( 'Video will autoplay when the player loads', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Controls', IT_TEXTDOMAIN ),
						'id' => 'controls',
						'options' => array( '0' => __( 'Disable video player controls', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Disable KB', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Disable the player keyboard controls', IT_TEXTDOMAIN ) ),
						'id' => 'disablekb',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Fullscreen', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Enables the fullscreen button in the video player', IT_TEXTDOMAIN ) ),
						'id' => 'fs',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'HD', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Enables HD video playback by default', IT_TEXTDOMAIN ) ),
						'id' => 'hd',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Loop', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Play the initial video again as soon as it ends', IT_TEXTDOMAIN ) ),
						'id' => 'loop',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Related Videos', IT_TEXTDOMAIN ),
						'options' => array( '0' => __( 'Disable related videos once playback of the initial video starts', IT_TEXTDOMAIN ) ),
						'id' => 'rel',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Search', IT_TEXTDOMAIN ),
						'options' => array( '0' => __( 'Disable the search box from displaying when the video is minimized', IT_TEXTDOMAIN ) ),
						'id' => 'showsearch',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Info', IT_TEXTDOMAIN ),
						'options' => array( '0' => __( 'Disable display information', IT_TEXTDOMAIN ) ),
						'id' => 'showinfo',
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'url' 		=> false,
			'autohide'  => '2',
			'autoplay'  => '0',
			'controls'  => '1',
			'disablekb' => '0',
			'fs'        => '0',
			'hd'        => '0',
			'loop'      => '0',
			'rel'       => '1',
			'showsearch'=> '1',
			'showinfo'  => '1',
			'width'     => '',
			'height'    => '',
			'frame'     => true
		), $atts));
		
		if( !$url )
			return __( 'Please enter the url to a YouTube video.', IT_TEXTDOMAIN );
			
		if ( preg_match( '/^https?\:\/\/(?:(?:[a-zA-Z0-9\-\_\.]+\.|)youtube\.com\/watch\?v\=|youtu\.be\/)([a-zA-Z0-9\-\_]+)/i', $url, $matches ) > 0 )
	        $video_id = $matches[1];
	
	    elseif ( preg_match('/^([a-zA-Z0-9\-\_]+)$/i', $url, $matches ) > 0 )
	        $video_id = $matches[1];
	
		if( !isset( $video_id ) )
			return __( 'There was an error retrieving the YouTube video ID for the url you entered, please verify that the url is correct.', IT_TEXTDOMAIN );
		
		$fullscreen = $fs=='0' ? '' : 'allowfullscreen';
			
		$_video_id = self::_video_id();
		
		$video = '';
		
		if($frame) $video .= '<div class="video_frame">';
		
		$video .= "<iframe id='youtube_video_$_video_id' class='youtube_video' src='https://www.youtube.com/embed/{$video_id}?autohide={$autohide}&amp;autoplay={$autoplay}&amp;controls={$controls}&amp;disablekb={$disablekb}&amp;hd={$hd}&amp;loop={$loop}&amp;rel={$rel}&amp;showinfo={$showinfo}&amp;showsearch={$showsearch}&amp;wmode=transparent&amp;enablejsapi=1' width='{$width}' height='{$height}'" . $fullscreen . "></iframe>";
		
		if($frame) $video .= '</div>';
				
		return $video;
		
	}
	
	/**
	 * http://vimeo.com/api/docs/player
	 */
	public static function vimeo( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Vimeo', IT_TEXTDOMAIN ),
				'value' => 'vimeo',
				'options' => array(
					array(
						'name' => __( 'Vimeo Video URL', IT_TEXTDOMAIN ),
						'desc' => __( 'When viewing your vimeo video in your web browser copy the URL and paste it here.  Here is an example of what it might look like,<br /><br />http://vimeo.com/12345678', IT_TEXTDOMAIN ),
						'id' => 'url',
						'default' => '',
						'type' => 'text'
					),					
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Show the title on the video', IT_TEXTDOMAIN ) ),
						'id' => 'title',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Byline', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Show the byline on the video', IT_TEXTDOMAIN ) ),
						'id' => 'byline',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Portrait', IT_TEXTDOMAIN ),						
						'options' => array( '1' => __( "Show user's portrait on the video", IT_TEXTDOMAIN ) ),
						'id' => 'portrait',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Autoplay', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Play the video automatically on load', IT_TEXTDOMAIN ) ),
						'id' => 'autoplay',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Loop', IT_TEXTDOMAIN ),
						'options' => array( '1' => __( 'Play the video again when it reaches the end', IT_TEXTDOMAIN ) ),
						'id' => 'loop',
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'url' 		=> false,
			'title'     => '0',
			'byline'    => '0',
			'portrait'  => '0',
			'autoplay'  => '0',
			'loop'      => '0',
			'width'     => '',
			'height'    => '',
			'frame'     => true
		), $atts));
		
		
		if( !$url )
			return __( 'Please enter the url to a Vimeo video.', IT_TEXTDOMAIN );
			
		if ( preg_match( '#https?://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches ) > 0 )
	        $video_id = $matches[3];
	
	    elseif ( preg_match('/^([a-zA-Z0-9\-\_]+)$/i', $url, $matches ) > 0 )
	        $video_id = $matches[1];
	
		if( !isset( $video_id ) )
			return __( 'There was an error retrieving the Vimeo video ID for the url you entered, please verify that the url is correct.', IT_TEXTDOMAIN );
			
		$_video_id = self::_video_id();
		
		$video = '';
		
		if($frame) $video .= '<div class="video_frame">';
		
		$video .= "<iframe id='vimeo_video_$_video_id' class='vimeo_video' src='http://player.vimeo.com/video/{$video_id}?badge=0&amp;title={$title}&amp;byline={$byline}&amp;portrait={$portrait}&amp;autoplay={$autoplay}&amp;loop={$loop}' width='{$width}' height='{$height}' webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder='0'></iframe>";		
		
		if($frame) $video .= '</div>';
		
		return $video;
		
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
			'name' => __( 'Video', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose which type of video you wish to use.', IT_TEXTDOMAIN ),
			'value' => 'video',
			'options' => $shortcode,
			'shortcode_has_types' => true
		);

		return $options;
	}

}

?>
